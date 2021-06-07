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
 * Class Signature
 *
 * schemaLocation="http://www.w3.org/TR/2002/REC-xmldsig-core-20020212/xmldsig-core-schema.xsd"
 * namespace="http://www.w3.org/2000/09/xmldsig#"
 */
class SignatureType extends DsigBase
{
    /**
     * @var SignedInfoType
     */
    protected $signedInfo = null;

    /**
     * @var SignatureValueType
     */
    protected $signatureValue = null;

    /**
     * @var KeyInfoType
     *                  minOccurs="0"
     */
    protected $keyInfo = null;

    /**
     * @var ObjectType[]
     *           minOccurs="0" maxOccurs="unbounded"
     */
    protected $object = [];

    /**
     * Property, get- and setter methods for
     * var string id
     *            attribute name="Id" type="ID" use="optional"
     */
    use Traits\IdTrait;

    /**
     * @return null|SignedInfoType
     */
    public function getSignedInfo()
    {
        return $this->signedInfo;
    }

    /**
     * @param SignedInfoType $signedInfo
     * @return static
     */
    public function setSignedInfo( SignedInfoType $signedInfo ) : self
    {
        $this->signedInfo = $signedInfo;
        return $this;
    }

    /**
     * @return null|SignatureValueType
     */
    public function getSignatureValue()
    {
        return $this->signatureValue;
    }

    /**
     * @param SignatureValueType $signatureValue
     * @return static
     */
    public function setSignatureValue( SignatureValueType $signatureValue ) : self
    {
        $this->signatureValue = $signatureValue;
        return $this;
    }

    /**
     * @return null|KeyInfoType
     */
    public function getKeyInfo()
    {
        return $this->keyInfo;
    }

    /**
     * @param KeyInfoType $keyInfo
     * @return static
     */
    public function setKeyInfo( KeyInfoType $keyInfo ) : self
    {
        $this->keyInfo = $keyInfo;
        return $this;
    }

    /**
     * @return ObjectType[]
     */
    public function getObject() : array
    {
        return $this->object;
    }

    /**
     * @param ObjectType $object
     * @return static
     */
    public function addObject( ObjectType $object ) : self
    {
        $this->object[] = $object;
        return $this;
    }

    /**
     * @param ObjectType[] $object
     * @return static
     */
    public function setObject( array $object ) : self
    {
        foreach( $object as $objectType ) {
            $this->addObject( $objectType );
        }
        return $this;
    }
}
