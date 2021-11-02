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

use Kigkonsult\DsigSdk\Dto\X509Data;

use function in_array;

/**
 * Class X509DataTypeWriter
 */
class X509DataTypeWriter extends DsigWriterBase
{
    /**
     * Write
     * @param X509Data $X509DataType
     *
     */
    public function write( X509Data $X509DataType ) : void
    {
        static $textElements = [
            self::X509SKI,
            self::X509SUBJECTNAME,
            self::X509CERTIFICATE,
            self::X509CRL
        ];
        static $ANYTYPEs = [ self::ANY, self::ANYTYPE ];
        $XMLattributes   = $X509DataType->getXMLattributes();
        self::setWriterStartElement( $this->writer, self::X509DATA, $XMLattributes );

        foreach( $X509DataType->getX509DataTypes() as $type ) {
            foreach( $type as $key => $value ) {
                switch( true ) {
                    case ( self::X509ISSUERSERIAL === $key ) :
                        X509IssuerSerialTypeWriter::factory( $this->writer )->write( $value );
                        break;
                    case in_array( $key, $textElements, true ) :
                        self::writeTextElement( $this->writer, $key, $XMLattributes, $value );
                        break;
                    case in_array( $key, $ANYTYPEs, true ) :
                        AnyTypeWriter::factory( $this->writer )->write( $value );
                        break;
                } // end switch
            } // end foreach
        } // end foreach
        $this->writer->endElement();
    }
}
