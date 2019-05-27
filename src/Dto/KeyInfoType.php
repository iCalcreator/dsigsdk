<?php
/**
 * DsigSdk   the PHP XML Digital Signature recomendation SDK, 
 *           source http://www.w3.org/2000/09/xmldsig#
 *
 * This file is a part of DsigSdk.
 *
 * Copyright 2019 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * author    Kjell-Inge Gustafsson, kigkonsult
 * Link      https://kigkonsult.se
 * Package   DsigSdk
 * Version   0.965
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
 */
namespace Kigkonsult\DsigSdk\Dto;

/**
 * Class KeyInfoType
 */
class KeyInfoType extends DsigBase
{

    /**
     * @var mixed[] - KeyName           string
     *                KeyValue          KeyValueType
     *                RetrievalMethod   RetrievalMethodType
     *                X509Data          X509DataType
     *                PGPData           PGPDataType
     *                SPKIData          SPKIDataType
     *                MgmtData          string
     *                ???               AnyType
     *              choice maxOccurs="unbounded"
     * @access protected
     */
    protected $keyInfoType = [];

    /**
     * @var string
     *            attribute name="Id" type="ID" use="optional"
     * @access protected
     */
    protected $id = null;



    /**
     * @return mixed[]
     */
    public function getKeyInfoType() {
        return $this->keyInfoType;
    }

    /**
     * @param mixed[] $keyInfoType
     * @return static
     */
    public function setKeyInfoType( array $keyInfoType ) {
        $this->keyInfoType = $keyInfoType;
        return $this;
    }

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $id
     * @return static
     */
    public function setId( $id ) {
        $this->id = $id;
        return $this;
    }


}