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
namespace Kigkonsult\DsigSdk;


/**
 * Interface DsigInterface
 */
interface DsigInterface
{
    /**
     * xmldsig element constants
     */
    public const ANY                    = 'Any';
    public const ANYTYPE                = 'AnyType';
    public const CANONICALIZATIONMETHOD = 'CanonicalizationMethod';
    public const DSAKEYVALUE            = 'DSAKeyValue';
    public const EXPONENT               = 'Exponent';
    public const DIGESTMETHOD           = 'DigestMethod';
    public const DIGESTVALUE            = 'DigestValue';
    public const G                      = 'G';
    public const HMACOUTPUTLENGTH       = 'HMACOutputLength';
    public const J                      = 'J';
    public const KEYINFO                = 'KeyInfo';
    public const KEYNAME                = 'KeyName';
    public const KEYVALUE               = 'KeyValue';
    public const MANIFEST               = 'Manifest';
    public const MGMTDATA               = 'MgmtData';
    public const MODULUS                = 'Modulus';
    public const OBJECT                 = 'Objekt';
    public const P                      = 'P';
    public const PGENCOUNTER            = 'PgenCounter';
    public const PGPDATA                = 'PGPData';
    public const PGPKEYID               = 'PGPKeyID';
    public const PGPKEYPACKET           = 'PGPKeyPacket';
    public const Q                      = 'Q';
    public const REFERENS               = 'Reference';
    public const RETRIEVALMETHOD        = 'RetrievalMethod';
    public const RSAKEYVALUE            = 'RSAKeyValue';
    public const SEED                   = 'Seed';
    public const SIGNATURE              = 'Signature';
    public const SIGNATUREMETHOD        = 'SignatureMethod';
    public const SIGNATUREVALUE         = 'SignatureValue';
    public const SIGNATUREPROPERTIES    = 'SignatureProperties';
    public const SIGNATUREPROPERTY      = 'SignatureProperty';
    public const SIGNEDINFO             = 'SignedInfo';
    public const SPKIDATA               = 'SPKIData';
    public const SPKISEXP               = 'SPKISexp';
    public const TRANSFORM              = 'Transform';
    public const TRANSFORMS             = 'Transforms';
    public const X509CERTIFICATE        = 'X509Certificate';
    public const X509CRL                = 'X509CRL';
    public const X509DATA               = 'X509Data';
    public const X509ISSUERNAME         = 'X509IssuerName';
    public const X509SERIALNUBER        = 'X509SerialNumber';
    public const X509ISSUERSERIAL       = 'X509IssuerSerial';
    public const X509SKI                = 'X509SKI';
    public const X509SUBJECTNAME        = 'X509SubjectName';
    public const XPATH                  = 'XPath';
    public const Y                      = 'Y';

    /**
     * xmldsig attribute constants
     */
    public const ALGORITM               = 'Algorithm';
    public const ENCODING               = 'Encoding';
    public const ID                     = 'Id';
    public const MIMETYPE               = 'MimeType';
    public const TARGET                 = 'Target';
    public const TYPE                   = 'Type';
    public const URI                    = 'URI';
}
