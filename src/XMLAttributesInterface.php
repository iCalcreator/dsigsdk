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
namespace Kigkonsult\DsigSdk;

/**
 * Interface XMLAttributesInterface
 */
interface XMLAttributesInterface
{
    /**
     * const  XML root element attributes
     */
    public const XMLNS_XSI          = 'xmlns:xsi';
    public const XMLNS_XSD          = 'xmlns:xsd';
    public const XSI_SCHEMALOCATION = 'xsi:schemaLocation';
    public const XMLNS              = 'xmlns';

    /**
     * const XMLreader element node properties
     */
    public const BASEURI            = 'baseURI';      // The base URI of the node
    public const LOCALNAME          = 'localName';    // The local name of the node
    public const NAME               = 'name';         // The qualified name of the node
    public const NAMESPACEURI       = 'namespaceURI'; // The URI of the namespace associated with the node
    public const PREFIX             = 'prefix';       // The prefix of the namespace associated with the node
}
