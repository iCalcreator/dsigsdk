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

use Kigkonsult\DsigSdk\Dto\DigestMethodType;
use XMLReader;

use function sprintf;

/**
 * Class DigestMethodTypeParser
 */
class DigestMethodTypeParser extends DsigParserBase
{
    /**
     * Parse
     *
     * @return DigestMethodType
     */
    public function parse() : DigestMethodType
    {
        $digestMethodType = DigestMethodType::factory()->setXMLattributes( $this->reader );
        $this->logger->debug(
            sprintf( self::$FMTnodeFound, __METHOD__, self::$nodeTypes[$this->reader->nodeType], $this->reader->localName )
        );
        if( $this->reader->hasAttributes ) {
            while( $this->reader->moveToNextAttribute()) {
                $this->logger->debug(
                    sprintf( self::$FMTattrFound, __METHOD__, $this->reader->localName, $this->reader->value )
                );
                if( self::ALGORITM === $this->reader->localName ) {
                    $digestMethodType->setAlgorithm( $this->reader->value );
                }
            } // end while
            $this->reader->moveToElement();
        }
        if( $this->reader->isEmptyElement ) {
            return $digestMethodType;
        }
        $headElement = $this->reader->localName;
        $anyTypes    = [];
        while( @$this->reader->read()) {
            if( XMLReader::SIGNIFICANT_WHITESPACE !== $this->reader->nodeType ) {
                $this->logger->debug(
                    sprintf( self::$FMTreadNode, __METHOD__, self::$nodeTypes[$this->reader->nodeType], $this->reader->localName )
                );
            }
            switch( true ) {
                case ( XMLReader::END_ELEMENT === $this->reader->nodeType ) :
                    if( $headElement === $this->reader->localName ) {
                        break 2;
                    }
                    break;
                case ( XMLReader::ELEMENT !== $this->reader->nodeType ) :
                    break;
                default :
                    $anyTypes[] = AnyTypeParser::factory( $this->reader )->parse();
                    break;
            } // end switch
        } // end while
        $digestMethodType->setAny( $anyTypes );
        return $digestMethodType;
    }
}
