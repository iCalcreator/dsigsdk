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

use Kigkonsult\DsigSdk\Dto\X509DataType;
use XMLReader;

use function sprintf;

/**
 * Class X509DataTypeParser
 */
class X509DataTypeParser extends DsigParserBase
{
    /**
     * Parse
     *
     * @return X509DataType
     */
    public function parse() : X509DataType
    {
        $x509DataType  = X509DataType::factory()->setXMLattributes( $this->reader );
        $this->logger->debug(
            sprintf( self::$FMTnodeFound, __METHOD__, self::$nodeTypes[$this->reader->nodeType], $this->reader->localName )
        );
        $headElement    = $this->reader->localName;
        $currentElement = null;
        $x509DataTypes  = [];
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
                    if( $this->reader->hasValue  && ! empty( $currentElement )) {
                        $x509DataTypes[] = [ $currentElement => $this->reader->value ];
                    }
                    break;
                case ( XMLReader::ELEMENT != $this->reader->nodeType ) :
                    break;
                case ( self::X509ISSUERSERIAL == $this->reader->localName ) :
                    $x509DataTypes[] = [
                        self::X509ISSUERSERIAL => X509IssuerSerialTypeParser::factory( $this->reader )->parse()
                    ];
                    $currentElement = null;
                    break;
                case ( self::X509SKI == $this->reader->localName ) :
                    $currentElement = $this->reader->localName;
                    break;
                case ( self::X509SUBJECTNAME == $this->reader->localName ) :
                    $currentElement = $this->reader->localName;
                    break;
                case ( self::X509CERTIFICATE == $this->reader->localName ) :
                    $currentElement = $this->reader->localName;
                    break;
                case ( self::X509CRL == $this->reader->localName ) :
                    $currentElement = $this->reader->localName;
                    break;
                default :
                    $x509DataTypes[] = [ self::ANYTYPE => AnyTypeParser::factory( $this->reader )->parse() ];
                    $currentElement = null;
                    break;
            } // end switch
        } // end while
        $x509DataType->setX509DataTypes( $x509DataTypes );
        return $x509DataType;
    }
}
