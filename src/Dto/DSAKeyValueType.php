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
 * Class DSAKeyValueType
 */
class DSAKeyValueType extends DsigBase
{

    /**
     * @var string  type="ds:CryptoBinary" -  base="base64Binary"
     *              minOccurs="0"
     * @access protected
     */
    protected $p = null;

    /**
     * @var string  type="ds:CryptoBinary" -  base="base64Binary"
     *              minOccurs="0"
     * @access protected
     */
    protected $q = null;

    /**
     * @var string  type="ds:CryptoBinary" -  base="base64Binary"
     *              minOccurs="0"
     * @access protected
     */
    protected $g = null;

    /**
     * @var string  type="ds:CryptoBinary" -  base="base64Binary"
     * @access protected
     */
    protected $y = null;

    /**
     * @var string  type="ds:CryptoBinary" -  base="base64Binary"
     *              minOccurs="0"
     * @access protected
     */
    protected $j = null;

    /**
     * @var string  type="ds:CryptoBinary" -  base="base64Binary"
     * @access protected
     */
    protected $seed = null;

    /**
     * @var string  type="ds:CryptoBinary" -  base="base64Binary"
     * @access protected
     */
    protected $pgenCounter = null;

    /**
     * @return string
     */
    public function getP() {
        return $this->p;
    }

    /**
     * @param string $p
     * @return static
     */
    public function setP( $p ) {
        $this->p = $p;
        return $this;
    }

    /**
     * @return string
     */
    public function getQ() {
        return $this->q;
    }

    /**
     * @param string $q
     * @return static
     */
    public function setQ( $q ) {
        $this->q = $q;
        return $this;
    }

    /**
     * @return string
     */
    public function getG() {
        return $this->g;
    }

    /**
     * @param string $g
     * @return static
     */
    public function setG( $g ) {
        $this->g = $g;
        return $this;
    }

    /**
     * @return string
     */
    public function getY() {
        return $this->y;
    }

    /**
     * @param string $y
     * @return static
     */
    public function setY( $y ) {
        $this->y = $y;
        return $this;
    }

    /**
     * @return string
     */
    public function getJ() {
        return $this->j;
    }

    /**
     * @param string $j
     * @return static
     */
    public function setJ( $j ) {
        $this->j = $j;
        return $this;
    }

    /**
     * @return string
     */
    public function getSeed() {
        return $this->seed;
    }

    /**
     * @param string $seed
     * @return static
     */
    public function setSeed( $seed ) {
        $this->seed = $seed;
        return $this;
    }

    /**
     * @return string
     */
    public function getPgenCounter() {
        return $this->pgenCounter;
    }

    /**
     * @param string $pgenCounter
     * @return static
     */
    public function setPgenCounter( $pgenCounter ) {
        $this->pgenCounter = $pgenCounter;
        return $this;
    }

}