<?php
/**
 * DsigSdk   the PHP XML Digital Signature recommendation SDK,
 *           source http://www.w3.org/2000/09/xmldsig#
 *
 * This file is a part of DsigSdk.
 *
 * Copyright 2019-21 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * author    Kjell-Inge Gustafsson, kigkonsult
 * Link      https://kigkonsult.se
 * Package   DsigSdk
 * Version   0.9.8
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

use InvalidArgumentException;
use Webmozart\Assert\Assert;

use function is_array;
use function sprintf;

/**
 * Class TransformType
 */
class TransformType extends DsigBase
{
    /**
     * @var array         each element is AnyType or XPath (string)
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
    public function getTransformTypes() {
        return $this->transformTypes;
    }

    /**
     * @param array $transformTypes
     * @return static
     * @throws InvalidArgumentException
     */
    public function setTransformTypes( array $transformTypes ) {
        foreach( $transformTypes as $ix => $element ) {
            if( ! is_array( $element )) {
                $element = [ $ix => $element ];
            }
            foreach( $element as $key => $value ) {
                Assert::string( $key );
                switch( $key ) {
                    case self::XPATH :
                        Assert::string( $value );
                        $this->transformTypes[$ix][$key] = $value;
                        break 2;
                    case self::ANYTYPE :
                        Assert::isInstanceOf( $value, AnyType::class );
                        $this->transformTypes[$ix][$key] = $value;
                        break 2;
                    default :
                        throw new InvalidArgumentException( sprintf( self::$FMTERR1, self::TRANSFORM, $ix, $key ));
                } // end switch
            } // end foreach
        } // end foreach
        return $this;
    }
}
