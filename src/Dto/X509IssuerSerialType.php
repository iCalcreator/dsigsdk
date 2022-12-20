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

use InvalidArgumentException;
use Webmozart\Assert\Assert;

/**
 * Class X509IssuerSerialType
 */
class X509IssuerSerialType extends DsigBase
{
    /**
     * @var null|string
     */
    private ?string $X509IssuerName = null;

    /**
     * @var int|null
     */
    private ?int $X509SerialNumber = null;

    /**
     * Factory method with
     *
     * @param string     $X509IssuerName
     * @param int|string $X509SerialNumber
     * @return static
     */
    public static function factoryX509NameNumber( string $X509IssuerName, int|string $X509SerialNumber ) : static
    {
        return self::factory()->setX509IssuerName( $X509IssuerName )->setX509SerialNumber( $X509SerialNumber );
    }

    /**
     * @return null|string
     */
    public function getX509IssuerName() : ?string
    {
        return $this->X509IssuerName;
    }

    /**
     * Return bool true if X509IssuerName is set
     *
     * @return bool
     */
    public function isX509IssuerNameSet() : bool
    {
        return ( null !== $this->X509IssuerName );
    }
    /**
     * @param string $X509IssuerName
     * @return static
     */
    public function setX509IssuerName( string $X509IssuerName ) : static
{
        $this->X509IssuerName = $X509IssuerName;
        return $this;
    }

    /**
     * @return null|int
     */
    public function getX509SerialNumber() : ?int
    {
        return $this->X509SerialNumber;
    }

    /**
     * Return bool true if X509SerialNumber is set
     *
     * @return bool
     */
    public function isX509SerialNumberSet() : bool
    {
        return ( null !== $this->X509SerialNumber );
    }

    /**
     * @param int|string $X509SerialNumber
     * @return static
     * @throws InvalidArgumentException
     */
    public function setX509SerialNumber( int | string $X509SerialNumber ) : static
    {
        Assert::integerish( $X509SerialNumber );
        $this->X509SerialNumber = (int) $X509SerialNumber;
        return $this;
    }
}
