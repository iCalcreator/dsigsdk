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

use Kigkonsult\DsigSdk\Dto\Traits\IdTrait;

/**
 * Class SignedInfoType
 */
class SignedInfoType extends DsigBase
{
    /**
     * @var CanonicalizationMethod|null
     */
    protected ?CanonicalizationMethod $canonicalizationMethod = null;

    /**
     * @var SignatureMethod|null
     */
    protected ?SignatureMethod $signatureMethod = null;

    /**
     * @var Reference[]
     *                    maxOccurs="unbounded"
     */
    protected array $reference = [];

    /**
     * Property, get- and setter methods for
     * var string id
     *            attribute name="Id" type="ID" use="optional"
     */
    use IdTrait;

    /**
     * @return null|CanonicalizationMethod
     */
    public function getCanonicalizationMethod() : ?CanonicalizationMethod
    {
        return $this->canonicalizationMethod;
    }

    /**
     * Return bool true if canonicalizationMethod is set
     *
     * @return bool
     */
    public function isCanonicalizationMethodSet() : bool
    {
        return ( null !== $this->canonicalizationMethod );
    }

    /**
     * @param CanonicalizationMethod $canonicalizationMethod
     * @return static
     */
    public function setCanonicalizationMethod(
        CanonicalizationMethod $canonicalizationMethod
    ) : static
    {
        $this->canonicalizationMethod = $canonicalizationMethod;
        return $this;
    }

    /**
     * @return null|SignatureMethod
     */
    public function getSignatureMethod() : ?SignatureMethod
    {
        return $this->signatureMethod;
    }

    /**
     * Return bool true if signatureMethod is set
     *
     * @return bool
     */
    public function isSignatureMethodSet() : bool
    {
        return ( null !== $this->signatureMethod );
    }

    /**
     * @param SignatureMethod $signatureMethod
     * @return static
     */
    public function setSignatureMethod( SignatureMethod $signatureMethod ) : static
    {
        $this->signatureMethod = $signatureMethod;
        return $this;
    }

    /**
     * @return Reference[]
     */
    public function getReference() : array
    {
        return $this->reference;
    }

    /**
     * Return bool true if reference is not empty
     *
     * @return bool
     */
    public function isReferenceSet() : bool
    {
        return ! empty( $this->reference );
    }

    /**
     * @param Reference $reference
     * @return static
     */
    public function addReference( Reference $reference ) : static
    {
        $this->reference[] = $reference;
        return $this;
    }

    /**
     * @param Reference[] $reference
     * @return static
     */
    public function setReference( array $reference ) : static
    {
        foreach( $reference as $rType ) {
            $this->addReference( $rType );
        }
        return $this;
    }
}
