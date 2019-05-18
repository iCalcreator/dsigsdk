<?php
/**
 * DsigSdk   the PHP XML Digital Signature recomendation SDK, 
 *           source http://www.w3.org/2000/09/xmldsig#
 *
 * copyright (c) 2019 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * Link      https://kigkonsult.se
 * Package   DsigSdk
 * Version   0.95
 * License   Subject matter of licence is the software DsigSdk.
 *           The above copyright, link, package and version notices,
 *           this licence notice shall be included in all copies or substantial 
 *           portions of the DsigSdk.
 *
 *           DsigSdk is free software: you can redistribute it and/or modify
 *           it under the terms of the GNU Lesser General Public License as published
 *           by the Free Software Foundation, either version 3 of the License,
 *           or (at your option) any later version.
 *
 *           DsigSdk is distributed in the hope that it will be useful,
 *           but WITHOUT ANY WARRANTY; without even the implied warranty of
 *           MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *           GNU Lesser General Public License for more details.
 *
 *           You should have received a copy of the GNU Lesser General Public License
 *           along with DsigSdk. If not, see <https://www.gnu.org/licenses/>.
 *
 * This file is a part of DsigSdk.
 */
namespace Kigkonsult\DsigSdk\XMLWrite;

use Kigkonsult\DsigSdk\Dto\KeyValueType;

use function is_null;

/**
 * Class KeyValueTypeWriter
 */
class KeyValueTypeWriter extends DsigWriterBase
{

    /**
     * Write
     * @param KeyValueType $keyValueType
     *
     */
    public function write( KeyValueType $keyValueType ) {
        $XMLattributes = $keyValueType->getXMLattributes();
        parent::SetWriterStartElement( $this->writer, self::KEYVALUE, $XMLattributes );

        $DSAKeyValue = $keyValueType->getDSAKeyValue();
        $RSAKeyValue = $keyValueType->getRSAKeyValue();
        $any         = $keyValueType->getAny();
        if( ! is_null( $DSAKeyValue )) {
            DSAKeyValueTypeWriter::factory( $this->writer)->write( $DSAKeyValue );
        }
        elseif( ! is_null( $RSAKeyValue )) {
            RSAKeyValueTypeWriter::factory( $this->writer)->write( $RSAKeyValue );
        }
        elseif( ! is_null( $any )) {
            AnyTypeWriter::factory( $this->writer)->write( $any );
        }

        $this->writer->endElement();
    }
}
