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
 * Class SignaturePropertiesType
 *
 * schemaLocation="http://www.w3.org/TR/2002/REC-xmldsig-core-20020212/xmldsig-core-schema.xsd"
 * namespace="http://www.w3.org/2000/09/xmldsig#"
 */
class SignaturePropertiesType extends DsigBase
{
    /**
     * @var SignatureProperty[]
     *                     maxOccurs="unbounded"
     */
    protected array $signatureProperty = [];

    /**
     * Property, get- and setter methods for
     * var string id
     *            attribute name="Id" type="ID" use="optional"
     */
    use IdTrait;

    /**
     * Factory method with one signatureProperty
     *
     * @param SignatureProperty $signatureProperty
     * @return static
     */
    public static function factorySignatureProperty( SignatureProperty $signatureProperty ) : static
    {
        return self::factory()->addSignatureProperty( $signatureProperty );
    }

    /**
     * @return SignatureProperty[]
     */
    public function getSignatureProperty() : array
    {
        return $this->signatureProperty;
    }

    /**
     * Return bool true if signatureProperty is not empty
     *
     * @return bool
     */
    public function isSignaturePropertySet() : bool
    {
        return ! empty( $this->signatureProperty );
    }

    /**
     * @param SignatureProperty $signatureProperty
     * @return static
     */
    public function addSignatureProperty( SignatureProperty $signatureProperty ) : static
    {
        $this->signatureProperty[] = $signatureProperty;
        return $this;
    }

    /**
     * @param SignatureProperty[] $signatureProperty
     * @return static
     */
    public function setSignatureProperty( array $signatureProperty ) : static
    {
        foreach( $signatureProperty as $signProp ) {
            $this->addSignatureProperty( $signProp );
        }
        return $this;
    }
}
