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

/**
 * Class DSAKeyValueType
 */
class DSAKeyValueType extends DsigBase
{
    /**
     * @var string  type="ds:CryptoBinary" -  base="base64Binary"
     *              minOccurs="0"
     */
    protected $p = null;

    /**
     * @var string  type="ds:CryptoBinary" -  base="base64Binary"
     *              minOccurs="0"
     */
    protected $q = null;

    /**
     * @var string  type="ds:CryptoBinary" -  base="base64Binary"
     *              minOccurs="0"
     */
    protected $g = null;

    /**
     * @var string  type="ds:CryptoBinary" -  base="base64Binary"
     */
    protected $y = null;

    /**
     * @var string  type="ds:CryptoBinary" -  base="base64Binary"
     *              minOccurs="0"
     */
    protected $j = null;

    /**
     * @var string  type="ds:CryptoBinary" -  base="base64Binary"
     */
    protected $seed = null;

    /**
     * @var string  type="ds:CryptoBinary" -  base="base64Binary"
     */
    protected $pgenCounter = null;

    /**
     * @return null|string
     */
    public function getP()
    {
        return $this->p;
    }

    /**
     * @param string $p
     * @return static
     */
    public function setP( string $p ) : self
    {
        $this->p = $p;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getQ()
    {
        return $this->q;
    }

    /**
     * @param string $q
     * @return static
     */
    public function setQ( string $q ) : self
    {
        $this->q = $q;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getG()
    {
        return $this->g;
    }

    /**
     * @param string $g
     * @return static
     */
    public function setG( string $g ) : self
    {
        $this->g = $g;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @param string $y
     * @return static
     */
    public function setY( string $y ) : self
    {
        $this->y = $y;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getJ()
    {
        return $this->j;
    }

    /**
     * @param string $j
     * @return static
     */
    public function setJ( string $j ) : self
    {
        $this->j = $j;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSeed()
    {
        return $this->seed;
    }

    /**
     * @param string $seed
     * @return static
     */
    public function setSeed( string $seed ) : self
    {
        $this->seed = $seed;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPgenCounter()
    {
        return $this->pgenCounter;
    }

    /**
     * @param string $pgenCounter
     * @return static
     */
    public function setPgenCounter( string $pgenCounter ) : self
    {
        $this->pgenCounter = $pgenCounter;
        return $this;
    }
}
