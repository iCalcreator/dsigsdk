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
namespace Kigkonsult\DsigSdk\Dto;

class KeyValueType extends DsigBase
{
    /**
     * @var DSAKeyValueType|null
     *                     choice opt 1
     */
    protected ?DSAKeyValueType $DSAKeyValue = null;

    /**
     * @var RSAKeyValueType|null
     *                     choice opt 2
     */
    protected ?RSAKeyValueType $RSAKeyValue = null;

    /**
     * @var AnyType|null
     *           any namespace="##other" processContents="lax"
     *                     choice opt 3
     */
    protected ?AnyType $any = null;


    /**
     * @return null|DSAKeyValueType
     */
    public function getDSAKeyValue() : ?DSAKeyValueType
    {
        return $this->DSAKeyValue;
    }

    /**
     * @param DSAKeyValueType $DSAKeyValue
     * @return static
     */
    public function setDSAKeyValue( DSAKeyValueType $DSAKeyValue ) : self
    {
        $this->DSAKeyValue = $DSAKeyValue;
        return $this;
    }

    /**
     * @return null|RSAKeyValueType
     */
    public function getRSAKeyValue() : ?RSAKeyValueType
    {
        return $this->RSAKeyValue;
    }

    /**
     * @param RSAKeyValueType $RSAKeyValue
     * @return static
     */
    public function setRSAKeyValue( RSAKeyValueType $RSAKeyValue ) : self
    {
        $this->RSAKeyValue = $RSAKeyValue;
        return $this;
    }

    /**
     * @return null|AnyType
     */
    public function getAny() : ?AnyType
    {
        return $this->any;
    }

    /**
     * @param AnyType $anyType
     * @return static
     */
    public function setAny( AnyType $anyType ) : self
    {
        $this->any = $anyType;
        return $this;
    }
}
