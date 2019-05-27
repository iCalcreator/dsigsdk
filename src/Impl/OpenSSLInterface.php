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
 * Version   0.965
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
namespace Kigkonsult\DsigSdk\Impl;

/**
 * Interface OpenSSLInterface
 */
interface OpenSSLInterface
{

    /**
     * key configargs
     *
     * @see https://www.php.net/manual/en/function.openssl-csr-new.php
     *
     *                                               Configuration overrides
     * configargs key      type     openssl.conf     description
     *                              equivalent
     * digest_alg          string   default_md       Digest method or signature hash, usually one of openssl_get_md_methods()
     * x509_extensions     string   x509_extensions  Selects which extensions should be used when creating an x509 certificate
     * req_extensions      string   req_extensions   Selects which extensions should be used when creating a CSR
     * private_key_bits    integer  default_bits     Specifies how many bits should be used to generate a private key
     * private_key_type    integer  none             Specifies the type of private key to create.
     *                                                 https://www.php.net/manual/en/openssl.key-types.php
     *                                               This can be one of
     *                                                 OPENSSL_KEYTYPE_DSA,
     *                                                 OPENSSL_KEYTYPE_DH,
     *                                                 OPENSSL_KEYTYPE_RSA
     *                                                 OPENSSL_KEYTYPE_EC.
     *                                               The default value is OPENSSL_KEYTYPE_RSA.
     * encrypt_key         boolean  encrypt_key      Should an exported key (with passphrase) be encrypted?
     * encrypt_key_cipher  integer  none             One of cipher constants.
     *                                                 https://www.php.net/manual/en/openssl.ciphers.php
     *                                                 OPENSSL_CIPHER_RC2_40
     *                                                 OPENSSL_CIPHER_RC2_128
     *                                                 OPENSSL_CIPHER_RC2_64
     *                                                 OPENSSL_CIPHER_DES
     *                                                 OPENSSL_CIPHER_3DES
     *                                                 OPENSSL_CIPHER_AES_128_CBC
     *                                                 OPENSSL_CIPHER_AES_192_CBC
     *                                                 OPENSSL_CIPHER_AES_256_CBC 
     * curve_name          string 	none             One of openssl_get_curve_names(). (PHP >= 7.1.0)
     * config              string   N/A              Path to your own alternative openssl.conf file.
     */

    const DIGESTALGO       = 'digest_alg';
    const X509EXTENSIONS   = 'x509_extensions';
    const REQEXTENSIONS    = 'req_extensions';
    const PRIVATEKEYBITS   = 'private_key_bits';
    const PRIVATEKEYTYPE   = 'private_key_type';
    const EXCRYPTKEY       = 'encrypt_key';
    const ENCRYPTKEYCIPHER = 'encrypt_key_cipher';
    const CURVENAME        = 'curve_name';
    const CONFIG           = 'config';

    /**
     * openssl_pkey_get_details keys
     *
     * @see https://www.php.net/manual/en/function.openssl-pkey-get-details.php
     */

    const BITS = 'bits';
    const KEY  = 'key';
    const TYPE = 'type';
    /**
     * One of
     * OPENSSL_KEYTYPE_RSA, OPENSSL_KEYTYPE_DSA, OPENSSL_KEYTYPE_DH, OPENSSL_KEYTYPE_EC or -1 meaning unknown
     */

    /**
     * For OPENSSL_KEYTYPE_RSA, RSA key subarray keys
     */
    const RSA       = 'rsa';
    const N         = 'n'; 	        // modulus
    const E         = 'e'; 	        // public exponent
    const D         = 'd'; 	        // private exponent
    const P         = 'p';          // prime 1
    const Q         = 'q';          // prime 2
    const DMP1      = 'dmp1';       // exponent1, d mod (p-1)
    const DMQ1      = 'dmq1';       // exponent2, d mod (q-1)
    const IQMP      = 'iqmp';       // coefficient, (inverse of q) mod p

    /**
     * For OPENSSL_KEYTYPE_DSA, DSA key subarray keys
     */
    const DSA       = 'dsa';
//  const P         = 'p';          // prime number (public)
//  const Q         = "q"           // 160-bit subprime, q | p-1 (public)
    const G         = 'g';          // generator of subgroup (public)
    const PRIVKEY   = 'priv_key';   // private key x
    const PUBKEY    = 'pub_key';    // public key y = g^x

    /**
     * For OPENSSL_KEYTYPE_DH, DH key subarray keys
     */
    const DH        = 'DH';
//  const P         = 'p';          // prime number (shared)
//  const G         = 'g';          // generator of Z_p (shared)
//  const PRIVKEY   = 'priv_key';   // private DH value x
//  const PUBKEY    = 'pub_key';    // public DH value g^x

    /**
     * For OPENSSL_KEYTYPE_EC, EC key subarray keys
     */
    const EC        = 'ec';
//  const CURVENAME = 'curve_name'; // name of curve, see openssl_get_curve_names() (PHP >= 7.1.0)
    const CURVEOID  = 'curve_oid';  // ASN1 Object identifier (OID) for EC curve.
    const X         = 'x';          // x coordinate (public)
    const Y         = 'y';          // y coordinate (public)
//  const D         = 'd';          // private key


    /**
     * ca keys
     */
    const COUNTRYNAME          = 'countryName';
    const STATEORPROVINCENAME  = 'stateOrProvinceName';
    const ORGANIZATIONNAME     = 'organizationName';
    const ORGANIZATIONUNITNAME = 'organizationalUnitName';
    const COMMONNAME           = 'commonName';
    const EMAILADDRESS         = 'emailAddress';
    const LOCALITYNAME         = 'localityName';

}