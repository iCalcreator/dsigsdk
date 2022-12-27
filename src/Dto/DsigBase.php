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

use InvalidArgumentException;
use Kigkonsult\DsigSdk\DsigInterface;
use Kigkonsult\DsigSdk\XMLAttributesInterface;
use Webmozart\Assert\Assert;
use XMLReader;

use function in_array;

/**
 * Class DsigBase
 */
abstract class DsigBase implements DsigInterface, XMLAttributesInterface
{
    /**
     * @var string
     */
    protected static string $FMTERR0 = 'Unknown %s type (%s) \'%s\'';
    protected static string $FMTERR1 = 'Unknown %s type #%s \'%s\'';

    /**
     * @var array
     */
    protected array $XMLattributes = [];

    /**
     * Factory method
     *
     * @return static
     */
    public static function factory() : static
    {
        return new static();
    }

    /**
     * Get XML attributes
     *
     * @return array
     */
    public function getXMLattributes() : array
    {
        return $this->XMLattributes;
    }

    /**
     * Return bool true if XMLattributes is not empty OR key is set
     *
     * @param null|string $key
     * @return bool
     */
    public function isXMLattributesSet( ? string $key = null ) : bool
    {
        return empty( $key )
            ? ! empty( $this->XMLattributes )
            : isset( $this->XMLattributes[$key] );
    }

    /**
     * Set single XML attribute, opt propagate down in hierachy
     *
     * @param string    $key
     * @param string    $value
     * @param bool|null $propagateDown
     * @return static
     * @throws InvalidArgumentException
     */
    public function setXMLattribute(
        string $key,
        string $value,
        ? bool $propagateDown = false
    ) : static
    {
        Assert::string( $key );
        Assert::string( $value );
        $this->XMLattributes[$key] = $value;
        Assert::boolean( $propagateDown );
        if( $propagateDown ) {
            self::propagateDown( $this, $key, $value, false );
        }
        return $this;
    }

    /**
     * Unset XML attribute, opt down
     *
     * @param string    $key
     * @param bool|null $propagateDown
     * @return static
     * @throws InvalidArgumentException
     */
    public function unsetXMLattribute( string $key, ?bool $propagateDown ) : static
    {
        Assert::string( $key );
        unset( $this->XMLattributes[$key] );
        Assert::boolean( $propagateDown );
        if( $propagateDown ) {
            self::propagateDown( $this, $key, null, true );
        }
        return $this;
    }

    /**
     * Propagate or remove XML attribute down
     *
     * @param DsigBase     $dsigBase
     * @param string       $key
     * @param null|string  $value
     * @param null|bool    $unset
     * @throws InvalidArgumentException
     */
    protected static function propagateDown(
        DsigBase $dsigBase,
        string $key,
        ? string $value = null,
        ? bool $unset = false
    ) : void
    {
        Assert::boolean( $unset );
        if( $unset ) {
            unset( $dsigBase->XMLattributes[$key] );
        }
        foreach( get_object_vars( $dsigBase ) as $propertyValue ) {
            if( $propertyValue instanceof self ) {
                if( $unset ) {
                    $propertyValue->unsetXMLattribute( $key, true );
                }
                else {
                    $propertyValue->setXMLattribute( $key, ( $value ?: '' ), true );
                }
            } // end if
            elseif( is_array( $propertyValue )) {
                self::propagateDownArray( $propertyValue, $key, $value, $unset );
            } // end elseif
        } // end foreach
    }

    /**
     * Propagate set or remove XML attribute opt down in array
     *
     * @param array       $arrayValue
     * @param string      $key
     * @param null|string $value
     * @param null|bool   $unset
     * @throws InvalidArgumentException
     */
    protected static function propagateDownArray(
        array $arrayValue,
        string $key,
        ? string $value = null,
        ? bool $unset = false
    ) : void
    {
        Assert::boolean( $unset );
        foreach( $arrayValue as $arrayValue2 ) {
            if( $arrayValue2 instanceof self ) {
                if( $unset ) {
                    $arrayValue2->unsetXMLattribute( $key, true );
                }
                else {
                    $arrayValue2->setXMLattribute( $key, ( $value ?: '' ), true );
                }
            } // end if
            elseif( is_array( $arrayValue2 )) {
                self::propagateDownArray( $arrayValue2, $key, $value, $unset );
            } // end elseif
        } // end foreach
    }

    /**
     * Set XML attributes (baseURI, localName, name, name prefix, namespaceURI) from XMLreader (Element node)
     *
     * @param XMLReader $reader
     * @return static
     */
    public function setXMLattributes( XMLReader $reader ) : static
    {
        $this->XMLattributes[self::BASEURI]      = $reader->baseURI ;
        $this->XMLattributes[self::LOCALNAME]    = $reader->localName ;
        $this->XMLattributes[self::NAME]         = $reader->name ;
        $this->XMLattributes[self::PREFIX]       = $reader->prefix ;
        $this->XMLattributes[self::NAMESPACEURI] = $reader->namespaceURI ;
        return $this;
    }

    /**
     * Return bool true if key is a XML schema key
     *
     * @param string $key
     * @return bool
     */
    public static function isXmlAttrKey( string $key ) : bool
    {
        return ( in_array( $key, self::XMLSchemaKeys, true ) ||
            ( str_starts_with( $key, self::XMLNS )));
    }
}
