<?php
/**
 * DsigSdk   the PHP XML Digital Signature recomendation SDK,
 *           source http://www.w3.org/2000/09/xmldsig#
 *
 * copyright (c) 2019 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * Link      https://kigkonsult.se
 * Package   DsigSdk
 * Version   0.95
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
 *
 * This file is a part of DsigSdk.
 */
namespace Kigkonsult\DsigSdk\Dto;

/**
 * Class Signature
 *
 * schemaLocation="http://www.w3.org/TR/2002/REC-xmldsig-core-20020212/xmldsig-core-schema.xsd"
 * namespace="http://www.w3.org/2000/09/xmldsig#"
 */
class SignatureType extends DsigBase
{

    /**
     * @var SignedInfoType
     * @access protected
     */
    protected $signedInfo = null;

    /**
     * @var SignatureValueType
     * @access protected
     */
    protected $signatureValue = null;

    /**
     * @var KeyInfoType
     *                  minOccurs="0"
     * @access protected
     */
    protected $keyInfo = null;

    /**
     * @var ObjectType[]
     *           minOccurs="0" maxOccurs="unbounded"
     * @access protected
     */
    protected $object = [];

    /**
     * @var string
     *          attribute name="Id" type="ID" use="optional"
     * @access protected
     */
    protected $id = null;

    /**
     * @return SignedInfoType
     */
    public function getSignedInfo() {
        return $this->signedInfo;
    }

    /**
     * @param SignedInfoType $signedInfo
     * @return static
     */
    public function setSignedInfo( SignedInfoType $signedInfo ) {
        $this->signedInfo = $signedInfo;
        return $this;
    }

    /**
     * @return SignatureValueType
     */
    public function getSignatureValue() {
        return $this->signatureValue;
    }

    /**
     * @param SignatureValueType $signatureValue
     * @return static
     */
    public function setSignatureValue( SignatureValueType $signatureValue ) {
        $this->signatureValue = $signatureValue;
        return $this;
    }

    /**
     * @return KeyInfoType
     */
    public function getKeyInfo() {
        return $this->keyInfo;
    }

    /**
     * @param KeyInfoType $keyInfo
     * @return static
     */
    public function setKeyInfo( KeyInfoType $keyInfo ) {
        $this->keyInfo = $keyInfo;
        return $this;
    }

    /**
     * @return ObjectType[]
     */
    public function getObject() {
        return $this->object;
    }

    /**
     * @param ObjectType[] $object
     * @return static
     */
    public function setObject( array $object ) {
        $this->object = $object;
        return $this;
    }

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $id
     * @return static
     */
    public function setId( $id ) {
        $this->id = $id;
        return $this;
    }

}