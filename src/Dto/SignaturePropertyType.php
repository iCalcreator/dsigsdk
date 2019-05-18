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

/**
 * Class SignaturePropertyType
 */
class SignaturePropertyType extends DsigBase
{

    /**
     * @var AnyType[]
     *               maxOccurs="unbounded"
     * @access protected
     */
    protected $any = [];

    /**
     * @var string
     *            attribute name="Target" type="anyURI" use="required"
     * @access protected
     */
    protected $target = null;

    /**
     * @var string
     *            attribute name="Id" type="ID" use="optional"
     * @access protected
     */
    protected $id = null;



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

    /**
     * @return string
     */
    public function getTarget() {
        return $this->target;
    }

    /**
     * @param string $target
     * @return static
     */
    public function setTarget( $target ) {
        $this->target = $target;
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