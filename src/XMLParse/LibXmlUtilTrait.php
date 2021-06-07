<?php
/**
 * DsigSdk    the PHP XML Digital Signature recommendation SDK,
 *            source http://www.w3.org/2000/09/xmldsig#
 *
 * This file is a part of DsigSdk.
 *
 * @author    Kjell-Inge Gustafsson, kigkonsult <ical@kigkonsult.se>
 * @copyright 2019-21 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * @link      https://kigkonsult.se
 * @license   Subject matter of licence is the software DsigSdk.
 *            The above copyright, link, package and version notices,
 *            this licence notice shall be included in all copies or substantial
 *            portions of the DsigSdk.
 *
 *            DsigSdk is free software: you can redistribute it and/or modify
 *            it under the terms of the GNU Lesser General Public License as published
 *            by the Free Software Foundation, either version 3 of the License,
 *            or (at your option) any later version.
 *
 *            DsigSdk is distributed in the hope that it will be useful,
 *            but WITHOUT ANY WARRANTY; without even the implied warranty of
 *            MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *            GNU Lesser General Public License for more details.
 *
 *            You should have received a copy of the GNU Lesser General Public License
 *            along with DsigSdk. If not, see <https://www.gnu.org/licenses/>.
 */
declare( strict_types = 1 );
namespace Kigkonsult\DsigSdk\XMLParse;

use InvalidArgumentException;

use function basename;
use function explode;
use function file_get_contents;
use function libxml_clear_errors;
use function libxml_use_internal_errors;
use function simplexml_load_file;
use function sprintf;
use function str_repeat;
use function trim;
use function var_export;

/**
 * Trait LibXmlUtilTrait
 */
trait LibXmlUtilTrait
{

    /**
     * @var int
     *           libxml default options
     *             LIBXML_NONET          Disable network access when loading documents
     *             LIBXML_NOERROR        Suppress error reports
     *             LIBXML_NOWARNING      Suppress warning reports
     *             LIBXML_NSCLEAN        Remove redundant namespace declarations
     *             LIBXML_HTML_NODEFDTD  Sets HTML_PARSE_NODEFDTD flag, which prevents a default doctype being added when one is not found. ??
     */
    public static $XMLReaderOptions = LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING | LIBXML_NSCLEAN | LIBXML_HTML_NODEFDTD;
    // LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING | LIBXML_NSCLEAN;

    /**
     * Assert XML from file
     *
     * @param string $fileName
     * @return bool
     * @throws InvalidArgumentException
     */
    public static function assertIsValidXML( string $fileName ) : bool
    {
        static $CLASS  = 'SimpleXMLElement';
        static $FMTerr = 'Error validating %s, errors: %s';
        $useInternalXmlErrors = libxml_use_internal_errors( true ); // enable user error handling
        if( false === simplexml_load_file( $fileName, $CLASS, self::$XMLReaderOptions )) {
            throw new InvalidArgumentException(
                sprintf(
                    $FMTerr,
                    basename( $fileName ),
                    var_export( self::renderXmlError( libxml_get_errors(), $fileName ), true )
                )
            );
        }
        libxml_use_internal_errors( $useInternalXmlErrors ); // disable user error handling
        libxml_clear_errors();
        return true;
    }

    /*
     * Return rendered (array) XML error
     *
     * @param array $errors   array of libxml error object
     * @param null|string $fileName
     * @param null|string $content
     * @return array   [ *(logLevel => msg)]
     * @see http://php.net/manual/en/function.libxml-get-errors.php
     */
    private static function renderXmlError(
        array $errors,
        $fileName = null,
        $content = null
    ) : array
    {
        static $CRITICAL = 'critical'; // MUST correspond to Psr\Log\LogLevel
        static $WARNING  = 'warning';  // "-
        static $INFO     = 'info';     // "-
        static $SP0      = '';
        static $FMT0     = ' No XML to parse';
        static $FMT1     = ' %s #%d, errCode %s : %s';
        static $FMT2     = ' line: %d col: %d';
        static $FMT3     = '%s%s%s%s^%s';
        static $D        = '-';
        static $LIBXML_Warning           = 'LIBXML Warning';
        static $LIBXML_recoverable_Error = 'LIBXML (recoverable) Error';
        static $LIBXML_Fatal_Error       = 'LIBXML Fatal Error';
        if( empty( $errors )) {
            return [];
        }
        if( empty( $content )) {
            if( empty( $fileName )) {
                return [ $CRITICAL => $FMT0 ];
            }
            $content = @file_get_contents( $fileName );
        }
        $xml     = ( false !== $content ) ? explode( PHP_EOL, $content ) : false;
        $libXarr = [];
        $baseFileName = empty( $fileName ) ? $SP0 : basename( $fileName );
        foreach( $errors as $ex => $error ) {
            $str1   = sprintf(
                $FMT1, $baseFileName, ( $ex + 1 ), $error->code, trim( $error->message )
            );
            $str2   = sprintf( $FMT2, $error->line, $error->column );
            if( false !== $xml ) {
                $lineNo = ( 0 < $error->line ) ? ( $error->line - 1 ) : 0;
                $str2   .= sprintf(
                    $FMT3, PHP_EOL, $xml[$lineNo], PHP_EOL, str_repeat( $D, $error->column ), PHP_EOL
                );
            }
            switch( $error->level ) {
                case LIBXML_ERR_WARNING:    // 1
                    $str3     = $LIBXML_Warning;
                    $logLevel = $WARNING;
                    break;
                case LIBXML_ERR_ERROR:      // 2
                    $str3     = $LIBXML_recoverable_Error;
                    $logLevel = ( 522 == $error->code ) ? $INFO : $WARNING; // Validation failed: no DTD found !
                    break;
                case LIBXML_ERR_FATAL:      // 3
                default :
                    $str3     = $LIBXML_Fatal_Error;
                    $logLevel = $CRITICAL;
                    break;
            } // end switch
            $libXarr[$ex][$logLevel] = $str3 . $str1;
            $libXarr[$ex][$INFO]     = $str3 . $str2;
        }  // end foreach
        return $libXarr;
    }
}
