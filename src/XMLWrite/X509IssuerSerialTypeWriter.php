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

use Kigkonsult\DsigSdk\Dto\X509IssuerSerialType;

/**
 * Class X509IssuerSerialTypeWriter
 */
class X509IssuerSerialTypeWriter extends DsigWriterBase
{
    /**
     * Write
     * @param X509IssuerSerialType $X509IssuerSerialType
     *
     */
    public function write( X509IssuerSerialType $X509IssuerSerialType )
    {
        $XMLattributes = $X509IssuerSerialType->getXMLattributes();
        parent::setWriterStartElement( $this->writer, self::X509ISSUERSERIAL, $XMLattributes );

        $X509IssuerName = $X509IssuerSerialType->getX509IssuerName();
        if( ! empty( $X509IssuerName )) {
            parent::writeTextElement(
                $this->writer,
                self::X509ISSUERNAME,
                $XMLattributes,
                $X509IssuerName
            );
        }
        $X509SerialNumber = $X509IssuerSerialType->getX509SerialNumber();
        if( ! empty( $X509SerialNumber )) {
            parent::writeTextElement(
                $this->writer,
                self::X509SERIALNUBER,
                $XMLattributes,
                (string) $X509SerialNumber
            );
        }

        $this->writer->endElement();
    }
}
