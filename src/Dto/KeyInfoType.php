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
use Webmozart\Assert\Assert;

use function is_array;
use function gettype;
use function sprintf;

/**
 * Class KeyInfoType
 */
class KeyInfoType extends DsigBase
{
    /**
     * @var array
     *
     * Sets of [ KeyName(string)  => valueType ]
     *    self::KEYNAME         => KeyValue
     *    self::KEYVALUE        => KeyValue
     *    self::RETRIEVALMETHOD => RetrievalMethod
     *    self::X509DATA        => X509Data
     *    self::PGPDATA         => PGPData
     *    self::SPKIDATA        => SPKIData
     *    self::MGMTDATA        => string
     *    self::ANYTYPE         => Any
     *
     * choice maxOccurs="unbounded"
     */
    protected array $keyInfoType = [];

    /**
     * Property, get- and setter methods for
     * var string id
     *            attribute name="Id" type="ID" use="optional"
     */
    use IdTrait;

    /**
     * Factory method with type and keyInfoType
     *
     * @param string $type
     * @param mixed $keyInfoType
     * @return static
     * @throws InvalidArgumentException
     */
    public static function factoryKeyInfo( string $type, mixed $keyInfoType ) : static
    {
        return self::factory()->addKeyInfoType( $type, $keyInfoType );
    }

    /**
     * @return array
     */
    public function getKeyInfoType() : array
    {
        return $this->keyInfoType;
    }

    /**
     * @param string $type
     * @param mixed $keyInfoType
     * @return static
     * @throws InvalidArgumentException
     */
    public function addKeyInfoType( string $type, mixed $keyInfoType ) : static
    {
        switch( $type ) {
            case self::KEYNAME :
                Assert::string( $keyInfoType );
                break;
            case self::KEYVALUE :
                break;
            case self::RETRIEVALMETHOD :
                break;
            case self::X509DATA :
                break;
            case self::PGPDATA :
                break;
            case self::SPKIDATA :
                break;
            case self::MGMTDATA :
                Assert::string( $keyInfoType );
                break;
            case  self::ANY :
                $type = self::ANYTYPE;
                // fall through
            case self::ANYTYPE :
                break;
            default :
                throw new InvalidArgumentException(
                    sprintf( self::$FMTERR0, self::KEYINFO, $type, gettype( $keyInfoType ))
                );
        } // end switch
        $this->keyInfoType[] = [ $type => $keyInfoType ];
        return $this;
    }

    /**
     * Return bool true if keyInfoType is not empty
     *
     * @return bool
     */
    public function isKeyInfoTypeSet() : bool
    {
        return ! empty( $this->keyInfoType );
    }
    /**
     * @param array $keyInfoType *[ type => value ]
     * @return static
     * @throws InvalidArgumentException
     */
    public function setKeyInfoType( array $keyInfoType ) : static
    {
        foreach( $keyInfoType as $ix => $element ) {
            if( ! is_array( $element )) {
                $element = [ $ix => $element ];
            }
            foreach( $element as $type => $value ) {
                $this->addKeyInfoType( $type, $value );
            } // end foreach
        } // end foreach
        return $this;
    }
}
