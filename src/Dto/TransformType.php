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
 * Class TransformType
 */
class TransformType extends DsigBase
{
    /**
     * @var array each element is (keyed) AnyType or XPath (string)
     *
     *   [ self::XPATH   => <string> ]
     *   [ self::ANYTYPE => AnyType ]
     *
     */
    protected $transformTypes = [];

    /**
     * Property, get- and setter methods for
     * var string algorithm
     *            attribute name="Algorithm" type="anyURI" use="required"
     */
    use Traits\AlgorithmTrait;

    /**
     * @return array
     */
    public function getTransformTypes() : array
    {
        return $this->transformTypes;
    }

    /**
     * @param string $type
     * @param mixed  $transformType
     * @return static
     * @throws InvalidArgumentException
     */
    public function addTransformType( string $type, $transformType ) : self
    {
        switch( $type ) {
            case self::XPATH :
                Assert::string( $transformType );
                break;
            case self::ANYTYPE :
                Assert::isInstanceOf( $transformType, AnyType::class );
                break;
            default :
                throw new InvalidArgumentException(
                    sprintf(
                        self::$FMTERR1,
                        self::TRANSFORM,
                        $type,
                        gettype( $transformType )
                    )
                );
        } // end switch
        $this->transformTypes[] = [ $type => $transformType ];
        return $this;
    }

    /**
     * @param array $transformTypes  *[ type => value ]
     * @return static
     * @throws InvalidArgumentException
     */
    public function setTransformTypes( array $transformTypes ) : self
    {
        foreach( $transformTypes as $ix => $element ) {
            if( ! is_array( $element )) {
                $element = [ $ix => $element ];
            }
            foreach( $element as $type => $value ) {
                $this->addTransformType( $type, $value );
            } // end foreach
        } // end foreach
        return $this;
    }
}
