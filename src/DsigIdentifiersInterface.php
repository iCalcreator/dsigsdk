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
 * Interface DsigIdentifiersInterface
 */
interface DsigIdentifiersInterface
{
    /**
     * https://www.ietf.org/rfc/rfc4051.txt algorithms etc
     * https://www.w3.org/TR/xmldsig-core   algorithms etc
     */

    /**
     * rfc4051 DigestMethod Algorithm identifiers
     */
    public const ALGO_ID_MD5                    = 'http://www.w3.org/2001/04/xmldsig-more#md5';
    public const ALGO_ID_SHA_224                = 'http://www.w3.org/2001/04/xmldsig-more#sha224';
    public const ALGO_ID_SHA_384                = 'http://www.w3.org/2001/04/xmldsig-more#sha384';

    /**
     * xmldsig-core SignatureMethod identifiers
     */
    public const ALGO_ID_HMAC_SHA1              = 'http://www.w3.org/2000/09/xmldsig#hmac-sha1';

    public const ALGO_ID_DSA_SHA1               = 'http://www.w3.org/2000/09/xmldsig#dsa-sha1';
    public const ALGO_ID_DSA_SHA256             = 'http://www.w3.org/2009/xmldsig11#dsa-sha256';

    public const ALGO_ID_RSA_SHA1               = 'http://www.w3.org/2000/09/xmldsig#rsa-sha1';
    public const ALGO_ID_RSA_SHA224             = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha224';

    /**
     * rfc4051 SignatureMethod Message Authentication Code Algorithm identifiers
     */
    public const ALGO_ID_HMAC_MD5               = 'http://www.w3.org/2001/04/xmldsig-more#hmac-md5';
    public const ALGO_ID_HMAC_SHA224            = 'http://www.w3.org/2001/04/xmldsig-more#hmac-sha224';
    public const ALGO_ID_HMAC_SHA256            = 'http://www.w3.org/2001/04/xmldsig-more#hmac-sha256';
    public const ALGO_ID_HMAC_SHA384            = 'http://www.w3.org/2001/04/xmldsig-more#hmac-sha384';
    public const ALGO_ID_HMAC_SHA512            = 'http://www.w3.org/2001/04/xmldsig-more#hmac-sha512';
    public const ALGO_ID_HMAC_RIPEMD160         = 'http://www.w3.org/2001/04/xmldsig-more#hmac-ripemd160';

    /**
     * rfc4051 SignatureMethod Public Key Signature Algorithm identifiers
     */
    public const ALGO_ID_RSA_MD5                = 'http://www.w3.org/2001/04/xmldsig-more#rsa-md5';
    public const ALGO_ID_RSA_SHA256             = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256';
    public const ALGO_ID_RSA_SHA384             = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha384';
    public const ALGO_ID_RSA_SHA512             = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha512';
    public const ALGO_ID_RSA_RIPEMD160          = 'http://www.w3.org/2001/04/xmldsig-more/rsa-ripemd160';
    public const ALGO_ID_ECDSA_SHA1             = 'http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha1';
    public const ALGO_ID_ECDSA_SHA224           = 'http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha224';
    public const ALGO_ID_ECDSA_SHA256           = 'http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha256';
    public const ALGO_ID_ECDSA_SHA384           = 'http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha384';
    public const ALGO_ID_ECDSA_SHA512           = 'http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha512';
    public const ALGO_ID_ESIGN_SHA1             = 'http://www.w3.org/2001/04/xmldsig-more#esign-sha1';
    public const ALGO_ID_ESIGN_SHA224           = 'http://www.w3.org/2001/04/xmldsig-more#esign-sha224';
    public const ALGO_ID_ESIGN_SHA256           = 'http://www.w3.org/2001/04/xmldsig-more#esign-sha256';
    public const ALGO_ID_ESIGN_SHA384           = 'http://www.w3.org/2001/04/xmldsig-more#esign-sha384';
    public const ALGO_ID_ESIGN_SHA512           = 'http://www.w3.org/2001/04/xmldsig-more#esign-sha512';


    /**
     * xmldsig-core Transform Algorithms
     */
    public const ALGO_ID_CANONICAL              = 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315';              // 1.0
    public const ALGO_ID_CANONICALCMT           = 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315#WithComments'; // 1.0 with comments
    public const ALGO_ID_CANONICAL11            = 'http://www.w3.org/2006/12/xml-c14n11';                         // 1.1
    public const ALGO_ID_CANONICAL11CMT         = 'http://www.w3.org/2006/12/xml-c14n11#WithComments';            // 1.1 with comments
    public const ALGO_ID_CANONICALEXCL          = 'http://www.w3.org/2001/10/xml-exc-c14n#';                      // exclusive
    public const ALGO_ID_CANONICALEXCLCMT       = 'http://www.w3.org/2001/10/xml-exc-c14n#WithComments';          // "- , with comments

