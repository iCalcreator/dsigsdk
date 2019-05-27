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
use function hash_hmac;
use function hash_hmac_algos;
use function hexdec;
use function intval;
use function pack;
use function pow;
use function str_pad;
use function strlen;
use function strtolower;
use function substr;
use function time;

/**
 * Class HmacHashFactory
 */
class HmacHashFactory extends ImplBase
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
     * Dsig supported HMAC algorithms
     */
    const MD5       = 'md5';
    const SHA224    = 'sha224';
    const SHA256    = 'sha256';
    const SHA384    = 'sha384';
    const SHA512    = 'sha512';
    const RIPEMD160 = 'ripemd160';

    /**
     * Assert algorithm
     *
     * @param string $algorithm
     * @throws InvalidArgumentException
     * @return string
     * @static
     */
    public static function assertAlgorithm( $algorithm ) {
        static $HMACHASHALGOS = 'hash_hmac_algos';
        $algorithms = ( function_exists( $HMACHASHALGOS )) ? hash_hmac_algos() : hash_algos();
        return parent::baseAssertAlgorithm( $algorithms, strtolower( $algorithm ), true );
    }

    /**
     * Return a keyed hash value using the HMAC md5 method, applied on (string) argument
     *
     * A HmacHashFactory::genererate method alias using md5
     * @param string $data
     * @param string $secret
     * @param bool   $rawOutput
     * @return string
     * @static
     */
    public static function generateMd5( $data, $secret, $rawOutput = false ) {
        return self::generate( self::MD5, $data, $secret, $rawOutput );
    }

    /**
     * Return a keyed hash value using the HMAC sha224 method, applied on (string) argument
     *
     * A HmacHashFactory::genererate method alias using sha224
     *
     * @param string $data
     * @param string $secret
     * @param bool   $rawOutput
     * @return string
     * @static
     */
    public static function generateSha224( $data, $secret, $rawOutput = false ) {
        return self::generate( self::SHA224, $data, $secret, $rawOutput );
    }

    /**
     * Return a keyed hash value using the HMAC sha256 method, applied on (string) argument
     *
     * A HmacHashFactory::genererate method alias using sha256
     * @param string $data
     * @param string $secret
     * @param bool   $rawOutput
     * @return string
     * @static
     */
    public static function generateSha256( $data, $secret, $rawOutput = false ) {
        return self::generate( self::SHA256, $data, $secret, $rawOutput );
    }

    /**
     * Return a keyed hash value using the HMAC sha384 method, applied on (string) argument
     *
     * A HmacHashFactory::genererate method alias using sha384
     * @param string $data
     * @param string $secret
     * @param bool   $rawOutput
     * @return string
     * @static
     */
    public static function generateSha384( $data, $secret, $rawOutput = false ) {
        return self::generate( self::SHA384, $data, $secret, $rawOutput );
    }

    /**
     * Return a keyed hash value using the HMAC sha512 method, applied on (string) argument
     *
     * A HmacHashFactory::genererate method alias using sha512
     * @param string $data
     * @param string $secret
     * @param bool   $rawOutput
     * @return string
     * @static
     */
    public static function generateSha512( $data, $secret, $rawOutput = false ) {
        return self::generate( self::SHA512, $data, $secret, $rawOutput );
    }

    /**
     * Return a keyed hash value using the HMAC ripemd160 method, applied on (string) argument
     *
     * A HmacHashFactory::genererate method alias using ripemd160
     * @param string $data
     * @param string $secret
     * @param bool   $rawOutput
     * @return string
     * @static
     */
    public static function generateRipemd160( $data, $secret, $rawOutput = false ) {
        return self::generate( self::RIPEMD160, $data, $secret, $rawOutput );
    }

    /**
     * Return a keyed hash value using the HMAC method, applied on (string) argument
     *
     * @see https://www.php.net/manual/en/function.hash-hmac.php
     * @param string $algorithm
     * @param string $data
     * @param string $secret
     * @param bool   $rawOutput
     * @return string
     * @throws InvalidArgumentException
     * @static
     */
    public static function generate( $algorithm, $data, $secret, $rawOutput = false ) {
        $algorithm = self::assertAlgorithm( $algorithm );
        $data      = CommonFactory::assertString( $data, 2 );
        return hash_hmac( $algorithm, $data, $secret, $rawOutput );
    }


    /**
     * Return a keyed hash value using the HMAC md5 method, applied on contents of a given file
     *
     * A HmacHashFactory::genererateFile method alias using md5
     * @param string $fileName
     * @param string $secret
     * @param bool   $rawOutput
     * @return string
     * @static
     */
    public static function generateFileMd5( $fileName, $secret, $rawOutput = false ) {
        return self::generateFile( self::MD5, $fileName, $secret, $rawOutput );
    }

    /**
     * Return a keyed hash value using the HMAC sha224 method, applied on contents of a given file
     *
     * A HmacHashFactory::genererateFile method alias using sha224
     *
     * @param string $fileName
     * @param string $secret
     * @param bool   $rawOutput
     * @return string
     * @static
     */
    public static function generateFileSha224( $fileName, $secret, $rawOutput = false ) {
        return self::generateFile( self::SHA224, $fileName, $secret, $rawOutput );
    }

    /**
     * Return a keyed hash value using the HMAC sha256 method, applied on contents of a given file
     *
     * A HmacHashFactory::genererateFile method alias using sha256
     * @param string $fileName
     * @param string $secret
     * @param bool   $rawOutput
     * @return string
     * @static
     */
    public static function generateFileSha256( $fileName, $secret, $rawOutput = false ) {
        return self::generateFile( self::SHA256, $fileName, $secret, $rawOutput );
    }

    /**
     * Return a keyed hash value using the HMAC sha384 method, applied on contents of a given file
     *
     * A HmacHashFactory::genererateFile method alias using sha384
     * @param string $fileName
     * @param string $secret
     * @param bool   $rawOutput
     * @return string
     * @static
     */
    public static function generateFileSha384( $fileName, $secret, $rawOutput = false ) {
        return self::generateFile( self::SHA384, $fileName, $secret, $rawOutput );
    }

    /**
     * Return a keyed hash value using the HMAC sha512 method, applied on contents of a given file
     *
     * A HmacHashFactory::genererateFile method alias using sha512
     * @param string $fileName
     * @param string $secret
     * @param bool   $rawOutput
     * @return string
     * @static
     */
    public static function generateFileSha512( $fileName, $secret, $rawOutput = false ) {
        return self::generateFile( self::SHA512, $fileName, $secret, $rawOutput );
    }

    /**
     * Return a keyed hash value using the HMAC ripemd160 method, applied on contents of a given file
     *
     * A HmacHashFactory::genererateFile method alias using ripemd160
     * @param string $fileName
     * @param string $secret
     * @param bool   $rawOutput
     * @return string
     * @static
     */
    public static function generateFileRipemd160( $fileName, $secret, $rawOutput = false ) {
        return self::generateFile( self::RIPEMD160, $fileName, $secret, $rawOutput );
    }



    /**
     * Return a keyed hash value using the HMAC method, applied on contents of a given file
     *
     * @see https://www.php.net/manual/en/function.hash-hmac-file.php
     * @param string $algorithm
     * @param string $fileName   - URL describing location of file to be hashed; Supports fopen wrappers.
     * @param string $secret
     * @param bool   $rawOutput
     * @return string
     * @throws InvalidArgumentException
     * @static
     */
    public static function generateFile( $algorithm, $fileName, $secret, $rawOutput = false ) {
        $algorithm = self::assertAlgorithm( $algorithm );
        CommonFactory::assertFileName( $fileName );
        return hash_hmac( $algorithm, $fileName, $secret, $rawOutput );
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
        return hash_equals( (string) $expected, (string) $actual );
    }

    /**
     * Return HMAC-based One-Time Password (HOTP)
     *
     * @see  https://www.php.net/manual/en/function.hash-hmac.php#110288
     * This function implements the algorithm outlined in RFC 6238 for Time-Based One-Time Passwords
     * @link http://tools.ietf.org/html/rfc6238
     *
     * @param string $key        the string to use for the HMAC key
     * @param mixed  $time       a value that reflects a time (unixtime in the example)
     * @param int    $digits     the desired length of the OTP
     * @param string $algorithm
     * @return string the generated OTP
     * @throws InvalidArgumentException
     * @static
     */
    public static function oauth_totp( $key, $time = null, $digits = 8, $algorithm = null ) {
        static $NNCAST = 'NNC*';
        static $ZERO   = '0';
        if( empty( $time )) {
            $time = time();
        }
        $digits    = intval( $digits );
        if( empty( $algorithm )) {
            $algorithm = self::SHA256;
        }
        else {
            $algorithm = self::assertAlgorithm( $algorithm );
        }
        $result    = null;

        // Convert counter to binary (64-bit)
        $data = pack( $NNCAST, $time >> 32, $time & 0xFFFFFFFF );

        // Pad to 8 chars (if necessary)
        if( strlen( $data ) < 8 ) {
            $data = str_pad( $data, 8, chr(0 ), STR_PAD_LEFT );
        }

        // Get the hash
        $hash = hash_hmac( $algorithm, $data, $key );

        // Grab the offset
        $offset = 2 * hexdec( substr( $hash, strlen( $hash ) - 1, 1 ));

        // Grab the portion we're interested in
        $binary = hexdec( substr( $hash, $offset, 8 )) & 0x7fffffff;

        // Modulus
        $result = $binary % pow(10, $digits );

        // Pad (if necessary)
        $result = str_pad( $result, $digits, $ZERO, STR_PAD_LEFT );

        return $result;
    }
}