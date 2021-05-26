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
 * Class KeyInfoType
 */
class KeyInfoType extends DsigBase
{

    /**
     * @var mixed[] - KeyName           string
     *                KeyValue          KeyValueType
     *                RetrievalMethod   RetrievalMethodType
     *                X509Data          X509DataType
     *                PGPData           PGPDataType
     *                SPKIData          SPKIDataType
     *                MgmtData          string
     *                ???               AnyType
     *              choice maxOccurs="unbounded"
     * @access protected
     */
    protected $keyInfoType = [];

    /**
     * Property, get- and setter methods for
     * var string id
     *            attribute name="Id" type="ID" use="optional"
     */
    use Traits\IdTrait;



    /**
     * @return mixed[]
     */
    public function getKeyInfoType() {
        return $this->keyInfoType;
    }

    /**
     * @param mixed[] $keyInfoType
     * @return static
     * @throws InvalidArgumentException
     */
    public function setKeyInfoType( array $keyInfoType ) {
        foreach( $keyInfoType as $ix => $element ) {
            if( ! is_array( $element )) {
                $element = [ $ix => $element ];
            }
            foreach( $element as $key => $value ) {
                switch( $key ) {
                    case self::KEYNAME :
                        Assert::string( $value );
                        $this->keyInfoType[$ix] = $element;
                        break;
                        break;
                    case self::KEYVALUE :
                        $this->keyInfoType[$ix] = $element;
                        break 2;
                    case self::RETRIEVALMETHOD :
                        $this->keyInfoType[$ix] = $element;
                        break 2;
                    case self::X509DATA :
                        $this->keyInfoType[$ix] = $element;
                        break 2;
                    case self::PGPDATA :
                        $this->keyInfoType[$ix] = $element;
                        break 2;
                    case self::SPKIDATA :
                        $this->keyInfoType[$ix] = $element;
                        break 2;
                    case self::MGMTDATA :
                        Assert::string( $value );
                        $this->keyInfoType[$ix] = $element;
                        break 2;
                    case self::ANYTYPE :
                        $this->keyInfoType[$ix] = $element;
                        break 2;
                    default :
                        throw new InvalidArgumentException( sprintf( self::$FMTERR1, self::KEYINFO, $ix, $key ));
                        break;
                } // end switch
            } // end foreach
        } // end foreach
        return $this;
    }

}