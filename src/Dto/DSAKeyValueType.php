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

/**
 * Class DSAKeyValueType
 */
class DSAKeyValueType extends DsigBase
{
    /**
     * @var null|string  type="ds:CryptoBinary" -  base="base64Binary"
     *              minOccurs="0"
     */
    protected ?string $p = null;

    /**
     * @var null|string  type="ds:CryptoBinary" -  base="base64Binary"
     *              minOccurs="0"
     */
    protected ?string $q = null;

    /**
     * @var null|string  type="ds:CryptoBinary" -  base="base64Binary"
     *              minOccurs="0"
     */
    protected ?string $g = null;

    /**
     * @var null|string  type="ds:CryptoBinary" -  base="base64Binary"
     */
    protected ?string $y = null;

    /**
     * @var null|string  type="ds:CryptoBinary" -  base="base64Binary"
     *              minOccurs="0"
     */
    protected ?string $j = null;

    /**
     * @var null|string  type="ds:CryptoBinary" -  base="base64Binary"
     *
     * seed and pgenCounter OR none
     */
    protected ?string $seed = null;

    /**
     * @var null|string  type="ds:CryptoBinary" -  base="base64Binary"
     *
     * seed and pgenCounter OR none
     */
    protected ?string $pgenCounter = null;

    /**
     * @return null|string
     */
    public function getP() : ?string
    {
        return $this->p;
    }

    /**
     * Return bool true if p is set
     *
     * @return bool
     */
    public function isPSet() : bool
    {
        return ( null !== $this->p );
    }

    /**
     * @param string $p
     * @return static
     */
    public function setP( string $p ) : static
    {
        $this->p = $p;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getQ() : ?string
    {
        return $this->q;
    }

    /**
     * Return bool true if q is set
     *
     * @return bool
     */
    public function isQSet() : bool
    {
        return ( null !== $this->q );
    }

    /**
     * @param string $q
     * @return static
     */
    public function setQ( string $q ) : static
    {
        $this->q = $q;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getG() : ?string
    {
        return $this->g;
    }

    /**
     * Return bool true if g is set
     *
     * @return bool
     */
    public function isGSet() : bool
    {
        return ( null !== $this->g );
    }

    /**
     * @param string $g
     * @return static
     */
    public function setG( string $g ) : static
    {
        $this->g = $g;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getY() : ?string
    {
        return $this->y;
    }

    /**
     * Return bool true if y is set
     *
     * @return bool
     */
    public function isYSet() : bool
    {
        return ( null !== $this->y );
    }

    /**
     * @param string $y
     * @return static
     */
    public function setY( string $y ) : static
    {
        $this->y = $y;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getJ() : ?string
    {
        return $this->j;
    }

    /**
     * Return bool true if j is set
     *
     * @return bool
     */
    public function isJSet() : bool
    {
        return ( null !== $this->j );
    }

    /**
     * @param string $j
     * @return static
     */
    public function setJ( string $j ) : static
    {
        $this->j = $j;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSeed() : ?string
    {
        return $this->seed;
    }

    /**
     * Return bool true if seed is set
     *
     * @return bool
     */
    public function isSeedSet() : bool
    {
        return ( null !== $this->seed );
    }

    /**
     * @param string $seed
     * @return static
     */
    public function setSeed( string $seed ) : static
    {
        $this->seed = $seed;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPgenCounter() : ?string
    {
        return $this->pgenCounter;
    }

    /**
     * Return bool true if pgenCounter is set
     *
     * @return bool
     */
    public function isPgenCounterSet() : bool
    {
        return ( null !== $this->pgenCounter );
    }

    /**
     * @param string $pgenCounter
     * @return static
     */
    public function setPgenCounter( string $pgenCounter ) : static
    {
        $this->pgenCounter = $pgenCounter;
        return $this;
    }
}
