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
     *      self::X509ISSUERSERIAL
     *        type="ds:X509IssuerSerialType"/>
     *      self::X509SKI
     *        type="base64Binary"/>
     *      self::X509SUBJECTNAME
     *        type="string"/>
     *      self::X509CERTIFICATE
     *        type="base64Binary"/>
     *      self::X509CRL
     *        type="base64Binary"/>
     *      self::ANYTYPE
     *         AnyType
     * maxOccurs="unbounded"
     */
    protected $X509DataTypes = [];

    /**
     * @return array
     */
    public function getX509DataTypes() : array
    {
        return $this->X509DataTypes;
    }

    /**
     * @param string  $type
     * @param mixed   $X509DataType
     * @return static
     * @throws InvalidArgumentException
     */
    public function addX509DataType( string $type, $X509DataType ) : self
    {
        switch( $type ) {
            case self::X509ISSUERSERIAL :
                Assert::isInstanceOf( $X509DataType, X509IssuerSerialType::class  );
                break;
            case self::X509SKI :
                Assert::string( $X509DataType );
                break;
            case self::X509SUBJECTNAME :
                Assert::string( $X509DataType );
                break;
            case self::X509CERTIFICATE :
                Assert::string( $X509DataType );
                break;
            case self::X509CRL :
                Assert::string( $X509DataType );
                break;
            case self::ANYTYPE :
                Assert::isInstanceOf( $X509DataType, AnyType::class );
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
    public function setX509DataTypes( array $X509DataTypes ) : self
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
