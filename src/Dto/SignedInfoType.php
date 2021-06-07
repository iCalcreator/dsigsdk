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

/**
 * Class SignedInfoType
 */
class SignedInfoType extends DsigBase
{
    /**
     * @var CanonicalizationMethodType
     */
    protected $canonicalizationMethod = null;

    /**
     * @var SignatureMethodType
     */
    protected $signatureMethod = null;

    /**
     * @var ReferenceType[]
     *                    maxOccurs="unbounded"
     */
    protected $reference = [];

    /**
     * Property, get- and setter methods for
     * var string id
     *            attribute name="Id" type="ID" use="optional"
     */
    use Traits\IdTrait;

    /**
     * @return null|CanonicalizationMethodType
     */
    public function getCanonicalizationMethod()
    {
        return $this->canonicalizationMethod;
    }

    /**
     * @param CanonicalizationMethodType $canonicalizationMethod
     * @return static
     */
    public function setCanonicalizationMethod(
        CanonicalizationMethodType $canonicalizationMethod
    ) : self
    {
        $this->canonicalizationMethod = $canonicalizationMethod;
        return $this;
    }

    /**
     * @return null|SignatureMethodType
     */
    public function getSignatureMethod()
    {
        return $this->signatureMethod;
    }

    /**
     * @param SignatureMethodType $signatureMethod
     * @return static
     */
    public function setSignatureMethod( SignatureMethodType $signatureMethod ) : self
    {
        $this->signatureMethod = $signatureMethod;
        return $this;
    }

    /**
     * @return ReferenceType[]
     */
    public function getReference() : array
    {
        return $this->reference;
    }

    /**
     * @param ReferenceType $reference
     * @return static
     */
    public function addReference( ReferenceType $reference ) : self
    {
        $this->reference[] = $reference;
        return $this;
    }

    /**
     * @param ReferenceType[] $reference
     * @return static
     */
    public function setReference( array $reference ) : self
    {
        foreach( $reference as $rType ) {
            $this->addReference( $rType );
        }
        return $this;
    }
}
