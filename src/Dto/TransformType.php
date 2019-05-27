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
 * Class TransformType
 */
class TransformType extends DsigBase
{

    /**
     * @var array         each element is AnyType or XPath (string)
     * @access protected
     */
    protected $transformTypes = [];

    /**
     * @var string
     *            attribute name="Algorithm" type="anyURI" use="required"
     * @access protected
     */
    protected $algorithm = null;

    /**
     * @return array
     */
    public function getTransformTypes() {
        return $this->transformTypes;
    }

    /**
     * @param $transformTypes[]
     * @return static
     */
    public function setTransformTypes( array $transformTypes ) {
        $this->transformTypes = $transformTypes;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlgorithm() {
        return $this->algorithm;
    }

    /**
     * @param string $algorithm
     * @return static
     */
    public function setAlgorithm( $algorithm ) {
        $this->algorithm = $algorithm;
        return $this;
    }

}