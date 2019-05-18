<?php
/**
 * DsigSdk   the PHP XML Digital Signature recomendation SDK, 
 *           source http://www.w3.org/2000/09/xmldsig#
 *
 * Copyright (c) 2019 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * Link      https://kigkonsult.se
 * Version   0.95
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
 *
 * This file is a part of DsigSdk.
 */
namespace Kigkonsult\DsigSdk;

/**
 * Interface XMLAttributesInterface
 */
interface XMLAttributesInterface
{
    /**
     * const  XML root element attributes
     */
    const XMLNS_XSI          = 'xmlns:xsi';
    const XMLNS_XSD          = 'xmlns:xsd';
    const XSI_SCHEMALOCATION = 'xsi:schemaLocation';
    const XMLNS              = 'xmlns';

    /**
     * const XMLreader element node properties
     */
    const BASEURI            = 'baseURI';      // The base URI of the node
    const LOCALNAME          = 'localName';    // The local name of the node
    const NAME               = 'name';         // The qualified name of the node
    const NAMESPACEURI       = 'namespaceURI'; // The URI of the namespace associated with the node
    const PREFIX             = 'prefix';       // The prefix of the namespace associated with the node

}