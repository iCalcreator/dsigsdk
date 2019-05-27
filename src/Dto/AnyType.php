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
 * Class AnyType
 */
class AnyType extends DsigBase
{

    /**
     * @var string
     * @access protected
     */
    protected $elementName = null;

    /**
     * @var string[]
     * @see https://docs.microsoft.com/en-us/previous-versions/dotnet/netframework-4.0/ms256043(v%3dvs.100)
     *               id = ID
                     maxOccurs = (nonNegativeInteger | unbounded) : 1
                     minOccurs = nonNegativeInteger : 1
                     namespace = "(##any | ##other) | List of (anyURI | (##targetNamespace |  ##local))) : ##any
                     processContents = (lax | skip | strict) : strict
                     {any attributes with non-schema Namespace...}>
     * @access protected
     */
    protected $attributes = [];

    /**
     * content OR elements
     *
     * @var string
     * @access protected
     */
    protected $content = null;

    /**
     * content OR elements
     *
     * @var AnyType[]
     * @access protected
     */
    protected $subElements = [];


    /**
     * @return string
     */
    public function getElementName() {
        return $this->elementName;
    }

    /**
     * @param string $elementName
     * @return static
     */
    public function setElementName( $elementName ) {
        $this->elementName = $elementName;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getAttributes() {
        return $this->attributes;
    }

    /**
     * @param string[] $attributes
     * @return static
     */
    public function setAttributes( array $attributes ) {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @param string $content
     * @return static
     */
    public function setContent( $content ) {
        $this->content = $content;
        return $this;
    }

    /**
     * @return AnyType[]
     */
    public function getSubElements() {
        return $this->subElements;
    }

    /**
     * @param array $subElements
     * @return static
     */
    public function setSubElements( $subElements ) {
        $this->subElements = $subElements;
        return $this;
    }


}