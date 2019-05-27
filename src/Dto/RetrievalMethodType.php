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
 * Class RetrievalMethodType
 */
class RetrievalMethodType extends DsigBase
{

    /**
     * @var TransformsType
     *                     minOccurs="0"
     * @access protected
     */
    protected $transforms = null;

    /**
     * @var string
     *            attribute name="URI" type="anyURI"
     * @access protected
     */
    protected $URI = null;

    /**
     * @var string
     *            attribute name="Type" type="anyURI" use="optional"
     * @access protected
     */
    protected $type = null;

    /**
     * @return TransformsType
     */
    public function getTransforms() {
        return $this->transforms;
    }

    /**
     * @param TransformsType $transforms
     * @return static
     */
    public function setTransforms( TransformsType $transforms ) {
        $this->transforms = $transforms;
        return $this;
    }

    /**
     * @return string
     */
    public function getURI() {
        return $this->URI;
    }

    /**
     * @param string $URI
     * @return static
     */
    public function setURI( $URI ) {
        $this->URI = $URI;
        return $this;
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param string $type
     * @return static
     */
    public function setType( $type ) {
        $this->type = $type;
        return $this;
    }

}