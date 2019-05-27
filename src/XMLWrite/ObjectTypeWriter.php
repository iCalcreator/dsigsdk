<?php
/**
 * DsigSdk   the PHP XML Digital Signature recomendation SDK, 
 *           source http://www.w3.org/2000/09/xmldsig#
 *
 * This file is a part of DsigSdk.
 *
 * Copyright 2019 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * author    Kjell-Inge Gustafsson, kigkonsult
 * Link      https://kigkonsult.se
 * Package   DsigSdk
 * Version   0.965
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
 */
namespace Kigkonsult\DsigSdk\XMLWrite;

use Kigkonsult\DsigSdk\Dto\ObjectType;
use Kigkonsult\DsigSdk\Dto\SignaturePropertiesType;

/**
 * Class ObjectTypeWriter
 */
class ObjectTypeWriter extends DsigWriterBase
{

    /**
     * Write
     * @param ObjectType $objectType
     *
     */
    public function write( ObjectType $objectType ) {
        parent::SetWriterStartElement( $this->writer, self::OBJECT, $objectType->getXMLattributes());

        parent::writeAttribute( $this->writer, self::ID,       $objectType->getId());
        parent::writeAttribute( $this->writer, self::MIMETYPE, $objectType->getMimeType());
        parent::writeAttribute( $this->writer, self::ENCODING, $objectType->getEncoding());

        foreach( $objectType->getAny() as $element ) {
            foreach( $element as $key => $value ) {
                switch( $key ) {
                    case self::MANIFEST :
                        ManifestTypeWriter::factory( $this->writer )->write( $value );
                        break;
                    case self::SIGNATUREPROPERTIES :
                        SignaturePropertiesTypeWriter::factory( $this->writer )->write( $value );
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
