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

/**
 * Class RSAKeyValueType
 */
class RSAKeyValueType  extends DsigBase
{
    /**
     * @var null|string   type="ds:CryptoBinary" - base="base64Binary"
     */
    protected ?string $modulus = null;

    /**
     * @var null|string   type="ds:CryptoBinary" - base="base64Binary"
     */
    protected ?string $exponent = null;

    /**
     * Factory method with digestMethod and digestValue
     *
     * @param string $modulus
     * @param string $exponent
     * @return static
     */
    public static function factoryModulusExponent( string $modulus, string $exponent ) : static
    {
        return self::factory()
            ->setModulus( $modulus )
            ->setExponent( $exponent );
    }

    /**
     * @return null|string
     */
    public function getModulus() : ?string
    {
        return $this->modulus;
    }

    /**
     * Return bool true if modulus is set
     *
     * @return bool
     */
    public function isModulusSet() : bool
    {
        return ( null !== $this->modulus );
    }
    /**
     * @param string $modulus
     * @return static
     */
    public function setModulus( string $modulus ) : static
    {
        $this->modulus = $modulus;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getExponent() : ?string
    {
        return $this->exponent;
    }

    /**
     * Return bool true if exponent is set
     *
     * @return bool
     */
    public function isExponentSet() : bool
    {
        return ( null !== $this->exponent );
    }

    /**
     * @param string $exponent
     * @return static
     */
    public function setExponent( string $exponent ) : static
    {
        $this->exponent = $exponent;
        return $this;
    }
}
