<?php
/**
 * DsigSdk   the PHP XML Digital Signature recomendation SDK, 
 *           source http://www.w3.org/2000/09/xmldsig#
 *
 * copyright (c) 2019 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * Link      https://kigkonsult.se
 * Package   DsigSdk
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
namespace Kigkonsult\DsigSdk\DsigLoader;

use Kigkonsult\DsigSdk\DsigInterface;

interface DsigLoaderInterface extends DsigInterface
{

    const ALGORITHMS = [
        self::MD5,
        self::SHA_224,
        self::SHA_384,
        self::HMAC_MD5,
        self::HMAC_SHA224,
        self::HMAC_SHA256,
        self::HMAC_SHA384,
        self::HMAC_SHA512,
        self::HMAC_RIPEMD160,
        self::RSA_MD5,
        self::RSA_SHA256,
        self::RSA_SHA384,
        self::RSA_SHA512,
        self::RSA_RIPEMD160,
        self::ECDSA_SHA1,
        self::ECDSA_SHA224,
        self::ECDSA_SHA256,
        self::ECDSA_SHA384,
        self::ECDSA_SHA512,
        self::ESIGN_SHA1,
        self::ESIGN_SHA224,
        self::ESIGN_SHA256,
        self::ESIGN_SHA384,
        self::ESIGN_SHA512,
        self::MINICANONICAL,
        self::XPOINTER,
        self::ARCFOUR,
        self::CAMELLIA128,
        self::CAMELLIA192,
        self::CAMELLIA256,
        self::KWCAMELLIA128,
        self::KWCAMELLIA192,
        self::KWCAMELLIA256,
        self::PSEC_KEM,
        self::PKCS7,
        self::RMKEYVALUE,
        self::RMRETRIEVALMETHOD,
        self::RMKENAME,
        self::RMRAWX509CRL,
        self::RMRAWPGPKEYPACKET,
        self::RMRAWSPKISEXP,
        self::RMPKCS7SIGNEDDATA,
        self::RMRAWPKCS7SIGNEDDATA,
    ];

}