<?php
/**
 * DsigSdk   the PHP XML Digital Signature recomendation SDK, 
 *           source http://www.w3.org/2000/09/xmldsig#
 *
 * This file is a part of DsigSdk.
 *
 * Copyright 2019 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * author    Kjell-Inge Gustafsson, kigkonsult
 * Link      https://kigkonsult.se
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
namespace Kigkonsult\DsigSdk;


/**
 * Interface DsigIdentifiersInterface
 */
interface DsigIdentifiersInterface
{
    /**
     * xmldsig uri
     */
    const DSIGURI                = 'http://www.w3.org/2000/09/xmldsig#';

    /**
     * https://www.ietf.org/rfc/rfc4051.txt algorithms etc
     * https://www.w3.org/TR/xmldsig-core   algorithms etc
     */

    /**
     * rfc4051 DigestMethod Algorithm identifiers
     */
    const MD5                    = 'http://www.w3.org/2001/04/xmldsig-more#md5';
    const SHA_224                = 'http://www.w3.org/2001/04/xmldsig-more#sha224';
    const SHA_384                = 'http://www.w3.org/2001/04/xmldsig-more#sha384';

    /**
     * xmldsig-core SignatureMethod identifiers
     */
    const HMAC_SHA1              = 'http://www.w3.org/2000/09/xmldsig#hmac-sha1';

    const DSA_SHA1               = 'http://www.w3.org/2000/09/xmldsig#dsa-sha1';
    const DSA_SHA256             = 'http://www.w3.org/2009/xmldsig11#dsa-sha256';

    const RSA_SHA1               = 'http://www.w3.org/2000/09/xmldsig#rsa-sha1';
    const RSA_SHA224             = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha224';

    /**
     * rfc4051 SignatureMethod Message Authentication Code Algorithm identifiers
     */
    const HMAC_MD5               = 'http://www.w3.org/2001/04/xmldsig-more#hmac-md5';
    const HMAC_SHA224            = 'http://www.w3.org/2001/04/xmldsig-more#hmac-sha224';
    const HMAC_SHA256            = 'http://www.w3.org/2001/04/xmldsig-more#hmac-sha256';
    const HMAC_SHA384            = 'http://www.w3.org/2001/04/xmldsig-more#hmac-sha384';
    const HMAC_SHA512            = 'http://www.w3.org/2001/04/xmldsig-more#hmac-sha512';
    const HMAC_RIPEMD160         = 'http://www.w3.org/2001/04/xmldsig-more#hmac-ripemd160';

    /**
     * rfc4051 SignatureMethod Public Key Signature Algorithm identifiers
     */
    const RSA_MD5                = 'http://www.w3.org/2001/04/xmldsig-more#rsa-md5';
    const RSA_SHA256             = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256';
    const RSA_SHA384             = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha384';
    const RSA_SHA512             = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha512';
    const RSA_RIPEMD160          = 'http://www.w3.org/2001/04/xmldsig-more/rsa-ripemd160';
    const ECDSA_SHA1             = 'http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha1';
    const ECDSA_SHA224           = 'http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha224';
    const ECDSA_SHA256           = 'http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha256';
    const ECDSA_SHA384           = 'http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha384';
    const ECDSA_SHA512           = 'http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha512';
    const ESIGN_SHA1             = 'http://www.w3.org/2001/04/xmldsig-more#esign-sha1';
    const ESIGN_SHA224           = 'http://www.w3.org/2001/04/xmldsig-more#esign-sha224';
    const ESIGN_SHA256           = 'http://www.w3.org/2001/04/xmldsig-more#esign-sha256';
    const ESIGN_SHA384           = 'http://www.w3.org/2001/04/xmldsig-more#esign-sha384';
    const ESIGN_SHA512           = 'http://www.w3.org/2001/04/xmldsig-more#esign-sha512';


    /**
     * rfc4051 Minimal Canonicalization identifier
     */
    const MINICANONICAL          = 'http://www.w3.org/2000/09/xmldsig#minimal';
    /* W3C identifiers */
    const CANONICAL              = 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315';      // 1.0
    const CANONICAL11            = 'http://www.w3.org/TR/2008/REC-xml-c14n11-20080502/';   // 1.1
    const CANONICALEXCL          = 'http://www.w3.org/TR/2002/REC-xml-exc-c14n-20020718/'; // Exclusive 1.0


    /**
     * rfc4051 Transform Algorithm identifiers
     * 'Note that all CanonicalizationMethod algorithms can also be used as transform algorithms.'
     *
     * XPointer
     */
    const XPOINTER               = 'http://www.w3.org/2001/04/xmldsig-more/xptr';


    /**
     * rfc4051 EncryptionMethod Algorithm identifiers
     */
    const ARCFOUR                = 'http://www.w3.org/2001/04/xmldsig-more#arcfour';
    /*  Camellia Block Encryption */
    const CAMELLIA128            = 'http://www.w3.org/2001/04/xmldsig-more#camellia128-cbc';
    const CAMELLIA192            = 'http://www.w3.org/2001/04/xmldsig-more#camellia192-cbc';
    const CAMELLIA256            = 'http://www.w3.org/2001/04/xmldsig-more#camellia256-cbc';
    /* Camellia Key Wrap */
    const KWCAMELLIA128          = 'http://www.w3.org/2001/04/xmldsig-more#kw-camellia128';
    const KWCAMELLIA192          = 'http://www.w3.org/2001/04/xmldsig-more#kw-camellia192';
    const KWCAMELLIA256          = 'http://www.w3.org/2001/04/xmldsig-more#kw-camellia256';

    const PSEC_KEM               = 'http://www.w3.org/2001/04/xmldsig-more#psec-kem';


    /**
     * rfc4051 KeyInfo Algorithm identifiers for PKCS #7 Bag of Certificates and CRLs
     */
    const PKCS7                  = 'http://www.w3.org/2001/04/xmldsig-more';

    /**
     * rfc4051 KeyInfo Algorithm identifiers for Additional RetrievalMethod Type Values
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