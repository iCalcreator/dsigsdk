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
 * Version   0.971
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
use Kigkonsult\DsigSdk\Impl\CommonFactory;

use function is_array;
use function sprintf;
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
     * @throws InvalidArgumentException
     */
    public function setTransformTypes( array $transformTypes ) {
        foreach( $transformTypes as $ix => $element ) {
            if( ! is_array( $element )) {
                $element = [ $ix => $element ];
            }
            foreach( $element as $key => $value ) {
                switch( $key ) {
                    case self::XPATH :
                        $this->transformTypes[$ix][$key] = CommonFactory::assertString( $value );
                        break 2;
                    case self::ANYTYPE :
                        $this->transformTypes[$ix][$key] = $value;
                        break 2;
                    default :
                        throw new InvalidArgumentException( sprintf( self::$FMTERR1, self::TRANSFORM, $ix, $key ));
                        break;
                } // end switch
            } // end foreach
        } // end foreach
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
     * @throws InvalidArgumentException
     */
    public function setAlgorithm( $algorithm ) {
        $this->algorithm = CommonFactory::assertString( $algorithm );
        return $this;
    }

}