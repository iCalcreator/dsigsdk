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
use Kigkonsult\DsigSdk\Dto\Traits\IdTrait;

/**
 * Class SignaturePropertyType
 */
class SignaturePropertyType extends DsigBase
{
    /**
     * Property, get- and setter methods
     * var Any[]  any
     *               maxOccurs="unbounded"
     */
    use AnyTypesTrait;

    /**
     * @var null|string
     *            attribute name="Target" type="anyURI" use="required"
     */
    protected ?string $target = null;

    /**
     * Property, get- and setter methods for
     * var string id
     *            attribute name="Id" type="ID" use="optional"
     */
    use IdTrait;

    /**
     * Factory method with required target
     *
     * @param string $target
     * @return static
     */
    public static function factoryTarget( string $target ) : static
    {
        return self::factory()->setTarget( $target );
    }

    /**
     * @return null|string
     */
    public function getTarget() : ?string
    {
        return $this->target;
    }

    /**
     * Return bool true if target is set
     *
     * @return bool
     */
    public function isTargetSet() : bool
    {
        return ( null !== $this->target );
    }

    /**
     * @param string $target
     * @return static
     */
    public function setTarget( string $target ) : static
    {
        $this->target = $target;
        return $this;
    }
}
