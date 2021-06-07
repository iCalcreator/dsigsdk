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
namespace Kigkonsult\DsigSdk\DsigLoader;

use Kigkonsult\DsigSdk\DsigIdentifiersInterface;
use Kigkonsult\DsigSdk\DsigInterface;

interface DsigLoaderInterface extends DsigInterface, DsigIdentifiersInterface
{
    const ALGORITHMS = [
        self::ALGO_ID_MD5,
        self::ALGO_ID_SHA_224,
        self::ALGO_ID_SHA_384,
        self::ALGO_ID_DSA_SHA1,
        self::ALGO_ID_DSA_SHA256,
        self::ALGO_ID_HMAC_MD5,
        self::ALGO_ID_HMAC_SHA1,
        self::ALGO_ID_HMAC_SHA224,
        self::ALGO_ID_HMAC_SHA256,
        self::ALGO_ID_HMAC_SHA384,
        self::ALGO_ID_HMAC_SHA512,
        self::ALGO_ID_HMAC_RIPEMD160,
        self::ALGO_ID_RSA_MD5,
        self::ALGO_ID_RSA_SHA1,
        self::ALGO_ID_RSA_SHA224,
        self::ALGO_ID_RSA_SHA256,
        self::ALGO_ID_RSA_SHA384,
        self::ALGO_ID_RSA_SHA512,
        self::ALGO_ID_RSA_RIPEMD160,
        self::ALGO_ID_ECDSA_SHA1,
        self::ALGO_ID_ECDSA_SHA224,
        self::ALGO_ID_ECDSA_SHA256,
        self::ALGO_ID_ECDSA_SHA384,
        self::ALGO_ID_ECDSA_SHA512,
        self::ALGO_ID_ESIGN_SHA1,
        self::ALGO_ID_ESIGN_SHA224,
        self::ALGO_ID_ESIGN_SHA256,
        self::ALGO_ID_ESIGN_SHA384,
        self::ALGO_ID_ESIGN_SHA512,
        self::ALGO_ID_CANONICAL,
        self::ALGO_ID_CANONICALCMT,
        self::ALGO_ID_CANONICAL11,
        self::ALGO_ID_CANONICAL11CMT,
        self::ALGO_ID_CANONICALEXCL,
        self::ALGO_ID_CANONICALEXCLCMT,
        self::ALGO_ID_CANONICALW3C11,
        self::ALGO_ID_CANONICALW3CEXCL,
        self::ALGO_ID_MINICANONICAL,
        self::ALGO_ID_BASE64,
        self::ALGO_ID_XPATH,
        self::ALGO_ID_ENVSIGN,
        self::ALGO_ID_XSLT,
        self::ALGO_ID_XPOINTER,
        self::ALGO_ID_ARCFOUR,
        self::ALGO_ID_CAMELLIA128,
        self::ALGO_ID_CAMELLIA192,
        self::ALGO_ID_CAMELLIA256,
        self::ALGO_ID_KWCAMELLIA128,
        self::ALGO_ID_KWCAMELLIA192,
        self::ALGO_ID_KWCAMELLIA256,
        self::ALGO_ID_PSEC_KEM,
        self::ALGO_ID_PKCS7,
        self::ALGO_ID_RMKEYVALUE,
        self::ALGO_ID_RMRETRIEVALMETHOD,
        self::ALGO_ID_RMKENAME,
        self::ALGO_ID_RMRAWX509CRL,
        self::ALGO_ID_RMRAWPGPKEYPACKET,
        self::ALGO_ID_RMRAWSPKISEXP,
        self::ALGO_ID_RMPKCS7SIGNEDDATA,
        self::ALGO_ID_RMRAWPKCS7SIGNEDDATA,
    ];
}
