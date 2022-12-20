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
namespace Kigkonsult\DsigSdk\XMLWrite;

use Kigkonsult\DsigSdk\Dto\DsigBase;
use Kigkonsult\DsigSdk\Dto\Signature;
use XMLWriter;
use InvalidArgumentException;

use function sprintf;

/**
 * Class DsigWriter
 */
class DsigWriter extends DsigWriterBase
{
    /**
     * @param Signature $signature
     * @return string
     * @throws InvalidArgumentException
     */
    public static function factoryWrite( Signature $signature ) : string
    {
        return self::factory()->write( $signature );
    }

    /**
     * Write xml-string
     *
     * @param DsigBase $dsigBase
     * @return string
     * @throws InvalidArgumentException
     */
    public function write( DsigBase $dsigBase ) : string
    {
        static $FMTerr1 = 'Unknown xml root element %s';
        $this->writer = new XMLWriter();
        $this->writer->openMemory();
        $this->writer->setIndent( true );
        $this->writer->startDocument( '1.0', 'UTF-8' );
        if( $dsigBase instanceof Signature ) {
            SignatureTypeWriter::factory( $this->writer )->write( $dsigBase );
        }
        else {
            throw new InvalidArgumentException( sprintf( $FMTerr1, get_class( $dsigBase )));
        }
        return $this->writer->outputMemory();
    }
}
