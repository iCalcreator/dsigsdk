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

use Kigkonsult\DsigSdk\Dto\DSAKeyValue;
use XMLReader;

use function in_array;

/**
 * Class DSAKeyValueTypeParser
 */
class DSAKeyValueTypeParser extends DsigParserBase
{
    /**
     * @var array
     */
    private static array $DtoProps = [
        self::P,
        self::Q,
        self::G,
        self::Y,
        self::J,
        self::SEED,
        self::PGENCOUNTER
    ];

    /**
     * Parse
     *
     * @return DSAKeyValue
     */
    public function parse() : DSAKeyValue
    {
        $DSAKeyValue = DSAKeyValue::factory()->setXMLattributes( $this->reader );
        $this->logDebug1( __METHOD__ );
        if( $this->reader->hasAttributes ) {
            $this->processNodeAttributes( $DSAKeyValue );
        }
        if( ! $this->reader->isEmptyElement ) {
            $this->processSubNodes( $DSAKeyValue );
        }
        $this->logDebug4( __METHOD__ );
        return $DSAKeyValue;
    }

    /**
     * @param DSAKeyValue $DSAKeyValue
     */
    private function processNodeAttributes( DSAKeyValue $DSAKeyValue ) : void
    {
        while( $this->reader->moveToNextAttribute()) {
            $this->logDebug2( __METHOD__ );
            if( DSAKeyValue::isXmlAttrKey( $this->reader->localName )) {
                $DSAKeyValue->setXMLattribute( $this->reader->localName, $this->reader->value );
            }
        } // end while
        $this->reader->moveToElement();
    }

    /**
     * @param DSAKeyValue $DSAKeyValue
     */
    protected function processSubNodes( DSAKeyValue $DSAKeyValue ) : void
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
                case ( $isText && ( self::P === $currentElement )) :
                    $DSAKeyValue->setP( $this->reader->value );
                    break;
                case ( $isText && ( self::Q === $currentElement )) :
                    $DSAKeyValue->setQ( $this->reader->value );
                    break;
                case ( $isText && ( self::G === $currentElement )) :
                    $DSAKeyValue->setG( $this->reader->value );
                    break;
                case ( $isText && ( self::Y === $currentElement )) :
                    $DSAKeyValue->setY( $this->reader->value );
                    break;
                case ($isText && ( self::J === $currentElement )) :
                    $DSAKeyValue->setJ( $this->reader->value );
                    break;
                case ( $isText && ( self::SEED === $currentElement )) :
                    $DSAKeyValue->setSeed( $this->reader->value );
                    break;
                case ( $isText && ( self::PGENCOUNTER === $currentElement )) :
                    $DSAKeyValue->setPgenCounter( $this->reader->value );
                    break;
                case (( XMLReader::ELEMENT === $this->reader->nodeType ) &&
                    in_array( $this->reader->localName, self::$DtoProps, true )) :
                    $currentElement = $this->reader->localName;
                    break;
            } // end switch
        } // end while
    }
}
