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

use Kigkonsult\DsigSdk\Dto\SignatureType;

use function is_null;

/**
 * Class SignatureTypeWriter
 */
class SignatureTypeWriter extends DsigWriterBase
{

    /**
     * Write
     *
     * @param SignatureType $signatureType
     */
    public function write( SignatureType $signatureType ) {
        $XMLattributes = $signatureType->getXMLattributes();
        parent::SetWriterStartElement( $this->writer, self::SIGNATURE, $XMLattributes);

        parent::writeAttribute( $this->writer, self::ID, $signatureType->getId());

        $signedInfo = $signatureType->getSignedInfo();
        if( ! is_null( $signedInfo )) {
            SignedInfoTypeWriter::factory( $this->writer)->write( $signedInfo );
        }
        $signatureValue = $signatureType->getSignatureValue();
        if( ! is_null( $signatureValue )) {
            SignatureValueTypeWriter::factory( $this->writer)->write( $signatureValue );
        }
        $keyInfo = $signatureType->getKeyInfo();
        if( ! is_null( $keyInfo )) {
            KeyInfoTypeWriter::factory( $this->writer)->write( $keyInfo );
        }
        foreach( $signatureType->getObject() as $object ) {
            ObjectTypeWriter::factory( $this->writer )->write( $object );
        }
        $this->writer->endElement();
    }
}
