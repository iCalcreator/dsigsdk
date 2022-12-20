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

use Kigkonsult\DsigSdk\Dto\SPKIData;
use XMLReader;

/**
 * Class SPKIDataTypeParser
 */
class SPKIDataTypeParser extends DsigParserBase
{
    /**
     * Parse
     *
     * @return SPKIData
     */
    public function parse() : SPKIData
    {
        $SPKIData = SPKIData::factory()->setXMLattributes( $this->reader );
        $this->logDebug1( __METHOD__ );
        if( $this->reader->hasAttributes ) {
            $this->processNodeAttributes( $SPKIData );
        }
        if( ! $this->reader->isEmptyElement ) {
            $this->processSubNodes( $SPKIData );
        }
        $this->logDebug4( __METHOD__ );
        return $SPKIData;
    }

    /**
     * @param SPKIData $SPKIData
     */
    private function processNodeAttributes( SPKIData $SPKIData ) : void
    {
        while( $this->reader->moveToNextAttribute()) {
            $this->logDebug2( __METHOD__ );
            if( SPKIData::isXmlAttrKey( $this->reader->localName )) {
                $SPKIData->setXMLattribute( $this->reader->localName, $this->reader->value );
            }
        } // end while
        $this->reader->moveToElement();
    }

    /**
     * @param SPKIData $SPKIData
     */
    private function processSubNodes( SPKIData $SPKIData ) : void
    {
        $headElement    = $this->reader->localName;
        $SPKIDataTypes  = [];
        while( @$this->reader->read()) {
            $this->logDebug3( __METHOD__ );
            switch( true ) {
                case ( XMLReader::END_ELEMENT === $this->reader->nodeType ) :
                    if( $headElement === $this->reader->localName ) {
                        break 2;
                    }
                    break;
                case ( XMLReader::TEXT === $this->reader->nodeType ) :
                    if( $this->reader->hasValue ) {
                        $SPKIDataTypes[] = [ self::SPKISEXP => $this->reader->value ];
                    }
                    break;
                case ( XMLReader::ELEMENT !== $this->reader->nodeType ) :
                    break;
                case ( self::SPKISEXP === $this->reader->localName ) :
                    break;
                default :
                    $SPKIDataTypes[] = [ self::ANYTYPE => AnyTypeParser::factory( $this->reader )->parse() ];
                    break;
            } // end switch
        } // end while
        if( ! empty( $SPKIDataTypes )) {
            $SPKIData->setSPKIDataType( $SPKIDataTypes );
        }
    }
}
