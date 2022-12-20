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

use Kigkonsult\DsigSdk\Dto\Any;
use XMLReader;

/**
 * Class AnyParser
 */
class AnyTypeParser extends DsigParserBase
{

    /**
     * Parse
     *
     * @return Any
     */
    public function parse() : Any
    {
        $any = Any::factory()->setXMLattributes( $this->reader );
        $this->logDebug1( __METHOD__ );
        $any->setElementName( $this->reader->localName );
        if( $this->reader->hasAttributes ) {
            $this->processNodeAttributes( $any );
        }
        if( ! $this->reader->isEmptyElement ) {
            $this->processSubNodes( $any );
        }
        $this->logDebug4( __METHOD__ );
        return $any;
    }

    /**
     * @param Any $any
     */
    private function processNodeAttributes( Any $any ) : void
    {
        $attributes = [];
        while( $this->reader->moveToNextAttribute()) {
            $this->logDebug2( __METHOD__ );
            if( $any::isXmlAttrKey( $this->reader->localName ) ) {
                $any->setXMLattribute( $this->reader->localName, $this->reader->value );
            }
            else {
                $attributes[$this->reader->localName] = $this->reader->value;
            }
        } // end while
        if( ! empty( $attributes ) ) {
            $any->setAttributes( $attributes );
        }
        $this->reader->moveToElement();
    }

    /**
     * @param Any $any
     */
    protected function processSubNodes( Any $any ) : void
    {
        $headElement  = $this->reader->localName;
        $contentIsSet = false;
        $anys         = [];
        while( @$this->reader->read()) {
            $this->logDebug3( __METHOD__ );
            switch (true ) {
                case ( XMLReader::END_ELEMENT === $this->reader->nodeType ) :
                    if( $headElement === $this->reader->localName ) {
                        break 2;
                    }
                    break;
                case (( XMLReader::TEXT === $this->reader->nodeType ) && $this->reader->hasValue ) :
                    $any->setContent( $this->reader->value );
                    $contentIsSet = true;
                    break;
                case ( $contentIsSet ) :
                    break;
                case ( XMLReader::ELEMENT !== $this->reader->nodeType ) :
                    break;
                default :
                    $anys[] = self::factory( $this->reader )->parse();
                    break;
            } // end switch
        } // end while
        if( ! $contentIsSet && ! empty( $anys )) {
            $any->setAny( $anys );
        }
    }
}