    /* W3C */
    public const ALGO_ID_CANONICALW3C11         = 'http://www.w3.org/TR/2008/REC-xml-c14n11-20080502/';   // 1.1
    public const ALGO_ID_CANONICALW3CEXCL       = 'http://www.w3.org/TR/2002/REC-xml-exc-c14n-20020718/'; // Exclusive 1.0


    /**
     * rfc4051 Minimal Canonicalization identifier
     */
    public const ALGO_ID_MINICANONICAL          = 'http://www.w3.org/2000/09/xmldsig#minimal';


    /**
     * xmldsig-core Transform Algorithms
     * 'Note that all CanonicalizationMethod algorithms can also be used as transform algorithms.'
     */
    public const ALGO_ID_BASE64                 = 'http://www.w3.org/2000/09/xmldsig#base64';
    public const ALGO_ID_XPATH                  = 'http://www.w3.org/TR/1999/REC-xpath-19991116';
    public const ALGO_ID_ENVSIGN                = 'http://www.w3.org/2000/09/xmldsig#enveloped-signature';
    public const ALGO_ID_XSLT                   = 'http://www.w3.org/TR/1999/REC-xslt-19991116';

    /**
     * rfc4051 Transform Algorithm identifiers
     *
     * XPointer
     */
    public const ALGO_ID_XPOINTER               = 'http://www.w3.org/2001/04/xmldsig-more/xptr';


    /**
     * rfc4051 EncryptionMethod Algorithm identifiers
     */
    public const ALGO_ID_ARCFOUR                = 'http://www.w3.org/2001/04/xmldsig-more#arcfour';
    /*  Camellia Block Encryption */
    public const ALGO_ID_CAMELLIA128            = 'http://www.w3.org/2001/04/xmldsig-more#camellia128-cbc';
    public const ALGO_ID_CAMELLIA192            = 'http://www.w3.org/2001/04/xmldsig-more#camellia192-cbc';
    public const ALGO_ID_CAMELLIA256            = 'http://www.w3.org/2001/04/xmldsig-more#camellia256-cbc';
    /* Camellia Key Wrap */
    public const ALGO_ID_KWCAMELLIA128          = 'http://www.w3.org/2001/04/xmldsig-more#kw-camellia128';
    public const ALGO_ID_KWCAMELLIA192          = 'http://www.w3.org/2001/04/xmldsig-more#kw-camellia192';
    public const ALGO_ID_KWCAMELLIA256          = 'http://www.w3.org/2001/04/xmldsig-more#kw-camellia256';

    public const ALGO_ID_PSEC_KEM               = 'http://www.w3.org/2001/04/xmldsig-more#psec-kem';


    /**
     * rfc4051 KeyInfo Algorithm identifiers for PKCS #7 Bag of Certificates and CRLs
     */
    public const ALGO_ID_PKCS7                  = 'http://www.w3.org/2001/04/xmldsig-more';

    /**
     * rfc4051 KeyInfo Algorithm identifiers for Additional RetrievalMethod Type Values
     */
    public const ALGO_ID_RMKEYVALUE             = 'http://www.w3.org/2001/04/xmldsig-more#KeyValue';
    public const ALGO_ID_RMRETRIEVALMETHOD      = 'http://www.w3.org/2001/04/xmldsig-more#RetrievalMethod';
    public const ALGO_ID_RMKENAME               = 'http://www.w3.org/2001/04/xmldsig-more#KeyName';
    public const ALGO_ID_RMRAWX509CRL           = 'http://www.w3.org/2001/04/xmldsig-more#rawX509CRL';
    public const ALGO_ID_RMRAWPGPKEYPACKET      = 'http://www.w3.org/2001/04/xmldsig-more#rawPGPKeyPacket';
    public const ALGO_ID_RMRAWSPKISEXP          = 'http://www.w3.org/2001/04/xmldsig-more#rawSPKISexp';
    public const ALGO_ID_RMPKCS7SIGNEDDATA      = 'http://www.w3.org/2001/04/xmldsig-more#PKCS7signedData';
    public const ALGO_ID_RMRAWPKCS7SIGNEDDATA   = 'http://www.w3.org/2001/04/xmldsig-more#rawPKCS7signedData';

}
