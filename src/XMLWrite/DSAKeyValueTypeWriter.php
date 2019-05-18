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

use Kigkonsult\DsigSdk\Dto\DSAKeyValueType;

use function is_null;

/**
 * Class DSAKeyValueTypeWriter
 */
class DSAKeyValueTypeWriter extends DsigWriterBase
{

    /**
     * Write
     * @param DSAKeyValueType $DSAKeyValueType
     *
     */
    public function write( DSAKeyValueType $DSAKeyValueType ) {
        $XMLattributes = $DSAKeyValueType->getXMLattributes();
        parent::SetWriterStartElement( $this->writer, self::DSAKEYVALUE, $XMLattributes );


        $p = $DSAKeyValueType->getP();
        if( ! is_null( $p )) {
            parent::SetWriterStartElement( $this->writer, self::P, $XMLattributes );
            $this->writer->text( $p );
            $this->writer->endElement();
        }
        $q = $DSAKeyValueType->getQ();
        if( ! is_null( $q )) {
            parent::SetWriterStartElement( $this->writer, self::Q, $XMLattributes );
            $this->writer->text( $q );
            $this->writer->endElement();
        }
        $g = $DSAKeyValueType->getG();
        if( ! is_null( $g )) {
            parent::SetWriterStartElement( $this->writer, self::G, $XMLattributes );
            $this->writer->text( $g );
            $this->writer->endElement();
        }
        $y = $DSAKeyValueType->getY();
        if( ! is_null( $y )) {
            parent::SetWriterStartElement( $this->writer, self::Y, $XMLattributes );
            $this->writer->text( $y );
            $this->writer->endElement();
        }
        $j = $DSAKeyValueType->getJ();
        if( ! is_null( $j )) {
            parent::SetWriterStartElement( $this->writer, self::J, $XMLattributes );
            $this->writer->text( $j );
            $this->writer->endElement();
        }
        $seed = $DSAKeyValueType->getSeed();
        if( ! is_null( $seed )) {
            parent::SetWriterStartElement( $this->writer, self::SEED, $XMLattributes );
            $this->writer->text( $seed );
            $this->writer->endElement();
        }

        $this->writer->endElement();
    }
}
