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
 * Version   0.965
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

/**
 * Class SignedInfoType
 */
class SignedInfoType extends DsigBase
{


    /**
     * @var CanonicalizationMethodType
     * @access protected
     */
    protected $canonicalizationMethod = null;

    /**
     * @var SignatureMethodType
     * @access protected
     */
    protected $signatureMethod = null;

    /**
     * @var ReferenceType[]
     *                    maxOccurs="unbounded"
     * @access protected
     */
    protected $reference = [];

    /**
     * @var string
     *          attribute name="Id" type="ID" use="optional"
     * @access protected
     */
    protected $id = null;

    /**
     * @return CanonicalizationMethodType
     */
    public function getCanonicalizationMethod() {
        return $this->canonicalizationMethod;
    }

    /**
     * @param CanonicalizationMethodType $canonicalizationMethod
     * @return static
     */
    public function setCanonicalizationMethod( CanonicalizationMethodType $canonicalizationMethod ) {
        $this->canonicalizationMethod = $canonicalizationMethod;
        return $this;
    }

    /**
     * @return SignatureMethodType
     */
    public function getSignatureMethod() {
        return $this->signatureMethod;
    }

    /**
     * @param SignatureMethodType $signatureMethod
     * @return static
     */
    public function setSignatureMethod( SignatureMethodType $signatureMethod ) {
        $this->signatureMethod = $signatureMethod;
        return $this;
    }

    /**
     * @return ReferenceType[]
     */
    public function getReference() {
        return $this->reference;
    }

    /**
     * @param ReferenceType[] $reference
     * @return static
     */
    public function setReference( array $reference ) {
        $this->reference = $reference;
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
     * @return SignedInfoType
     */
    public function setId( $id ) {
        $this->id = $id;
        return $this;
    }


}