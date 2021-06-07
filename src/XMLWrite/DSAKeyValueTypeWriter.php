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

use Kigkonsult\DsigSdk\Dto\DSAKeyValueType;

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
        parent::setWriterStartElement( $this->writer, self::DSAKEYVALUE, $XMLattributes );


        $p = $DSAKeyValueType->getP();
        if( ! empty( $p )) {
            parent::writeTextElement( $this->writer, self::P, $XMLattributes, $p );
        }
        $q = $DSAKeyValueType->getQ();
        if( ! empty( $q )) {
            parent::writeTextElement( $this->writer, self::Q, $XMLattributes, $q );
        }
        $g = $DSAKeyValueType->getG();
        if( ! empty( $g )) {
            parent::writeTextElement( $this->writer, self::G, $XMLattributes, $g );
        }
        $y = $DSAKeyValueType->getY();
        if( ! empty( $y )) {
            parent::writeTextElement( $this->writer, self::Y, $XMLattributes, $y );
        }
        $j = $DSAKeyValueType->getJ();
        if( ! empty( $j )) {
            parent::writeTextElement( $this->writer, self::J, $XMLattributes, $j );
        }
        $seed = $DSAKeyValueType->getSeed();
        if( ! empty( $seed )) {
            parent::writeTextElement(
                $this->writer,
                self::SEED,
                $XMLattributes,
                $seed
            );
        }
        $pgenCounter = $DSAKeyValueType->getPgenCounter();
        if( ! empty( $pgenCounter )) {
            parent::writeTextElement(
                $this->writer,
                self::PGENCOUNTER,
                $XMLattributes,
                $pgenCounter
            );
        }

        $this->writer->endElement();
    }
}
