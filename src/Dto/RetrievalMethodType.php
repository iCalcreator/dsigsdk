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

use Kigkonsult\DsigSdk\Dto\Traits\TypeTrait;
use Kigkonsult\DsigSdk\Dto\Traits\URITrait;

/**
 * Class RetrievalMethodType
 */
class RetrievalMethodType extends DsigBase
{
    /**
     * @var Transforms|null
     *                     minOccurs="0"
     */
    protected ?Transforms $transforms = null;

    /**
     * Property, get- and setter methods for
     * var string type
     *            attribute name="URI" type="anyURI"
     */
    use URITrait;

    /**
     * Property, get- and setter methods for
     * var string type
     *            attribute name="Type" type="anyURI" use="optional"
     */
    use TypeTrait;

    /**
     * @return null|Transforms
     */
    public function getTransforms() : ?Transforms
    {
        return $this->transforms;
    }

    /**
     * Return bool true if ransforms is set
     *
     * @return bool
     */
    public function isTransformsSet() : bool
    {
        return ( null !== $this->transforms );
    }
    /**
     * @param Transforms $transforms
     * @return static
     */
    public function setTransforms( Transforms $transforms ) : static
    {
        $this->transforms = $transforms;
        return $this;
    }
}
