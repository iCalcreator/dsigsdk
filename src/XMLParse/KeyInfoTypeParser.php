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

use Kigkonsult\DsigSdk\Dto\KeyInfoType;
use XMLReader;

use function sprintf;

/**
 * Class KeyInfoTypeParser
 */
class KeyInfoTypeParser extends DsigParserBase
{

    /**
     * Parse
     *
     * @return KeyInfoType
     */
    public function parse() {
        $keyInfoType  = KeyInfoType::factory()->setXMLattributes( $this->reader );
        $this->logger->debug(
            sprintf( self::$FMTnodeFound, __METHOD__, self::$nodeTypes[$this->reader->nodeType], $this->reader->localName )
        );
        if( $this->reader->hasAttributes ) {
            while( $this->reader->moveToNextAttribute()) {
                $this->logger->debug(
                    sprintf( self::$FMTattrFound, __METHOD__, $this->reader->localName, $this->reader->value )
                );
                switch( $this->reader->localName ) {
                    case self::ID :
                        $keyInfoType->setId( $this->reader->value );
                        break;
                } // end switch
            } // end while
            $this->reader->moveToElement();
        }
        if( $this->reader->isEmptyElement ) {
            return $keyInfoType;
        }
        $headElement    = $this->reader->localName;
        $currentElement = null;
        $keyInfoTypes   = [];
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
                    $currentElement = null;
                    break;
                case ( XMLReader::TEXT == $this->reader->nodeType ) :
                    switch( true ) {
                        case ( ! $this->reader->hasValue ) :
                            break;
                        case ( empty( $currentElement )) :
                            break;
                        case ( self::KEYNAME == $currentElement ) :
                            $keyInfoTypes[] = [ self::KEYNAME => $this->reader->value ];
                            break;
                        case ( self::MGMTDATA == $currentElement ) :
                            $keyInfoTypes[] = [ self::MGMTDATA  => $this->reader->value ];
                            break;
                    }
                    break;
                case ( XMLReader::ELEMENT != $this->reader->nodeType ) :
                    $currentElement = null;
                    break;
                case ( self::KEYNAME == $this->reader->localName ) :
                    $currentElement = $this->reader->localName;
                    break;
                case ( self::KEYVALUE == $this->reader->localName ) :
                    $keyInfoTypes[] = [ self::KEYVALUE => KeyValueTypeParser::factory( $this->reader )->parse() ];
                    break;
                case ( self::RETRIEVALMETHOD == $this->reader->localName ) :
                    $keyInfoTypes[] = [
                        self::RETRIEVALMETHOD => RetrievalMethodTypeParser::factory( $this->reader )->parse()
                    ];
                    $currentElement = null;
                    break;
                case ( self::X509DATA == $this->reader->localName ) :
                    $keyInfoTypes[] = [ self::X509DATA => X509DataTypeParser::factory( $this->reader )->parse() ];
                    $currentElement = null;
                    break;
                case ( self::PGPDATA == $this->reader->localName ) :
                    $keyInfoTypes[] = [ self::PGPDATA => PGPDataTypeParser::factory( $this->reader )->parse() ];
                    $currentElement = null;
                    break;
                case ( self::SPKIDATA == $this->reader->localName ) :
                    $keyInfoTypes[] = [ self::SPKIDATA => SPKIDataTypeParser::factory( $this->reader )->parse() ];
                    $currentElement = null;
                    break;
                case ( self::MGMTDATA == $this->reader->localName ) :
                    $currentElement = $this->reader->localName;
                    break;
                default :
                    $keyInfoTypes[] = [ self::ANYTYPE => AnyTypeParser::factory( $this->reader )->parse() ];
                    $currentElement = null;
                    break;
            } // end switch
        } // end while
        $keyInfoType->setKeyInfoType( $keyInfoTypes );
        return $keyInfoType;
    }
}
