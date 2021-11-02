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
use Kigkonsult\DsigSdk\Dto\Traits\AlgorithmTrait;
use Webmozart\Assert\Assert;

use function is_array;
use function sprintf;

/**
 * Class SignatureMethodType
 */
class SignatureMethodType extends DsigBase
{
    /**
     * @var array
     *
     * array pairs of 0-1 HMACOutputLengthType (int) and/or 0-~ Any
     * each pair *[ key => type ]
     * key : self::HMACOUTPUTLENGTH / self::ANYTYPE
     */
    protected array $signatureMethodTypes = [];

    /**
     * Property, get- and setter methods for
     * var string algorithm
     *            attribute name="Algorithm" type="anyURI" use="required"
     */
    use AlgorithmTrait;


    /**
     * @return array
     */
    public function getSignatureMethodTypes() : array
    {
        return $this->signatureMethodTypes;
    }

    /**
     * @param string $type
     * @param mixed  $signatureMethodType
     * @return static
     * @throws InvalidArgumentException
     */
    public function addSignatureMethodType( string $type, mixed $signatureMethodType ) : static
    {
        switch( $type ) {
            case self::HMACOUTPUTLENGTH :
                Assert::integerish( $signatureMethodType );
                Assert::greaterThan(
                    $signatureMethodType,
                    0,
                    sprintf(
                        self::$FMTERR0,
                        self::SIGNATUREMETHOD,
                        $type,
                        $signatureMethodType
                    )
                );
                break;
            case  self::ANY :
                $type = self::ANYTYPE;
                // fall through
            case  self::ANYTYPE :
                Assert::isInstanceOf( $signatureMethodType, Any::class );
                break;
            default :
                throw new InvalidArgumentException(
                    sprintf( self::$FMTERR0,
                        self::SIGNATUREMETHOD,
                        $type,
                        gettype( $signatureMethodType )
                    )
                );
        } // end switch
        $this->signatureMethodTypes[] = [ $type => $signatureMethodType ];
        return $this;
    }

    /**
     * @param array $signatureMethodTypes *[ type => value ]
     * @return static
     * @throws InvalidArgumentException
     */
    public function setSignatureMethodTypes( array $signatureMethodTypes ) : static
    {
        foreach( $signatureMethodTypes as $ix1 => $elementSet ) {
            if( ! is_array( $elementSet )) {
                $elementSet = [ $ix1 => $elementSet ];
            }
            foreach( $elementSet as $ix2 => $element ) {
                if( ! is_array( $element )) {
                    $element = [ $ix2 => $element ];
                }
                foreach( $element as $type => $value ) {
                    $this->addSignatureMethodType( $type, $value );
                } // end foreach
            } // end foreach
        } // end foreach
        return $this;
    }
}
