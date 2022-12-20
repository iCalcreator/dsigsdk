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

use Kigkonsult\DsigSdk\Dto\X509IssuerSerialType;
use XMLReader;

/**
 * Class X509IssuerSerialTypeParser
 */
class X509IssuerSerialTypeParser extends DsigParserBase
{
    /**
     * Parse
     *
     * @return X509IssuerSerialType
     */
    public function parse() : X509IssuerSerialType
    {
        $X509IssuerSerialType = X509IssuerSerialType::factory()->setXMLattributes( $this->reader );
        $this->logDebug1( __METHOD__ );
        if( $this->reader->hasAttributes ) {
            $this->processNodeAttributes( $X509IssuerSerialType );
        }
        if( ! $this->reader->isEmptyElement ) {
            $this->processSubNodes( $X509IssuerSerialType );
        }
        $this->logDebug4( __METHOD__ );
        return $X509IssuerSerialType;
    }

    /**
     * @param X509IssuerSerialType $X509IssuerSerialType
     */
    private function processNodeAttributes( X509IssuerSerialType $X509IssuerSerialType ) : void
    {
        while( $this->reader->moveToNextAttribute()) {
            $this->logDebug2( __METHOD__ );
            if( X509IssuerSerialType::isXmlAttrKey( $this->reader->localName )) {
                $X509IssuerSerialType->setXMLattribute( $this->reader->localName, $this->reader->value );
            }
        } // end while
        $this->reader->moveToElement();
    }

    /**
     * @param X509IssuerSerialType $X509IssuerSerialType
     */
    private function processSubNodes( X509IssuerSerialType $X509IssuerSerialType ) : void
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
                case ( $isText && ( self::X509ISSUERNAME === $currentElement )) :
                    $X509IssuerSerialType->setX509IssuerName( $this->reader->value );
                    break;
                case ($isText && ( self::X509SERIALNUBER === $currentElement )) :
                    $X509IssuerSerialType->setX509SerialNumber( $this->reader->value );
                    break;
                case ( XMLReader::ELEMENT !== $this->reader->nodeType ) :
                    break;
                case ( self::X509ISSUERNAME === $this->reader->localName ) :
                    $currentElement = $this->reader->localName;
                    break;
                case ( self::X509SERIALNUBER === $this->reader->localName ) :
                    $currentElement = $this->reader->localName;
                    break;
            } // end switch
        } // end while
    }
}
