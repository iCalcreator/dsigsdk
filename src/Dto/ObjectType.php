<?php
/**
 * DsigSdk    the PHP XML Digital Signature recommendation SDK,
 *            source http://www.w3.org/2000/09/xmldsig#
 *
 * This file is a part of DsigSdk.
 *
 * @author    Kjell-Inge Gustafsson, kigkonsult <ical@kigkonsult.se>
 * @copyright 2019-21 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
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

use function gettype;

/**
 * Class ObjectType
 */
class ObjectType extends DsigBase
{
    /**
     * @var array
     *
     * Manifest[]|SignaturePropertiesType[]|AnyType[] mixed
     * in keyed elementSets : [ key => valueType ]
     * key : self::MANIFEST / self::SIGNATUREPROPERTIES / self::ANYTYPE
     * minOccurs="0" maxOccurs="unbounded" namespace="##any" processContents="lax"
     *
     *
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
    public function getObjectTypes() : array
    {
        return $this->objectTypes;
    }

    /**
     * @param string $type
     * @param mixed $objectType  Manifest / SignaturePropertiesType / AnyType
     * @return static
     * @throws InvalidArgumentException
     */
    public function addObjectType( string $type, $objectType ) : self
    {
        if((( self::MANIFEST == $type ) &&
                ( $objectType instanceof ManifestType )) ||
            (( self::SIGNATUREPROPERTIES == $type ) &&
                ( $objectType instanceof SignaturePropertiesType )) ||
            (( self::ANYTYPE == $type ) &&
                ( $objectType instanceof AnyType ))) {
            $this->objectTypes[] = [ $type => $objectType ];
            return $this;
        }
        throw new InvalidArgumentException(
            sprintf( self::$FMTERR0, self::OBJECT, $type, gettype( $objectType ))
        );
    }

    /**
     * @param array $objectTypes * [ type => Manifest|SignatureProperties|AnyType ]
     * @return static
     * @throws InvalidArgumentException
     */
    public function setObjectTypes( array $objectTypes ) : self
    {
        foreach( $objectTypes as $ix => $element ) {
            if( ! is_array( $element )) {
                $element = [ $ix => $element ];
            }
            foreach( $element as $type => $value ) {
                $this->addObjectType( $type, $value );
            } // end foreach
        } // end foreach
        return $this;
    }

    /**
     * @return null|string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     * @return static
     */
    public function setMimeType( string $mimeType ) : self
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * @param string $encoding
     * @return static
     */
    public function setEncoding( string $encoding ) : self
    {
        $this->encoding = $encoding;
        return $this;
    }
}
