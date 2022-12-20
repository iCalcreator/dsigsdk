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

use Kigkonsult\DsigSdk\Dto\RSAKeyValue;
use XMLReader;

/**
 * Class RSAKeyValueTypeParser
 */
class RSAKeyValueTypeParser extends DsigParserBase
{
    /**
     * Parse
     *
     * @return RSAKeyValue
     */
    public function parse() : RSAKeyValue
    {
        $RSAKeyValue = RSAKeyValue::factory()->setXMLattributes( $this->reader );
        $this->logDebug1( __METHOD__ );
        if( $this->reader->hasAttributes ) {
            $this->processNodeAttributes( $RSAKeyValue );
        }
        if( ! $this->reader->isEmptyElement ) {
            $this->processSubNodes( $RSAKeyValue );
        }
        $this->logDebug4( __METHOD__ );
        return $RSAKeyValue;
    }

    /**
     * @param RSAKeyValue $RSAKeyValue
     */
    private function processNodeAttributes( RSAKeyValue $RSAKeyValue ) : void
    {
        while( $this->reader->moveToNextAttribute()) {
            $this->logDebug2( __METHOD__ );
            if( RSAKeyValue::isXmlAttrKey( $this->reader->localName )) {
                $RSAKeyValue->setXMLattribute( $this->reader->localName, $this->reader->value );
            }
        } // end while
        $this->reader->moveToElement();
    }

    /**
     * @param RSAKeyValue $RSAKeyValue
     */
    private function processSubNodes( RSAKeyValue $RSAKeyValue ) : void
    {
        $headElement    = $this->reader->localName;
        $currentElement = null;
        while( @$this->reader->read()) {
            $this->logDebug3( __METHOD__ );
            $isText = ( XMLReader::TEXT === $this->reader->nodeType );
            switch( true ) {
                case ( XMLReader::END_ELEMENT === $this->reader->nodeType ) :
                    if( $headElement === $this->reader->localName ) {
                        break 2;
                    }
                    $currentElement = null;
                    break;
                case ( $isText && ! $this->reader->hasValue ) :
                    break;
                case ( $isText && ( self::MODULUS === $currentElement )) :
                    $RSAKeyValue->setModulus( $this->reader->value );
                    break;
                case ($isText && ( self::EXPONENT === $currentElement )) :
                    $RSAKeyValue->setExponent( $this->reader->value );
                    break;
                case ( XMLReader::ELEMENT !== $this->reader->nodeType ) :
                    break;
                case ( self::MODULUS === $this->reader->localName ) :
                    $currentElement = $this->reader->localName;
                    break;
                case ( self::EXPONENT === $this->reader->localName ) :
                    $currentElement = $this->reader->localName;
                    break;
            } // end switch
        } // end while
    }
}
