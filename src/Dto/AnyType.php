<?php
/**
 * DsigSdk    the PHP XML Digital Signature recommendation SDK,
 *            source http://www.w3.org/2000/09/xmldsig#
 *
 * This file is a part of DsigSdk.
 *
 * @author    Kjell-Inge Gustafsson, kigkonsult <ical@kigkonsult.se>
 * @copyright 2019-2022 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
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

use Kigkonsult\DsigSdk\Dto\Traits\AnyTypesTrait;

/**
 * Class AnyType
 */
class AnyType extends DsigBase
{
    /**
     * @var string
     */
    protected string $elementName;

    /**
     * @var string[]
     * @see https://docs.microsoft.com/en-us/previous-versions/dotnet/netframework-4.0/ms256043(v%3dvs.100)
     *               id = ID
                     maxOccurs = (nonNegativeInteger | unbounded) : 1
                     minOccurs = nonNegativeInteger : 1
                     namespace = "(##any | ##other) | List of (anyURI | (##targetNamespace |  ##local))) : ##any
                     processContents = (lax | skip | strict) : strict
                     {any attributes with non-schema Namespace...}>
     */
    protected array $attributes = [];

    /**
     * content
     *
     * @var null|string
     */
    protected ?string $content = null;

    /**
     * Property, get- and setter methods
     * var Any[]  any
     */
    use AnyTypesTrait;

    /**
     * Factory method with required elementName
     *
     * @param string $elementName
     * @return static
     */
    public static function factoryElementName( string $elementName ) : static
    {
        return self::factory()->setElementName( $elementName );
    }


    /**
     * @return string
     */
    public function getElementName() : string
    {
        return $this->elementName;
    }

    /**
     * Return bool true if elementName is set
     *
     * @return bool
     */
    public function isElementNameSet() : bool
    {
        return ( null !== $this->elementName );
    }

    /**
     * @param string $elementName
     * @return static
     */
    public function setElementName( string $elementName ) : static
    {
        $this->elementName = $elementName;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }

    /**
     * Return bool true if attributes is set
     *
     * @return bool
     */
    public function isAttributesSet() : bool
    {
        return ( null !== $this->attributes );
    }

    /**
     * @param string $key
     * @param string $value
     * @return static
     */
    public function addAttribute( string $key, string $value ) : static
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * @param string[] $attributes
     * @return static
     */
    public function setAttributes( array $attributes ) : static
    {
        foreach( $attributes as $key => $value ) {
            $this->addAttribute( $key, $value );
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getContent() : ?string
    {
        return $this->content;
    }

    /**
     * Return bool true if content is set
     *
     * @return bool
     */
    public function isContentSet() : bool
    {
        return ( null !== $this->content );
    }

    /**
     * @param string $content
     * @return static
     */
    public function setContent( string $content ) : static
    {
        $this->content = $content;
        return $this;
    }
}
