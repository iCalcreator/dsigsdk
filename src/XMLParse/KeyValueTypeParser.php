<?php
/**
 * DsigSdk    the PHP XML Digital Signature recommendation SDK,
 *            source http://www.w3.org/2000/09/xmldsig#
 *
 * This file is a part of DsigSdk.
 *
 * @author    Kjell-Inge Gustafsson, kigkonsult <ical@kigkonsult.se>
 * @copyright 2019-2022 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
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

use Kigkonsult\DsigSdk\Dto\KeyValue;
use XMLReader;

/**
 * Class KeyValueTypeParser
 */
class KeyValueTypeParser extends DsigParserBase
{
    /**
     * Parse
     *
     * @return KeyValue
     */
    public function parse() : KeyValue
    {
        $keyValue = KeyValue::factory()->setXMLattributes( $this->reader );
        $this->logDebug1( __METHOD__ );
        if( $this->reader->hasAttributes ) {
            $this->processNodeAttributes( $keyValue );
        }
        if( ! $this->reader->isEmptyElement ) {
            $this->processSubNodes( $keyValue );
        }
        $this->logDebug4( __METHOD__ );
        return $keyValue;
    }

    /**
     * @param KeyValue $keyValue
     */
    private function processNodeAttributes( KeyValue $keyValue ) : void
    {
        while( $this->reader->moveToNextAttribute()) {
            $this->logDebug2( __METHOD__ );
            if( KeyValue::isXmlAttrKey( $this->reader->localName )) {
                $keyValue->setXMLattribute( $this->reader->localName, $this->reader->value );
            }
        } // end while
        $this->reader->moveToElement();
    }

    /**
     * @param KeyValue $keyValue
     */
    protected function processSubNodes( KeyValue $keyValue ) : void
    {
        $headElement = $this->reader->localName;
        while( @$this->reader->read()) {
            if( XMLReader::SIGNIFICANT_WHITESPACE !== $this->reader->nodeType ) {
                $this->logDebug4( __METHOD__ );
            }
            switch( true ) {
                case ( XMLReader::END_ELEMENT === $this->reader->nodeType ) :
                    if( $headElement === $this->reader->localName ) {
                        break 2;
                    }
                    break;
                case ( XMLReader::ELEMENT !== $this->reader->nodeType ) :
                    break;
                case ( self::DSAKEYVALUE === $this->reader->localName ) :
                    $keyValue->setDSAKeyValue( DSAKeyValueTypeParser::factory( $this->reader)->parse());
                    break;
                case ( self::RSAKEYVALUE === $this->reader->localName ) :
                    $keyValue->setRSAKeyValue( RSAKeyValueTypeParser::factory( $this->reader)->parse());
                    break;
                default :
                    $keyValue->setAny( AnyTypeParser::factory( $this->reader)->parse());
                    break;
            }  // end switch
        }  // end while
    }
}
