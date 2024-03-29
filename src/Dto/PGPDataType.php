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
namespace Kigkonsult\DsigSdk\Dto;

use Kigkonsult\DsigSdk\Dto\Traits\AnyTypesTrait;

/**
 * Class PGPDataType
 */
class PGPDataType extends DsigBase
{
    /**
     * @var null|string -  type="base64Binary"
     *             choice opt 1
     */
    protected ?string $PGPKeyID = null;

    /**
     * @var null|string -  type="base64Binary" minOccurs="0"
     *             choice op 1 and 2
     */
    protected ?string $PGPKeyPacket = null;

    /**
     * Property, get- and setter methods
     * var Any[]  any
     *              namespace="##other" processContents="lax" minOccurs="0" maxOccurs="unbounded"
     *              choice op 1 and 2
     */
    use AnyTypesTrait;

    /**
     * Factory method with PGPKeyID
     *
     * @param string $PGPKeyID
     * @return static
     */
    public static function factoryPGPKeyID( string $PGPKeyID ) : static
    {
        return self::factory()->setPGPKeyID( $PGPKeyID );
    }

    /**
     * Factory method with PGPKeyPacket
     *
     * @param string $PGPKeyPacket
     * @return static
     */
    public static function factoryPGPKeyPacket( string $PGPKeyPacket ) : static
    {
        return self::factory()->setPGPKeyPacket( $PGPKeyPacket );
    }

    /**
     * @return null|string
     */
    public function getPGPKeyID() : ?string
    {
        return $this->PGPKeyID;
    }

    /**
     * Return bool true if PGPKeyID is set
     *
     * @return bool
     */
    public function isPGPKeyIDSet() : bool
    {
        return ( null !== $this->PGPKeyID );
    }

    /**
     * @param string $PGPKeyID
     * @return static
     */
    public function setPGPKeyID( string $PGPKeyID ) : static
    {
        $this->PGPKeyID = $PGPKeyID;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPGPKeyPacket() : ?string
    {
        return $this->PGPKeyPacket;
    }

    /**
     * Return bool true if PGPKeyPacket is set
     *
     * @return bool
     */
    public function isPGPKeyPacketSet() : bool
    {
        return ( null !== $this->PGPKeyPacket );
    }

    /**
     * @param string $PGPKeyPacket
     * @return static
     */
    public function setPGPKeyPacket( string $PGPKeyPacket ) : static
    {
        $this->PGPKeyPacket = $PGPKeyPacket;
        return $this;
    }
}
