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

use Exception;
use DOMNode;
use InvalidArgumentException;
use Kigkonsult\LoggerDepot\LoggerDepot;
use Kigkonsult\DsigSdk\Dto\SignatureType;
use Psr\Log\LoggerInterface;
use RuntimeException;
use XMLReader;

use function count;
use function file_get_contents;
use function libxml_clear_errors;
use function libxml_get_errors;
use function libxml_disable_entity_loader;
use function libxml_use_internal_errors;
use function sprintf;

/**
 * Class DsigParser
 */
class DsigParser extends DsigParserBase
{
    use LibXmlUtilTrait;

    /**
     * Parse from file
     *
     * @param string    $fileName
     * @param null|bool $asDomNode
     * @return SignatureType|DOMNode
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function parseXmlFromFile( string $fileName, $asDomNode = false )
    {
        self::assertIsValidXML( $fileName );
        $content = $this->getContentFromFile( $fileName );
        $this->logger->debug( 'Got content from ' . $fileName );
        return $this->parse( $content, $asDomNode );
    }

    /**
     * Parse from string, alias of method parse
     *
     * @param string    $xml
     * @param null|bool $asDomNode
     * @return SignatureType|DOMNode
     * @throws Exception
     */
    public function parseXmlFromString( string $xml, $asDomNode = false )
    {
        return $this->parse( $xml, $asDomNode );
    }

    /**
     * Return the content from an XML file
     * clean up the content, checking internal documentation
     *   with decoded html characters (i.e. hide the '&'+';'-char)
     * @param string $fileName
     * @return string
     * @throws InvalidArgumentException
     */
    private static function getContentFromFile( string $fileName ) : string
    {
        static $FMTerr      = 'Error reading %s';
        if( false === ( $content = @file_get_contents( $fileName ))) {
            throw new InvalidArgumentException( sprintf( $FMTerr, $fileName ));
        }
        /*
        static $_XMLpattern = '/&(?!;{6})/';
        static $_XMLreplace = '&amp;';
        return preg_replace( $opCfg->getCfg( $_XMLpattern ),
                             $opCfg->getCfg( $_XMLreplace ),
                             $content);
        */
        return $content;
    }

    /**
     * Parse xml-string
     *
     * @param string    $xml
     * @param null|bool $asDomNode
     * @return SignatureType|DOMNode
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function parse( string $xml, $asDomNode = false )
    {
        static $FMTerr1 = 'Error #%d parsing xml';
        static $FMTerr2 = 'Unknown xml root element \'%s\'';
        static $FMTerr3 = 'No xml root element found';
        $this->reader   = new XMLReader();
        $loadEntities         = libxml_disable_entity_loader( true );
        $useInternalXmlErrors = libxml_use_internal_errors( true ); // enable user error handling
        if( false === $this->reader->XML( $xml, null, self::$XMLReaderOptions )) {
            throw new InvalidArgumentException( sprintf( $FMTerr1, 1 ));
        }
        else {
            $result = null;
            while( @$this->reader->read() ) {
                if( XMLReader::SIGNIFICANT_WHITESPACE != $this->reader->nodeType ) {
                    $this->logger->debug(
                        sprintf( self::$FMTreadNode, __METHOD__, self::$nodeTypes[$this->reader->nodeType],
                                 $this->reader->localName
                        )
                    );
                }
                switch( true ) {
                    case ( XMLReader::ELEMENT != $this->reader->nodeType ) :
                        break;
                    case ( self::SIGNATURE == $this->reader->localName ) :
                        if( $asDomNode ) {
                            $result = $this->reader->expand();
                            break 2;
                        }
                        $result = SignatureTypeParser::factory( $this->reader )->parse();
                        break;
                    default :
                        throw new RuntimeException( sprintf( $FMTerr2, $this->reader->localName ) );
                } // end switch
            } // end while
        } // end else
        $libxmlErrors = libxml_get_errors();
        libxml_disable_entity_loader( $loadEntities );
        libxml_use_internal_errors( $useInternalXmlErrors ); // disable user error handling
        libxml_clear_errors();
        $libXarr = self::renderXmlError( $libxmlErrors, null, $xml );
        if( 0 < count( $libXarr )) {
            if( self::LogLibxmlErrors( LoggerDepot::getLogger( get_class()), $libXarr )) {
                throw new RuntimeException( sprintf( $FMTerr1, 2 ));
            }
        }
        $this->reader->close();
        if( empty( $result )) {
            throw new RuntimeException( $FMTerr3 );
        }
        return $result;
    }

    /**
     * Log libxml error
     *
     * @param LoggerInterface $logger
     * @param array           $libXarr
     * @return bool           true on critical
     */
    private static function LogLibxmlErrors( LoggerInterface $logger, array $libXarr ) : bool
    {
        $critical = false;
        foreach( $libXarr as $errorSets ) {
            foreach( $errorSets as $logLevel => $msg ) {
                $logger->log( $logLevel, $msg );
                if( self::CRITICAL == $logLevel ) {
                    $critical = true;
                }
            } // end foreach
        } // end foreach
        return $critical;
    }
}
