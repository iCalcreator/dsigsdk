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
use Kigkonsult\DsigSdk\DsigInterface;
use Kigkonsult\DsigSdk\XMLAttributesInterface;
use Webmozart\Assert\Assert;
use XMLReader;

/**
 * Class DsigBase
 */
abstract class DsigBase implements DsigInterface, XMLAttributesInterface
{
    /**
     * @var string
     */
    protected static $FMTERR1 = 'Unknown %s type #%s \'%s\'';
    protected static $FMTERR2 = 'Unknown %s type #%s:%s \'%s\'';
    protected static $PLCHDLR = '%s';
    protected static $TYPE    = 'Type';

    /**
     * @var array
     */
    protected $XMLattributes = [];

    /**
     * Factory
     *
     * @return static
     * @static
     */
    public static function factory() {
        $class = get_called_class();
        return new $class();
    }

    /**
     * Get XML attributes
     *
     * @return array
     */
    public function getXMLattributes() {
        return $this->XMLattributes;
    }

    /**
     * Set XML attributes, opt propagate down
     *
     * @param string $key
     * @param string $value
     * @param bool   $propagateDown
     * @return static
     * @throws InvalidArgumentException
     */
    public function setXMLattribute( $key, $value, $propagateDown = false ) {
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
     * @param string $key
     * @param bool   $propagateDown
     * @return static
     */
    public function unsetXMLattribute( $key, $propagateDown = false ) {
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
     * @static
     */
    protected static function propagateDown( DsigBase $dsigBase, $key, $value, $unset = false ) {
        Assert::boolean( $unset );
        if( $unset ) {
            unset( $dsigBase->XMLattributes[$key] );
        }
        foreach( get_object_vars( $dsigBase ) as $propertyValue ) {
            if( $propertyValue instanceof DsigBase ) {
                if( $unset ) {
                    $propertyValue->unsetXMLattribute( $key, true );
                }
                else {
                    $propertyValue->setXMLattribute( $key, $value, true );
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
     * @param array  $arrayValue
     * @param string $key
     * @param string $value
     * @param bool   $unset
     * @static
     */
    protected static function propagateDownArray( array $arrayValue, $key, $value, $unset = false ) {
        Assert::boolean( $unset );
        foreach( $arrayValue as $arrayValue2 ) {
            if( $arrayValue2 instanceof DsigBase ) {
                if( $unset ) {
                    $arrayValue2->unsetXMLattribute( $key, true );
                }
                else {
                    $arrayValue2->setXMLattribute( $key, $value, true );
                }
            } // end if
            elseif( is_array( $arrayValue2 )) {
                self::propagateDownArray( $arrayValue2, $key, $value, $unset );
            } // end elseif
        } // end foreach
    }

    /**
     * Set XML attributes from XMLreader ( Element node)
     *
     * @param XMLReader $reader
     * @return static
     */
    public function setXMLattributes( $reader ) {
        $this->XMLattributes[self::BASEURI]      = $reader->baseURI ;
        $this->XMLattributes[self::LOCALNAME]    = $reader->localName ;
        $this->XMLattributes[self::NAME]         = $reader->name ;
        $this->XMLattributes[self::NAMESPACEURI] = $reader->namespaceURI ;
        $this->XMLattributes[self::PREFIX]       = $reader->prefix ;
        return $this;
    }

    /**
     * @return string
     * @static
     */
    protected static function getNs() {
        static $BS = '\\';
        return __NAMESPACE__ . $BS;
    }
}
