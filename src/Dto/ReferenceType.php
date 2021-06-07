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
 * Class ReferenceType
 */
class ReferenceType extends DsigBase
{
    /**
     * @var TransformsType
     *                     minOccurs="0"
     */
    protected $transforms = null;

    /**
     * @var DigestMethodType
     */
    protected $digestMethod = null;

    /**
     * @var string
     *            base="base64Binary"
     */
    protected $digestValue = null;

    /**
     * Property, get- and setter methods for
     * var string id
     *            attribute name="Id" type="ID" use="optional"
     */
    use Traits\IdTrait;

    /**
     * Property, get- and setter methods for
     * var string type
     *            attribute name="URI" type="anyURI" use="optional"
     */
    use Traits\URITrait;

    /**
     * Property, get- and setter methods for
     * var string type
     *            attribute name="Type" type="anyURI" use="optional"
     */
    use Traits\TypeTrait;

    /**
     * @return null|TransformsType
     */
    public function getTransforms()
    {
        return $this->transforms;
    }

    /**
     * @param TransformsType $transforms
     * @return static
     */
    public function setTransforms( TransformsType $transforms ) : self
    {
        $this->transforms = $transforms;
        return $this;
    }

    /**
     * @return null|DigestMethodType
     */
    public function getDigestMethod()
    {
        return $this->digestMethod;
    }

    /**
     * @param DigestMethodType $digestMethod
     * @return static
     */
    public function setDigestMethod( DigestMethodType $digestMethod ) : self
    {
        $this->digestMethod = $digestMethod;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getDigestValue()
    {
        return $this->digestValue;
    }

    /**
     * @param string $digestValue
     * @return static
     */
    public function setDigestValue( string $digestValue ) : self
    {
        $this->digestValue = $digestValue;
        return $this;
    }
}
