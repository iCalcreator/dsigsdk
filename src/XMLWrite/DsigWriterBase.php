<?php
/**
 * DsigSdk   the PHP XML Digital Signature recomendation SDK,
 *           source http://www.w3.org/2000/09/xmldsig#
 *
 * This file is a part of DsigSdk.
 *
 * Copyright 2019-21 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * author    Kjell-Inge Gustafsson, kigkonsult
 * Link      https://kigkonsult.se
 * Package   DsigSdk
 * Version   0.9.8
 * License   Subject matter of licence is the software DsigSdk.
 *           The above copyright, link, package and version notices,
 *           this licence notice shall be included in all copies or substantial
 *           portions of the DsigSdk.
 *
 *           DsigSdk is free software: you can redistribute it and/or modify
 *           it under the terms of the GNU Lesser General Public License as published
 *           by the Free Software Foundation, either version 3 of the License,
 *           or (at your option) any later version.
 *
 *           DsigSdk is distributed in the hope that it will be useful,
 *           but WITHOUT ANY WARRANTY; without even the implied warranty of
 *           MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *           GNU Lesser General Public License for more details.
 *
 *           You should have received a copy of the GNU Lesser General Public License
 *           along with DsigSdk. If not, see <https://www.gnu.org/licenses/>.
 */
namespace Kigkonsult\DsigSdk\XMLWrite;

use Kigkonsult\DsigSdk\DsigBase;
use XMLWriter;

use function get_called_class;
use function sprintf;
use function substr;

/**
 * Class DsigWriterBase
 */
abstract class DsigWriterBase extends DsigBase
{
    /**
     * const XML Schema keys
     */
    const XMLSchemaKeys = [ self::XMLNS, self::XMLNS_XSI, self::XMLNS_XSD, self::XSI_SCHEMALOCATION ];

    /**
     * @var XMLWriter
     */
    protected $writer = null;

    /**
     * Constructor
     *
     * @param XMLWriter $writer
     */
    public function __construct( XMLWriter $writer = null ) {
        parent::__construct();
        if( null !== $writer ) {
            $this->writer = $writer;
        }
    }

    /**
     * Factory
     *
     * @param XMLWriter $writer
     * @return static
     * @static
     */
    public static function factory( $writer = null ) {
        $class = get_called_class();
        return new $class( $writer );
    }

    /**
     * Set writer start element, incl opt XML-attributes
     *
     * @param XMLWriter $writer
     * @param string    $elementName
     * @param array     $XMLattributes
     * @static
     */
    protected static function SetWriterStartElement( XMLWriter $writer, $elementName = null, array $XMLattributes = [] ) {
        $FMTNAME = '%s:%s';
        if( empty( $elementName )) {
            $elementName = $XMLattributes[self::LOCALNAME];
        }
        if( isset( $XMLattributes[self::PREFIX] ) && ! empty( $XMLattributes[self::PREFIX] )) {
            $elementName = sprintf( $FMTNAME, $XMLattributes[self::PREFIX], $elementName );
        }
        $writer->startElement( $elementName );
        foreach( $XMLattributes as $key => $value ) {
            if( in_array( $key, self::XMLSchemaKeys ) ||
                ( self::XMLNS == substr( $key, 0, 5 ))) {
                self::writeAttribute( $writer, $key, $value );
            }
        }
    }

    /**
     * Write attribute
     *
     * @param XMLWriter   $writer
     * @param string      $elementName
     * @param null|string $value
     * @static
     */
    protected static function writeAttribute( XMLWriter $writer, $elementName, $value = null ) {
        if( null !==  $value ) {
            $writer->startAttribute($elementName );
            $writer->text( $value );
            $writer->endAttribute();
        }
    }
}
