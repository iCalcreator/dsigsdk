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

use Kigkonsult\DsigSdk\Dto\SignatureMethodType;
use XMLReader;

use function sprintf;

/**
 * Class SignatureMethodTypeParser
 */
class SignatureMethodTypeParser extends DsigParserBase
{
    /**
     * Parse
     *
     * @return SignatureMethodType
     */
    public function parse() : SignatureMethodType
    {
        $signatureMethodType  = SignatureMethodType::factory()->setXMLattributes( $this->reader );
        $this->logger->debug(
            sprintf( self::$FMTnodeFound, __METHOD__, self::$nodeTypes[$this->reader->nodeType], $this->reader->localName )
        );
        if( $this->reader->hasAttributes ) {
            while( $this->reader->moveToNextAttribute()) {
                $this->logger->debug(
                    sprintf( self::$FMTattrFound, __METHOD__, $this->reader->localName, $this->reader->value )
                );
                switch( $this->reader->localName ) {
                    case self::ALGORITM :
                        $signatureMethodType->setAlgorithm( $this->reader->value );
                        break;
                } // end switch
            } // end while
            $this->reader->moveToElement();
        }
        if( $this->reader->isEmptyElement ) {
            return $signatureMethodType;
        }
        $headElement          = $this->reader->localName;
        $currentElement       = null;
        $signatureMethodTypes = [];
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
                case (( XMLReader::TEXT == $this->reader->nodeType ) && ! $this->reader->hasValue ) :
                    break;
                case (( XMLReader::TEXT == $this->reader->nodeType ) && ( self::HMACOUTPUTLENGTH == $currentElement )) :
                    $signatureMethodTypes[] = [ self::HMACOUTPUTLENGTH => $this->reader->value ];
                    break;
                case ( XMLReader::ELEMENT != $this->reader->nodeType ) :
                    break;
                case ( self::HMACOUTPUTLENGTH == $this->reader->localName ) :
                    $currentElement = $this->reader->localName;
                    break;
                default :
                    $signatureMethodTypes[] = [
                        self::ANYTYPE => AnyTypeParser::factory( $this->reader )->parse()
                    ];
                    $currentElement  = null;
                    break;
            } // end switch
        } // end while
        $signatureMethodType->setSignatureMethodTypes( $signatureMethodTypes );
        return $signatureMethodType;
    }
}
