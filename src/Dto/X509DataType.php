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

use function is_array;
use function gettype;
use function sprintf;

/**
 * Class X509DataType
 */
class X509DataType extends DsigBase
{
    /**
     * @var array  (keyed) element sets *[ key => value ]
     *
     *  each set key is one of
     *      self::X509ISSUERSERIAL with type="ds:X509IssuerSerialType"/>
     *      self::X509SKI          with type="base64Binary"/>
     *      self::X509SUBJECTNAME  with type="string"/>
     *      self::X509CERTIFICATE  with type="base64Binary"/>
     *      self::X509CRL          with type="base64Binary"/>
     *      self::ANYTYPE          with type=Any
     * maxOccurs="unbounded"
     */
    protected array $X509DataTypes = [];

    /**
     * Factory method with one set, type and X509DataType
     *
     * @param string  $type
     * @param mixed   $X509DataType
     * @return static
     */
    public static function factoryX509DataType( string $type, mixed $X509DataType ) : static
    {
        return self::factory()->addX509DataType( $type, $X509DataType );
    }

    /**
     * @return array
     */
    public function getX509DataTypes() : array
    {
        return $this->X509DataTypes;
    }

    /**
     * Return bool true if X509DataTypes is not empty
     *
     * @return bool
     */
    public function isX509DataTypesSet() : bool
    {
        return ! empty( $this->X509DataTypes );
    }

    /**
     * @param string  $type
     * @param mixed   $X509DataType
     * @return static
     * @throws InvalidArgumentException
     */
    public function addX509DataType( string $type, mixed $X509DataType ) : static
    {
        switch( $type ) {
            case self::X509ISSUERSERIAL :
                Assert::isInstanceOf( $X509DataType, X509IssuerSerialType::class  );
                break;
            case self::X509SKI :         // fall through
            case self::X509SUBJECTNAME : // fall through
            case self::X509CERTIFICATE : // fall through
            case self::X509CRL :
                Assert::string( $X509DataType );
                break;
            case self::ANY :
                $type = self::ANYTYPE; // fall through
            case self::ANYTYPE :
                Assert::isInstanceOf( $X509DataType, Any::class );
                break;
            default :
                throw new InvalidArgumentException(
                    sprintf(
                        self::$FMTERR0,
                        self::X509DATA,
                        $type,
                        gettype( $X509DataType )
                    )
                );
        } // end switch
        $this->X509DataTypes[] = [ $type => $X509DataType ];
        return $this;
    }

    /**
     * @param array $X509DataTypes *[ type => value ]
     * @return static
     * @throws InvalidArgumentException
     */
    public function setX509DataTypes( array $X509DataTypes ) : static
    {
        foreach( $X509DataTypes as $ix => $element ) {
            if( ! is_array( $element )) {
                $element = [ $ix => $element ];
            }
            foreach( $element as $type => $value ) {
                $this->addX509DataType( $type, $value );
            } // end foreach
        } // end foreach
        return $this;
    }
}
