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

/**
 * Class ObjectType
 */
class ObjectType extends DsigBase
{
    /**
     * @var array Manifest[]|SignaturePropertiesType[]|AnyType[] mixed
     *            minOccurs="0" maxOccurs="unbounded" namespace="##any" processContents="lax"
     */
    protected $objectTypes = [];

    /**
     * Property, get- and setter methods for
     * var string id
     *            attribute name="Id" type="ID" use="optional"
     */
    use Traits\IdTrait;

    /**
     * @var string
     *            attribute name="MimeType" type="string" use="optional"
     */
    protected $mimeType = null;

    /**
     * @var string
     *            attribute name="Encoding" type="anyURI" use="optional"
     */
    protected $encoding = null;

    /**
     * @return array Manifest[]|SignaturePropertiesType[]|AnyType[] mixed
     */
    public function getObjectTypes() {
        return $this->objectTypes;
    }

    /**
     * @param array $objectTypes Manifest|SignaturePropertiesType|AnyType[]
     * @return static
     * @throws InvalidArgumentException
     */
    public function setObjectTypes( array $objectTypes ) {
        foreach( $objectTypes as $ix => $element ) {
            if( ! is_array( $element )) {
                $element = [ $ix => $element ];
            }
            foreach( $element as $key => $value ) {
                Assert::string( $key );
                switch( $key ) {
                    case self::MANIFEST :
                        Assert::isInstanceOf( $value, ManifestType::class  );
                        $this->objectTypes[$ix] = $element;
                        break 2;
                    case self::SIGNATUREPROPERTIES :
                        Assert::isInstanceOf( $value, SignaturePropertiesType::class );
                        $this->objectTypes[$ix] = $element;
                        break 2;
                    case self::ANYTYPE :
                        Assert::isInstanceOf( $value, AnyType::class );
                        $this->objectTypes[$ix] = $element;
                        break 2;
                    default :
                        throw new InvalidArgumentException( sprintf( self::$FMTERR1, self::KEYINFO, $ix, $key ));
                } // end switch
            } // end foreach
        } // end foreach
        return $this;
    }

    /**
     * @return string
     */
    public function getMimeType() {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     * @return static
     * @throws InvalidArgumentException
     */
    public function setMimeType( $mimeType ) {
        Assert::string( $mimeType );
        $this->mimeType = $mimeType;
        return $this;
    }

    /**
     * @return string
     */
    public function getEncoding() {
        return $this->encoding;
    }

    /**
     * @param string $encoding
     * @return static
     * @throws InvalidArgumentException
     */
    public function setEncoding( $encoding ) {
        Assert::string( $encoding );
        $this->encoding = $encoding;
        return $this;
    }
}
