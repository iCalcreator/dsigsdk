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
use Webmozart\Assert\Assert;

use function is_array;
use function gettype;
use function sprintf;

/**
 * Class SPKIDataType
 */
class SPKIDataType extends DsigBase
{
    /**
     * @var array
     *
     * each element is a keyed pair of SPKISexp/AnyType
     *         [ self::SPKISEXP => "base64Binary" ]
     *         [ self::ANYTYPE  => AnyType ]
     */
    protected $SPKIDataType = [];

    /**
     * @return array
     */
    public function getSPKIDataType() : array
    {
        return $this->SPKIDataType;
    }

    /**
     * @param string $type
     * @param mixed  $SPKIData
     * @return static
     * @throws InvalidArgumentException
     */
    public function addSPKIDataType( string $type, $SPKIData ) : self
    {
        switch( $type ) {
            case self::SPKISEXP :
                Assert::string( $SPKIData );
                break;
            case self::ANYTYPE :
                Assert::isInstanceOf( $SPKIData, AnyType::class );
                break;
            default :
                throw new InvalidArgumentException(
                    sprintf( self::$FMTERR0, self::SPKIDATA, $type, gettype( $SPKIData))
                );
        } // end switch
        $this->SPKIDataType[] = [ $type => $SPKIData ];
        return $this;
    }

    /**
     * @param array $SPKIData  *[ type => value ]
     * @return static
     * @throws InvalidArgumentException
     */
    public function setSPKIDataType( array $SPKIData ) : self
    {
        foreach( $SPKIData as $ix1 => $elementSet ) {
            if( ! is_array( $elementSet )) {
                $elementSet = [ $ix1 => $elementSet ];
            }
            foreach( $elementSet as $type => $value ) {
                $this->addSPKIDataType( $type, $value );
            } // end foreach
        }
        return $this;
    }
}
