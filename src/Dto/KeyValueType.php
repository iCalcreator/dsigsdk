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
namespace Kigkonsult\DsigSdk\Dto;

class KeyValueType extends DsigBase
{

    /**
     * @var DSAKeyValueType
     *                     choice opt 1
     * @access procated
     */
    protected $DSAKeyValue = null;

    /**
     * @var RSAKeyValueType
     *                     choice opt 2
     * @access procated
     */
    protected $RSAKeyValue = null;

    /**
     * @var AnyType
     *           any namespace="##other" processContents="lax"
     *                     choice opt 3
     * @access procated
     */
    protected $any = null;


    /**
     * @return DSAKeyValueType
     */
    public function getDSAKeyValue() {
        return $this->DSAKeyValue;
    }

    /**
     * @param DSAKeyValueType $DSAKeyValue
     * @return static
     */
    public function setDSAKeyValue( DSAKeyValueType $DSAKeyValue ) {
        $this->DSAKeyValue = $DSAKeyValue;
        return $this;
    }

    /**
     * @return RSAKeyValueType
     */
    public function getRSAKeyValue() {
        return $this->RSAKeyValue;
    }

    /**
     * @param RSAKeyValueType $RSAKeyValue
     * @return static
     */
    public function setRSAKeyValue( RSAKeyValueType $RSAKeyValue ) {
        $this->RSAKeyValue = $RSAKeyValue;
        return $this;
    }

    /**
     * @return AnyType
     */
    public function getAny() {
        return $this->any;
    }

    /**
     * @param AnyType $anyType
     * @return static
     */
    public function setAny( AnyType $anyType ) {
        $this->any = $anyType;
        return $this;
    }


}