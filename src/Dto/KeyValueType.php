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

class KeyValueType extends DsigBase
{
    /**
     * @var DSAKeyValue|null
     *                     choice opt 1
     */
    protected ?DSAKeyValue $DSAKeyValue = null;

    /**
     * @var RSAKeyValue|null
     *                     choice opt 2
     */
    protected ?RSAKeyValue $RSAKeyValue = null;

    /**
     * @var Any|null
     *           any namespace="##other" processContents="lax"
     *                     choice opt 3
     */
    protected ?Any $any = null;

    /**
     * Factory method with DSAKeyValue
     *
     * @param DSAKeyValue $DSAKeyValue
     * @return static
     */
    public static function factoryDSAKeyValue( DSAKeyValue $DSAKeyValue ) : static
    {
        return self::factory()->setDSAKeyValue( $DSAKeyValue );
    }

    /**
     * Factory method with RSAKeyValue
     *
     * @param RSAKeyValue $RSAKeyValue
     * @return static
     */
    public static function factoryRSAKeyValue( RSAKeyValue $RSAKeyValue ) : static
    {
        return self::factory()->setRSAKeyValue( $RSAKeyValue );
    }

    /**
     * @return null|DSAKeyValue
     */
    public function getDSAKeyValue() : ?DSAKeyValue
    {
        return $this->DSAKeyValue;
    }

    /**
     * Return bool true if DSAKeyValue is set
     *
     * @return bool
     */
    public function isDSAKeyValueSet() : bool
    {
        return ( null !== $this->DSAKeyValue );
    }

    /**
     * @param DSAKeyValue $DSAKeyValue
     * @return static
     */
    public function setDSAKeyValue( DSAKeyValue $DSAKeyValue ) : static
    {
        $this->DSAKeyValue = $DSAKeyValue;
        return $this;
    }

    /**
     * @return null|RSAKeyValue
     */
    public function getRSAKeyValue() : ?RSAKeyValue
    {
        return $this->RSAKeyValue;
    }

    /**
     * Return bool true if RSAKeyValue is set
     *
     * @return bool
     */
    public function isRSAKeyValueSet() : bool
    {
        return ( null !== $this->RSAKeyValue );
    }
    /**
     * @param RSAKeyValue $RSAKeyValue
     * @return static
     */
    public function setRSAKeyValue( RSAKeyValue $RSAKeyValue ) : static
    {
        $this->RSAKeyValue = $RSAKeyValue;
        return $this;
    }

    /**
     * @return null|Any
     */
    public function getAny() : ?Any
    {
        return $this->any;
    }

    /**
     * Return bool true if any is set
     *
     * @return bool
     */
    public function isAnySet() : bool
    {
        return ( null !== $this->any );
    }
    /**
     * @param Any $anyType
     * @return static
     */
    public function setAny( Any $anyType ) : static
    {
        $this->any = $anyType;
        return $this;
    }
}
