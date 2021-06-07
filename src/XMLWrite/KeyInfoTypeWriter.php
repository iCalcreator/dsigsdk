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
namespace Kigkonsult\DsigSdk\XMLWrite;

use Kigkonsult\DsigSdk\Dto\KeyInfoType;

/**
 * Class KeyInfoTypeWriter
 */
class KeyInfoTypeWriter extends DsigWriterBase
{
    /**
     * Write
     * @param KeyInfoType $keyInfoType
     *
     */
    public function write( KeyInfoType $keyInfoType )
    {
        $XMLattributes = $keyInfoType->getXMLattributes();
        parent::setWriterStartElement( $this->writer, self::KEYINFO, $XMLattributes );

        parent::writeAttribute( $this->writer, self::ID, $keyInfoType->getId());

        foreach( $keyInfoType->getKeyInfoType() as $element ) {
            foreach( $element as $key => $value ) {
                switch( $key ) {
                    case self::KEYNAME :
                        parent::writeTextElement(
                            $this->writer,
                            self::KEYNAME,
                            $XMLattributes,
                            $value
                        );
                        break;
                    case self::KEYVALUE :
                        KeyValueTypeWriter::factory( $this->writer )->write( $value );
                        break;
                    case self::RETRIEVALMETHOD :
                        RetrievalMethodTypeWriter::factory( $this->writer )->write( $value );
                        break;
                    case self::X509DATA :
                        X509DataTypeWriter::factory( $this->writer )->write( $value );
                        break;
                    case self::PGPDATA :
                        PGPDataTypeWriter::factory( $this->writer )->write( $value );
                        break;
                    case self::SPKIDATA :
                        SPKIDataTypeWriter::factory( $this->writer )->write( $value );
                        break;
                    case self::MGMTDATA :
                        parent::writeTextElement(
                            $this->writer,
                            self::MGMTDATA,
                            $XMLattributes,
                            $value
                        );
                        break;
                    case self::ANYTYPE :
                        AnyTypeWriter::factory( $this->writer )->write( $value );
                        break;
                } // end switch
            } // end foreach
        } // end foreach
        $this->writer->endElement();
    }
}
