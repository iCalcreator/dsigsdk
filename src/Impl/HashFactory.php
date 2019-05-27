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
 *
 * Disclaimer of rights
 *           Herein may exist software logic (hereafter solution(s))
 *           found on internet (hereafter originator(s)).
 *           The rights of each solution belongs to respective originator;
 *
 *           Credits and acknowledgements to originators!
 *           Links to originators are found wherever appropriate.
 *
 *           Only DsigSdk copyright holder works, DsigSdk author(s) works and solutions derived works
 *           and collection of solutions are covered by GNU Lesser General Public License, above.
 */
namespace Kigkonsult\DsigSdk\Impl;

use InvalidArgumentException;

use function hash_equals;
use function hash;

/**
 * Class HashFactory
 */
class HashFactory extends ImplBase
{

    /**
     * List of PHP 7.0.25 registered hashing algorithms (using hash_algos) supporting PHP hash
     * Note, it may exist algorithms in NOT supported by PHP hash_hmac
     *
     * md2, md4, md5, sha1, sha224, sha256, sha384, sha512, ripemd128, ripemd160, ripemd256, ripemd320,
     * whirlpool, tiger128,3, tiger160,3, tiger192,3, tiger128,4, tiger160,4, tiger192,4,
     * snefru, snefru256, gost, gost-crypto, adler32, crc32, crc32b, fnv132, fnv1a32, fnv164, fnv1a64, joaat,
     * haval128,3, haval160,3, haval192,3, haval224,3, haval256,3, haval128,4, haval160,4, haval192,4,
     * haval224,4, haval256,4, haval128,5, haval160,5, haval192,5, haval224,5, haval256,5
     */

    /**
     * Assert algorithm
     *
     * @param string $algorithm
     * @throws InvalidArgumentException
     * @return string
     * @static
     */
    public static function assertAlgorithm( $algorithm ) {
        return parent::baseAssertAlgorithm( hash_algos(), strtolower( $algorithm ), true );
    }

    /**
     * Return a hash value (message digest), applied on (string) argument
     *
     * @see https://www.php.net/manual/en/function.hash.php
     * @param string $algorithm
     * @param string $data
     * @param bool   $rawOutput
     * @return string
     * @throws InvalidArgumentException
     * @static
     */
    public static function generate( $algorithm, $data, $rawOutput = false ) {
        $algorithm = self::assertAlgorithm( $algorithm );
        $data = CommonFactory::assertString( $data, 2 );
        return hash( $algorithm, $data, $rawOutput );
    }

    /**
     * Return a hash value using the contents of a given file
     *
     * @see https://www.php.net/manual/en/function.hash-file.php
     * @param string $algorithm
     * @param string $fileName   - URL describing location of file to be hashed; Supports fopen wrappers.
     * @param bool   $rawOutput
     * @return string
     * @throws InvalidArgumentException
     * @static
     */
    public static function generateFile( $algorithm, $fileName, $rawOutput = false ) {
        $algorithm = self::assertAlgorithm( $algorithm );
        CommonFactory::assertFileName( $fileName );
        return hash( $algorithm, $fileName, $rawOutput );
    }

    /**
     * Return bool true if hashes match
     *
     * @param string $expected
     * @param string $actual
     * @return bool
     * @static
     */
    public static function hashEquals( $expected, $actual ) {
        return hash_equals( $expected, $actual );
    }

}