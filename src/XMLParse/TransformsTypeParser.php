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

use Kigkonsult\DsigSdk\Dto\Transforms;
use XMLReader;

/**
 * Class TransformsTypeParser
 */
class TransformsTypeParser extends DsigParserBase
{
    /**
     * Parse
     *
     * @return Transforms
     */
    public function parse() : Transforms
    {
        $transforms = Transforms::factory()->setXMLattributes( $this->reader );
        $this->logDebug1( __METHOD__ );
        if( $this->reader->hasAttributes ) {
            $this->processNodeAttributes( $transforms );
        }
        if( ! $this->reader->isEmptyElement ) {
            $this->processSubNodes( $transforms );
        }
        $this->logDebug4( __METHOD__ );
        return $transforms;
    }

    /**
     * @param Transforms $transforms
     */
    private function processNodeAttributes( Transforms $transforms ) : void
    {
        while( $this->reader->moveToNextAttribute()) {
            $this->logDebug2( __METHOD__ );
            if( Transforms::isXmlAttrKey( $this->reader->localName )) {
                $transforms->setXMLattribute( $this->reader->localName, $this->reader->value );
            }
        } // end while
        $this->reader->moveToElement();
    }

    /**
     * @param Transforms $transforms
     */
    private function processSubNodes( Transforms $transforms ) : void
    {
        $headElement   = $this->reader->localName;
        while( @$this->reader->read()) {
            $this->logDebug3( __METHOD__ );
            switch( true ) {
                case ( XMLReader::END_ELEMENT === $this->reader->nodeType ) :
                    if( $headElement === $this->reader->localName ) {
                        break 2;
                    }
                    break;
                case (( XMLReader::ELEMENT === $this->reader->nodeType ) &&
                    ( self::TRANSFORM === $this->reader->localName )) :
                    $transforms->addTransform( TransformTypeParser::factory( $this->reader )->parse());
                    break;
            } // end switch
        } // end while
    }
}
