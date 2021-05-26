<?php
/**
 * DsigSdk   the PHP XML Digital Signature recommendation SDK, 
 *           source http://www.w3.org/2000/09/xmldsig#
 *
 * This file is a part of DsigSdk.
 *
 * Copyright 2019 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * author    Kjell-Inge Gustafsson, kigkonsult
 * Link      https://kigkonsult.se
 * Package   DsigSdk
 * Version   0.971
 * License   Subject matter of licence is the software DsigSdk.
 *           The above copyright, link, package and version notices,
 *           this licence notice shall be included in all copies or substantial 
 *           portions of the DsigSdk.
 *
 *           DsigSdk is free software: you can redistribute it and/or modify
 *           it under the terms of the GNU Lesser General Public License as published
 *           by the Free Software Foundation, either version 3 of the License,
 *           or (at your option) any later version.
 *
 *           DsigSdk is distributed in the hope that it will be useful,
 *           but WITHOUT ANY WARRANTY; without even the implied warranty of
 *           MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *           GNU Lesser General Public License for more details.
 *
 *           You should have received a copy of the GNU Lesser General Public License
 *           along with DsigSdk. If not, see <https://www.gnu.org/licenses/>.
 */
namespace Kigkonsult\DsigSdk\Dto;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

/**
 * Class ReferenceType
 */
class ReferenceType extends DsigBase
{
    /**
     * @var TransformsType
     *                     minOccurs="0"
     * @access protected
     */
    protected $transforms = null;

    /**
     * @var DigestMethodType
     * @access protected
     */
    protected $digestMethod = null;

    /**
     * @var string
     *            base="base64Binary"
     * @access protected
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
     * @return TransformsType
     */
    public function getTransforms() {
        return $this->transforms;
    }

    /**
     * @param TransformsType $transforms
     * @return static
     */
    public function setTransforms( TransformsType $transforms ) {
        $this->transforms = $transforms;
        return $this;
    }

    /**
     * @return DigestMethodType
     */
    public function getDigestMethod() {
        return $this->digestMethod;
    }

    /**
     * @param DigestMethodType $digestMethod
     * @return static
     */
    public function setDigestMethod( DigestMethodType $digestMethod ) {
        $this->digestMethod = $digestMethod;
        return $this;
    }

    /**
     * @return string
     */
    public function getDigestValue() {
        return $this->digestValue;
    }

    /**
     * @param string $digestValue
     * @return static
     * @throws InvalidArgumentException
     */
    public function setDigestValue( $digestValue ) {
        Assert::string( $digestValue );
        $this->digestValue = $digestValue;
        return $this;
    }

}