<?php
/**
 * DsigSdk   the PHP XML Digital Signature recommendation SDK, 
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
use Webmozart\Assert\Assert;

use function is_array;
use function sprintf;
/**
 * Class SPKIDataType
 */
class SPKIDataType extends DsigBase
{

    /**
     * @var array  each element (=array) is a single SPKISexp (string="base64Binary") or pairs of SPKISexp/AnyType
     */
    protected $SPKIDataType = [];

    /**
     * @return array
     */
    public function getSPKIDataType() {
        return $this->SPKIDataType;
    }

    /**
     * @param array $SPKIData
     * @return static
     * @throws InvalidArgumentException
     */
    public function setSPKIDataType( array $SPKIData ) {
        foreach( $SPKIData as $ix1 => $elementSet ) {
            if( ! is_array( $elementSet )) {
                $elementSet = [ $ix1 => $elementSet ];
            }
            foreach( $elementSet as $ix2 => $element ) {
                if( ! is_array( $element )) {
                    $element = [ $ix2 => $element ];
                }
                foreach( $element as $key => $value ) {
                    Assert::string( $key );
                    switch( $key ) {
                        case self::SPKISEXP :
                            Assert::string( $value );
                            $this->SPKIDataType[$ix1][$ix2][$key] = $value;
                            break;
                        case self::ANYTYPE :
                            Assert::isInstanceOf( $value, parent::getNs() . self::ANYTYPE );
                            $this->SPKIDataType[$ix1][$ix2][$key] = $value;
                            break 2;
                        default :
                            throw new InvalidArgumentException(
                                sprintf( self::$FMTERR2, self::SPKIDATA, $ix1, $ix2, $key )
                            );
                            break;
                    } // end switch
                } // end foreach
            } // end foreach
        }
        return $this;
    }

}