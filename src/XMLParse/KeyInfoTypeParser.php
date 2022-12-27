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

use Kigkonsult\DsigSdk\Dto\KeyInfo;
use XMLReader;

use function in_array;

/**
 * Class KeyInfoTypeParser
 */
class KeyInfoTypeParser extends DsigParserBase
{
    /**
     * Parse
     *
     * @return KeyInfo
     */
    public function parse() : KeyInfo
    {
        $keyInfo = KeyInfo::factory()->setXMLattributes( $this->reader );
        $this->logDebug1( __METHOD__ );
        if( $this->reader->hasAttributes ) {
            $this->processNodeAttributes( $keyInfo );
        }
        if( ! $this->reader->isEmptyElement ) {
            $this->processSubNodes( $keyInfo );
        }
        $this->logDebug4( __METHOD__ );
        return $keyInfo;
    }

    /**
     * @param KeyInfo $keyInfo
     */
    private function processNodeAttributes( KeyInfo $keyInfo ) : void
    {
        while( $this->reader->moveToNextAttribute()) {
            $this->logDebug2( __METHOD__ );
            if( KeyInfo::isXmlAttrKey( $this->reader->localName )) {
                $keyInfo->setXMLattribute( $this->reader->localName, $this->reader->value );
            }
            elseif( self::ID === $this->reader->localName ) {
                $keyInfo->setId( $this->reader->value );
            }
        } // end while
        $this->reader->moveToElement();
    }

    /**
     * @param KeyInfo $keyInfo
     */
    protected function processSubNodes( KeyInfo $keyInfo ) : void
    {
        static $TEXTPROPS = [ self::KEYNAME, self::MGMTDATA ];
        $headElement      = $this->reader->localName;
        $currentElement   = null;
        while( @$this->reader->read()) {
            $this->logDebug3( __METHOD__ );
            switch( true ) {
                case ( XMLReader::END_ELEMENT === $this->reader->nodeType ) :
                    if( $headElement === $this->reader->localName ) {
                        break 2;
                    }
                    $currentElement = null;
                    break;
                case ( $this->isNonEmptyTextNode( $this->reader->nodeType ) && ! empty( $currentElement )) :
                    if( self::KEYNAME === $currentElement ) {
                        $keyInfo->addKeyInfoType( self::KEYNAME, $this->reader->value );
                    }
                    elseif( self::MGMTDATA === $currentElement ) {
                        $keyInfo->addKeyInfoType( self::MGMTDATA, $this->reader->value );
                    }
                    break;
                case ( XMLReader::ELEMENT !== $this->reader->nodeType ) :
                    $currentElement = null;
                    break;
                case in_array( $this->reader->localName, $TEXTPROPS, true ) :
                    $currentElement = $this->reader->localName;
                    break;
                case ( self::KEYVALUE === $this->reader->localName ) :
                    $keyInfo->addKeyInfoType(
                        self::KEYVALUE,
                        KeyValueTypeParser::factory( $this->reader )->parse()
                    );
                    break;
                case ( self::RETRIEVALMETHOD === $this->reader->localName ) :
                    $keyInfo->addKeyInfoType(
                        self::RETRIEVALMETHOD,
                        RetrievalMethodTypeParser::factory( $this->reader )->parse()
                    );
                    $currentElement = null;
                    break;
                case ( self::X509DATA === $this->reader->localName ) :
                    $keyInfo->addKeyInfoType(
                        self::X509DATA,
                        X509DataTypeParser::factory( $this->reader )->parse()
                    );
                    $currentElement = null;
                    break;
                case ( self::PGPDATA === $this->reader->localName ) :
                    $keyInfo->addKeyInfoType(
                        self::PGPDATA,
                        PGPDataTypeParser::factory( $this->reader )->parse()
                    );
                    $currentElement = null;
                    break;
                case ( self::SPKIDATA === $this->reader->localName ) :
                    $keyInfo->addKeyInfoType(
                        self::SPKIDATA,
                        SPKIDataTypeParser::factory( $this->reader )->parse()
                    );
                    $currentElement = null;
                    break;
                default :
                    $keyInfo->addKeyInfoType(
                        self::ANYTYPE,
                        AnyTypeParser::factory( $this->reader )->parse()
                    );
                    $currentElement = null;
                    break;
            } // end switch
        } // end while
    }
}
