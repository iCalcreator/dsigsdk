<?php
/**
 * DsigSdk   the PHP XML Digital Signature recomendation SDK,
 *           source http://www.w3.org/2000/09/xmldsig#
 *
 * This file is a part of DsigSdk.
 *
 * Copyright 2019 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * author    Kjell-Inge Gustafsson, kigkonsult
 * Link      https://kigkonsult.se
 * Package   DsigSdk
 * Version   0.965
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
namespace Kigkonsult\DsigSdk\XMLParse;

use Kigkonsult\DsigSdk\Dto\AnyType;
use XMLReader;

use function sprintf;

/**
 * Class AnyTypeParser
 */
class AnyTypeParser extends DsigParserBase
{

    /**
     * Parse
     *
     * @return AnyType
     */
    public function parse() {
        $anyType    = AnyType::factory()->setXMLattributes( $this->reader );
        $this->logger->debug(
            sprintf( self::$FMTnodeFound, __METHOD__, self::$nodeTypes[$this->reader->nodeType], $this->reader->localName )
        );
        $anyType->setElementName( $this->reader->localName );
        $attributes = [];
        if( $this->reader->hasAttributes ) {
            while( $this->reader->moveToNextAttribute()) {
                $this->logger->debug(
                    sprintf( self::$FMTattrFound, __METHOD__, $this->reader->localName, $this->reader->value )
                );
                $attributes[$this->reader->localName] = $this->reader->value;
            }
            $this->reader->moveToElement();
        }
        $anyType->setAttributes( $attributes );
        if( $this->reader->isEmptyElement ) {
            return $anyType;
        }
        $headElement  = $this->reader->localName;
        $contentIsSet = false;
        $anys         = [];
        while( @$this->reader->read()) {
            if( XMLReader::SIGNIFICANT_WHITESPACE != $this->reader->nodeType ) {
                $this->logger->debug(
                    sprintf( self::$FMTreadNode, __METHOD__, self::$nodeTypes[$this->reader->nodeType], $this->reader->localName )
                );
            }
            switch (true ) {
                case ( XMLReader::END_ELEMENT == $this->reader->nodeType ) :
                    if( $headElement == $this->reader->localName ) {
                        break 2;
                    }
                    break;
                case (( XMLReader::TEXT == $this->reader->nodeType ) && $this->reader->hasValue ) :
                    $anyType->setContent( $this->reader->value );
                    $contentIsSet = true;
                    break;
                case ( $contentIsSet ) :
                    break;
                case ( XMLReader::ELEMENT != $this->reader->nodeType ) :
                    break;
                default :
                    $anys[] = AnyTypeParser::factory( $this->reader )->parse();
                    break;
            } // end switch
        } // end while
        if( ! $contentIsSet ) {
            $anyType->setSubElements( $anys );
        }
        return $anyType;
    }
}
