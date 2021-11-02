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

use Kigkonsult\DsigSdk\Dto\Traits\IdTrait;

/**
 * Class SignatureType
 *
 * schemaLocation="http://www.w3.org/TR/2002/REC-xmldsig-core-20020212/xmldsig-core-schema.xsd"
 * namespace="http://www.w3.org/2000/09/xmldsig#"
 */
class SignatureType extends DsigBase
{
    /**
     * @var SignedInfo|null
     */
    protected ?SignedInfo $signedInfo = null;

    /**
     * @var SignatureValue|null
     */
    protected ?SignatureValue $signatureValue = null;

    /**
     * @var KeyInfo|null
     *                  minOccurs="0"
     */
    protected ?KeyInfo $keyInfo = null;

    /**
     * @var Objekt[]
     *           minOccurs="0" maxOccurs="unbounded"
     */
    protected array $object = [];

    /**
     * Property, get- and setter methods for
     * var string id
     *            attribute name="Id" type="ID" use="optional"
     */
    use IdTrait;

    /**
     * @return null|SignedInfo
     */
    public function getSignedInfo() : ?SignedInfo
    {
        return $this->signedInfo;
    }

    /**
     * @param SignedInfo $signedInfo
     * @return static
     */
    public function setSignedInfo( SignedInfo $signedInfo ) : static
    {
        $this->signedInfo = $signedInfo;
        return $this;
    }

    /**
     * @return null|SignatureValue
     */
    public function getSignatureValue() : ?SignatureValue
    {
        return $this->signatureValue;
    }

    /**
     * @param SignatureValue $signatureValue
     * @return static
     */
    public function setSignatureValue( SignatureValue $signatureValue ) : static
    {
        $this->signatureValue = $signatureValue;
        return $this;
    }

    /**
     * @return null|KeyInfo
     */
    public function getKeyInfo() : ?KeyInfo
    {
        return $this->keyInfo;
    }

    /**
     * @param KeyInfo $keyInfo
     * @return static
     */
    public function setKeyInfo( KeyInfo $keyInfo ) : static
    {
        $this->keyInfo = $keyInfo;
        return $this;
    }

    /**
     * @return Objekt[]
     */
    public function getObject() : array
    {
        return $this->object;
    }

    /**
     * @param Objekt $object
     * @return static
     */
    public function addObject( Objekt $object ) : static
    {
        $this->object[] = $object;
        return $this;
    }

    /**
     * @param Objekt[] $object
     * @return static
     */
    public function setObject( array $object ) : static
    {
        foreach( $object as $objectType ) {
            $this->addObject( $objectType );
        }
        return $this;
    }
}
