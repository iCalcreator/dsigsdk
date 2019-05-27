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
 * Class PGPDataType
 */
class PGPDataType extends DsigBase
{

    /**
     * @var string -  type="base64Binary"
     *             choice opt 1
     * @access protected
     */
    protected $PGPKeyID = null;

    /**
     * @var string -  type="base64Binary" minOccurs="0"
     *             choice op 1 and 2
     * @access protected
     */
    protected $PGPKeyPacket = null;

    /**
     * @var AnyType[]
     *            namespace="##other" processContents="lax" minOccurs="0" maxOccurs="unbounded"
     *             choice op 1 and 2
     * @access protected
     */
    protected $any = [];

    /**
     * @return string
     */
    public function getPGPKeyID() {
        return $this->PGPKeyID;
    }

    /**
     * @param string $PGPKeyID
     * @return static
     */
    public function setPGPKeyID( $PGPKeyID ) {
        $this->PGPKeyID = $PGPKeyID;
        return $this;
    }

    /**
     * @return string
     */
    public function getPGPKeyPacket() {
        return $this->PGPKeyPacket;
    }

    /**
     * @param string $PGPKeyPacket
     * @return static
     */
    public function setPGPKeyPacket( $PGPKeyPacket ) {
        $this->PGPKeyPacket = $PGPKeyPacket;
        return $this;
    }

    /**
     * @return AnyType[]
     */
    public function getAny() {
        return $this->any;
    }

    /**
     * @param AnyType[] $any
     * @return static
     */
    public function setAny( array $any ) {
        $this->any = $any;
        return $this;
    }

}