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
 * Interface DsigInterface
 */
interface DsigInterface
{

    /**
     * dsig element constants
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
    const OBJECT                 = 'Object';
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
     * dsig attribute constants
     */
    const ALGORITM               = 'Algorithm';
    const ENCODING               = 'Encoding';
    const ID                     = 'Id';
    const MIMETYPE               = 'MimeType';
    const TARGET                 = 'Target';
    const TYPE                   = 'Type';
    const URI                    = 'URI';


    /**
     * DstMethod Algorithms
     */
    const DSIGURI                = 'http://www.w3.org/2000/09/xmldsig#';
    
    /**
     * https://www.ietf.org/rfc/rfc4051.txt algorithms etc
     */

    /**
     * DigestMethod Algorithms
     */
    const MD5                    = 'http://www.w3.org/2001/04/xmldsig-more#md5';
    const SHA_224                = 'http://www.w3.org/2001/04/xmldsig-more#sha224';
    const SHA_384                = 'http://www.w3.org/2001/04/xmldsig-more#sha384';

    /**
     * SignatureMethod Message Authentication Code Algorithms
     */
    const HMAC_MD5               = 'http://www.w3.org/2001/04/xmldsig-more#hmac-md5';

    /**
     * HMAC SHA Variations
     */
    const HMAC_SHA224            = 'http://www.w3.org/2001/04/xmldsig-more#hmac-sha224';
    const HMAC_SHA256            = 'http://www.w3.org/2001/04/xmldsig-more#hmac-sha256';
    const HMAC_SHA384            = 'http://www.w3.org/2001/04/xmldsig-more#hmac-sha384';
    const HMAC_SHA512            = 'http://www.w3.org/2001/04/xmldsig-more#hmac-sha512';

    /**
     * HMAC-RIPEMD160
     */
    const HMAC_RIPEMD160         = 'http://www.w3.org/2001/04/xmldsig-more#hmac-ripemd160';

    /**
     * SignatureMethod Public Key Signature Algorithms
     */

    /**
     * RSA-MD5
     */
    const RSA_MD5                = 'http://www.w3.org/2001/04/xmldsig-more#rsa-md5';
    /**
     * RSA-SHA*
     */
    const RSA_SHA256             = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256';
    const RSA_SHA384             = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha384';
    const RSA_SHA512             = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha512';
    const RSA_RIPEMD160          = 'http://www.w3.org/2001/04/xmldsig-more/rsa-ripemd160';

    /**
     * ECDSA-SHA*
     */
    const ECDSA_SHA1             = 'http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha1';
    const ECDSA_SHA224           = 'http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha224';
    const ECDSA_SHA256           = 'http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha256';
    const ECDSA_SHA384           = 'http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha384';
    const ECDSA_SHA512           = 'http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha512';

    /**
     * ESIGN-SHA1
     */
    const ESIGN_SHA1             = 'http://www.w3.org/2001/04/xmldsig-more#esign-sha1';
    const ESIGN_SHA224           = 'http://www.w3.org/2001/04/xmldsig-more#esign-sha224';
    const ESIGN_SHA256           = 'http://www.w3.org/2001/04/xmldsig-more#esign-sha256';
    const ESIGN_SHA384           = 'http://www.w3.org/2001/04/xmldsig-more#esign-sha384';
    const ESIGN_SHA512           = 'http://www.w3.org/2001/04/xmldsig-more#esign-sha512';


    /**
     * Minimal Canonicalization
     */
    const MINICANONICAL          = 'http://www.w3.org/2000/09/xmldsig#minimal';


    /**
     * Transform Algorithms
     *
     * XPointer
     */
    const XPOINTER               = 'XPointer http://www.w3.org/2001/04/xmldsig-more/xptr';


    /**
     * EncryptionMethod Algorithms
     */

    /**
     * ARCFOUR Encryption Algorithm
     */
    const ARCFOUR                = 'http://www.w3.org/2001/04/xmldsig-more#arcfour';

    /**
     * Camellia Block Encryption
     */
    const CAMELLIA128            = 'http://www.w3.org/2001/04/xmldsig-more#camellia128-cbc';
    const CAMELLIA192            = 'http://www.w3.org/2001/04/xmldsig-more#camellia192-cbc';
    const CAMELLIA256            = 'http://www.w3.org/2001/04/xmldsig-more#camellia256-cbc';

    /**
     * Camellia Key Wrap
     */
    const KWCAMELLIA128          = 'http://www.w3.org/2001/04/xmldsig-more#kw-camellia128';
    const KWCAMELLIA192          = 'http://www.w3.org/2001/04/xmldsig-more#kw-camellia192';
    const KWCAMELLIA256          = 'http://www.w3.org/2001/04/xmldsig-more#kw-camellia256';

    /**
     * PSEC-KEM
     */
    const PSEC_KEM               = 'http://www.w3.org/2001/04/xmldsig-more#psec-kem';


    /**
     * KeyInfo
     */

    /**
     * PKCS #7 Bag of Certificates and CRLs
     */
    const PKCS7                  = 'http://www.w3.org/2001/04/xmldsig-more';


    /**
     * Additional RetrievalMethod Type Values
     */
    const RMKEYVALUE             = 'http://www.w3.org/2001/04/xmldsig-more#KeyValue';
    const RMRETRIEVALMETHOD      = 'http://www.w3.org/2001/04/xmldsig-more#RetrievalMethod';
    const RMKENAME               = 'http://www.w3.org/2001/04/xmldsig-more#KeyName';
    const RMRAWX509CRL           = 'http://www.w3.org/2001/04/xmldsig-more#rawX509CRL';
    const RMRAWPGPKEYPACKET      = 'http://www.w3.org/2001/04/xmldsig-more#rawPGPKeyPacket';
    const RMRAWSPKISEXP          = 'http://www.w3.org/2001/04/xmldsig-more#rawSPKISexp';
    const RMPKCS7SIGNEDDATA      = 'http://www.w3.org/2001/04/xmldsig-more#PKCS7signedData';
    const RMRAWPKCS7SIGNEDDATA   = 'http://www.w3.org/2001/04/xmldsig-more#rawPKCS7signedData';

}