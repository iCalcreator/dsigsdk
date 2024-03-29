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

use Kigkonsult\DsigSdk\Dto\Traits\IdTrait;
use function gettype;
use function in_array;
use function is_object;

/**
 * Class Objekt
 */
class ObjectType extends DsigBase
{
    /**
     * @var array
     *
     * Manifest[]|SignatureProperties[]|Any[] mixed
     * in keyed elementSets : [ key => valueType ]
     * key : self::MANIFEST / self::SIGNATUREPROPERTIES / self::ANYTYPE
     * minOccurs="0" maxOccurs="unbounded" namespace="##any" processContents="lax"
     */
    protected array $objectTypes = [];

    /**
     * Property, get- and setter methods for
     * var string id
     *            attribute name="Id" type="ID" use="optional"
     */
    use IdTrait;

    /**
     * @var null|string
     *            attribute name="MimeType" type="string" use="optional"
     */
    protected ?string $mimeType = null;

    /**
     * @var null|string
     *            attribute name="Encoding" type="anyURI" use="optional"
     */
    protected ?string $encoding = null;

    /**
     * @return array Manifest[]|SignatureProperties[]|Any[] mixed
     */
    public function getObjectTypes() : array
    {
        return $this->objectTypes;
    }

    /**
     * Return bool true if objectTypes is not empty
     *
     * @return bool
     */
    public function isObjectTypesSet() : bool
    {
        return ! empty( $this->objectTypes );
    }

    /**
     * @param string $type
     * @param mixed $objectType  Manifest / SignatureProperties / Any
     * @return static
     * @throws InvalidArgumentException
     */
    public function addObjectType( string $type, mixed $objectType ) : static
    {
        static $ANYTYPEs = [ self::ANY, self::ANYTYPE ];
        if((( self::MANIFEST === $type ) &&
                ( $objectType instanceof Manifest )) ||
            (( self::SIGNATUREPROPERTIES === $type ) &&
                ( $objectType instanceof SignatureProperties ))) {
            $this->objectTypes[] = [ $type => $objectType ];
            return $this;
        }
        if( ( $objectType instanceof AnyType ) && in_array( $type, $ANYTYPEs, true )) {
            $this->objectTypes[] = [ self::ANYTYPE => $objectType ];
            return $this;
        }
        throw new InvalidArgumentException(
            sprintf(
                self::$FMTERR0,
                self::OBJECT,
                $type,
                is_object( $objectType )
                    ? $objectType::class
                    : gettype( $objectType )
            )
        );
    }

    /**
     * @param array $objectTypes * [ type => Manifest|SignatureProperties|Any ]
     * @return static
     * @throws InvalidArgumentException
     */
    public function setObjectTypes( array $objectTypes ) : static
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
    public function getMimeType() : ?string
    {
        return $this->mimeType;
    }

    /**
     * Return bool true if mimeType is set
     *
     * @return bool
     */
    public function isMimeTypeSet() : bool
    {
        return ( null !== $this->mimeType );
    }

    /**
     * @param string $mimeType
     * @return static
     */
    public function setMimeType( string $mimeType ) : static
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getEncoding() : ?string
    {
        return $this->encoding;
    }

    /**
     * Return bool true if encoding is set
     *
     * @return bool
     */
    public function isEncodingSet() : bool
    {
        return ( null !== $this->encoding );
    }
    /**
     * @param string $encoding
     * @return static
     */
    public function setEncoding( string $encoding ) : static
    {
        $this->encoding = $encoding;
        return $this;
    }
}
