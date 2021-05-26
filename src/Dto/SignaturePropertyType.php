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
 * Class SignaturePropertyType
 */
class SignaturePropertyType extends DsigBase
{

    /**
     * Property, get- and setter methods
     * var AnyType[]  any
     *               maxOccurs="unbounded"
     */
    use Traits\AnyTypesTrait;

    /**
     * @var string
     *            attribute name="Target" type="anyURI" use="required"
     * @access protected
     */
    protected $target = null;

    /**
     * Property, get- and setter methods for
     * var string id
     *            attribute name="Id" type="ID" use="optional"
     */
    use Traits\IdTrait;


    /**
     * @return string
     */
    public function getTarget() {
        return $this->target;
    }

    /**
     * @param string $target
     * @return static
     * @throws InvalidArgumentException
     */
    public function setTarget( $target ) {
        Assert::string( $target );
        $this->target = $target;
        return $this;
    }

}