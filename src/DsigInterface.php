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
 * Interface DsigInterface
 */
interface DsigInterface
{
    /**
     * xmldsig element constants
     */
    const ANYTYPE                = 'AnyType';
    const CANONICALIZATIONMETHOD = 'CanonicalizationMethod';
    const DSAKEYVALUE            = 'DSAKeyValue';
    const EXPONENT               = 'Exponent';
    const DIGESTMETHOD           = 'DigestMethod';
    const DIGESTVALUE            = 'DigestValue';
    const G                      = 'G';
    const HMACOUTPUTLENGTH       = 'HMACOutputLength';
    const J                      = 'J';
    const KEYINFO                = 'KeyInfo';
    const KEYNAME                = 'KeyName';
    const KEYVALUE               = 'KeyValue';
    const MANIFEST               = 'Manifest';
    const MGMTDATA               = 'MgmtData';
    const MODULUS                = 'Modulus';
    const OBJECT                 = 'Objekt';
    const P                      = 'P';
    const PGENCOUNTER            = 'PgenCounter';
    const PGPDATA                = 'PGPData';
    const PGPKEYID               = 'PGPKeyID';
    const PGPKEYPACKET           = 'PGPKeyPacket';
    const Q                      = 'Q';
    const REFERENS               = 'Reference';
    const RETRIEVALMETHOD        = 'RetrievalMethod';
    const RSAKEYVALUE            = 'RSAKeyValue';
    const SEED                   = 'Seed';
    const SIGNATURE              = 'Signature';
    const SIGNATUREMETHOD        = 'SignatureMethod';
    const SIGNATUREVALUE         = 'SignatureValue';
    const SIGNATUREPROPERTIES    = 'SignatureProperties';
    const SIGNATUREPROPERTY      = 'SignatureProperty';
    const SIGNEDINFO             = 'SignedInfo';
    const SPKIDATA               = 'SPKIData';
    const SPKISEXP               = 'SPKISexp';
    const TRANSFORM              = 'Transform';
    const TRANSFORMS             = 'Transforms';
    const X509CERTIFICATE        = 'X509Certificate';
    const X509CRL                = 'X509CRL';
    const X509DATA               = 'X509Data';
    const X509ISSUERNAME         = 'X509IssuerName';
    const X509SERIALNUBER        = 'X509SerialNumber';
    const X509ISSUERSERIAL       = 'X509IssuerSerial';
    const X509SKI                = 'X509SKI';
    const X509SUBJECTNAME        = 'X509SubjectName';
    const XPATH                  = 'XPath';
    const Y                      = 'Y';

    /**
     * xmldsig attribute constants
     */
    const ALGORITM               = 'Algorithm';
    const ENCODING               = 'Encoding';
    const ID                     = 'Id';
    const MIMETYPE               = 'MimeType';
    const TARGET                 = 'Target';
    const TYPE                   = 'Type';
    const URI                    = 'URI';
}
