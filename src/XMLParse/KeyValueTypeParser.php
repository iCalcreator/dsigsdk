<?php
/**
 * DsigSdk   the PHP XML Digital Signature recomendation SDK, 
 *           source http://www.w3.org/2000/09/xmldsig#
 *
 * copyright (c) 2019 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * Link      https://kigkonsult.se
 * Package   DsigSdk
 * Version   0.95
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
 *
 * This file is a part of DsigSdk.
 */
namespace Kigkonsult\DsigSdk\XMLParse;

use Kigkonsult\DsigSdk\Dto\KeyValueType;
use XMLReader;

use function sprintf;

/**
 * Class KeyValueTypeParser
 */
class KeyValueTypeParser extends DsigParserBase
{

    /**
     * Parse
     *
     * @return KeyValueType
     */
    public function parse() {
        $keyValueType = KeyValueType::factory()->setXMLattributes( $this->reader );
        $this->logger->debug(
            sprintf( self::$FMTnodeFound, __METHOD__, self::$nodeTypes[$this->reader->nodeType], $this->reader->localName )
        );
        if( $this->reader->isEmptyElement ) {
            return $keyValueType;
        }
        $headElement = $this->reader->localName;
        while( @$this->reader->read()) {
            if( XMLReader::SIGNIFICANT_WHITESPACE != $this->reader->nodeType ) {
                $this->logger->debug(
                    sprintf( self::$FMTreadNode, __METHOD__, self::$nodeTypes[$this->reader->nodeType], $this->reader->localName )
                );
            }
            switch( true ) {
                case ( XMLReader::END_ELEMENT == $this->reader->nodeType ) :
                    if( $headElement == $this->reader->localName ) {
                        break 2;
                    }
                    break;
                case ( XMLReader::ELEMENT != $this->reader->nodeType ) :
                    break;
                case ( self::DSAKEYVALUE == $this->reader->localName ) :
                    $keyValueType->setDSAKeyValue( DSAKeyValueTypeParser::factory( $this->reader)->parse());
                    break;
                case ( self::RSAKEYVALUE == $this->reader->localName ) :
                    $keyValueType->setRSAKeyValue( RSAKeyValueTypeParser::factory( $this->reader)->parse());
                    break;
                default :
                    $keyValueType->setAny( AnyTypeParser::factory( $this->reader)->parse());
                    break;
            }  // end switch
        }  // end while
        return $keyValueType;
    }
}
