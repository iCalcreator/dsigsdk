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

use function base64_decode;
use function base64_encode;
use function bin2hex;
use function ceil;
use function chr;
use function dechex;
use function hexdec;
use function is_string;
use function openssl_random_pseudo_bytes;
use function ord;
use function preg_match;
use function rtrim;
use function sprintf;
use function str_repeat;
use function strpos;
use function strlen;
use function strtr;
use function substr;

class CommonFactory extends ImplBase
{

    /** ***********************************************************************
     *  Asserts
     ** ******************************************************************** */

    /**
     * Assert data is a string (i.e. is a scalar) and return string
     *
     * @param mixed $data
     * @param int   $argIx
     * @throws InvalidArgumentException
     * @return string
     */
    public static function assertString( $data, $argIx = null ) {
        static $FMT1 = ' (argument #%d)';
        static $FMT2 = 'String expected%s, \'%s\' given.';
        if( ! is_scalar( $data )) {
            $argNoFmt = ( empty( $argIx )) ? null : sprintf( $FMT1, $argIx );
            throw new InvalidArgumentException( sprintf( $FMT2, $argNoFmt, gettype( $data )));
        }
        return (string) $data;
    }

    /**
     * Assert fileName is a readable file
     *
     * @param string $fileName
     * @throws InvalidArgumentException
     */
    public static function assertFileName( $fileName ) {
        static $FMT1 = '%s is no file';
        static $FMT2 = 'Can\'t read %s';
        self::assertString( $fileName );
        if( ! @is_file( $fileName )) {
            throw new InvalidArgumentException( sprintf( $FMT1, $fileName ));
        }
        if( ! @is_readable( $fileName )) {
            throw new InvalidArgumentException( sprintf( $FMT2, $fileName ));
        }
        clearstatcache( $fileName );
    }

    /**
     * Assert fileName is a writable file
     *
     * @param string $fileName
     * @throws InvalidArgumentException
     * @todo check path top level and down
     */
    public static function assertFileNameWrite( $fileName ) {
        static $FMT1 = '%s is invalid or not writeable';
        self::assertString( $fileName );
        $path = dirname( $fileName );
        if( ! @is_dir( $path ) || ! @is_writable( $path )) {
            throw new InvalidArgumentException( sprintf( $FMT1, $fileName ));
        }
        if( @is_file( $fileName ) && ! @is_writable( $path )) {
            throw new InvalidArgumentException( sprintf( $FMT1, $fileName ));
        }
        clearstatcache( $fileName );
    }

    /** ***********************************************************************
     *  Misc
     ** ******************************************************************** */

    /**
     * Return cryptographically strong arg byteCnt bytes
     *
     * @param int $byteCnt
     * @param bool $cStrong
     * @return string
     * @static
     */
    public static function getRandomPseudoBytes( $byteCnt, & $cStrong = false ) {
        static $MAX = 10;
        $cnt = 0;
        do {
            $bytes = openssl_random_pseudo_bytes( $byteCnt, $cStrong );
            $cnt += 1;
        } while(( $MAX > $cnt ) && ( false === $cStrong ));
        return $bytes;
    }

    /**
     * Return (hex) cryptographically strong salt, default 64 bytes
     *
     * @param int $byteCnt
     * @return string
     * @static
     */
    public static function getSalt( $byteCnt = null ) {
        if( empty( $byteCnt )) {
            $byteCnt = 64;
        }
        $byteCnt2 = (int) floor( $byteCnt / 2 );
        return bin2hex( self::getRandomPseudoBytes( $byteCnt2 ));
    }

    /**
     * Return algorithm from (URI) identifier
     *
     * @param string $identifier
     * @return string
     * @throws InvalidArgumentException
     * @static
     */
    public static function getAlgorithmFromIdentifier( $identifier ) {
        static $HASH  = '#';
        static $SLASH = '/';
        static $FMT   = 'Algorithm not found in \'%s\'';
        if( $SLASH == substr( $identifier, -1 )) {
            $identifier = substr( $identifier, 0, -1 );
        }
        if( false !== ( $pos = strpos( $identifier, $HASH ))) {
            return substr( $identifier, ( $pos + 1 ));
        }
        if( false !== ( $pos = strrpos( $identifier, $SLASH ))) {
            return substr( $identifier, ( $pos + 1 ));
        }
        throw new InvalidArgumentException( sprintf( $FMT, $identifier ));
    }

    /** ***********************************************************************
     *  Base64
     ** ******************************************************************** */

    /**
     * Return base64 encoded string
     *
     * @param string $raw
     * @return string
     * @static
     */
    public static function base64Encode( $raw ) {
        $data = self::assertString( $raw );
        return base64_encode( $data );
    }

    /**
     * Return base64 decoded string
     * @param string $encoded
     * @return string
     * @static
     * @see https://www.php.net/manual/en/function.base64-decode.php#92980
     */
    public static function base64Decode( $encoded ) {
        $decoded      = '';
        $chunksLength = ceil( strlen( $encoded ) / self::$DIVISOR );
        for( $i = 0; $i < $chunksLength; $i++ ) {
            $decoded .= base64_decode( substr( $encoded, ( $i * self::$DIVISOR ), self::$DIVISOR ));
        }
        return $decoded;
    }

    /**
     * @var int
     *         sufficiently small modulo 4 natural
     * @static
     */
    private static $DIVISOR = 256;

    /**
     * @var string
     * @static
     */
    private static $PS = '+/';
    private static $MU = '-_';
    private static $EQ = '=';

    /**
     * Return base64url encoded string
     *
     * @param string $raw
     * @return string
     * @static
     * @see https://www.php.net/manual/en/function.base64-encode.php#121767
     */
    public static function base64UrlEncode( $raw ) {
        $data = self::assertString( $raw );
        return rtrim( strtr( base64_encode( $data ), self::$PS, self::$MU ), self::$EQ );
    }

    /**
     * Return base64url decoded string
     *
     * @param string $encoded
     * @return string
     * @static
     * @see https://www.php.net/manual/en/function.base64-encode.php#121767
     */
    public static function base64UrlDecode( $encoded ) {
        $multiplier = 3 - ( 3 + strlen( $encoded )) % 4;
        return base64_decode(strtr( $encoded, self::$MU, self::$PS ) . str_repeat( self::$EQ, $multiplier ));
    }

    /** ***********************************************************************
     *  isHex, String to hex and hex to string
     ** ******************************************************************** */

    /**
     * Return bool true if string is in hex
     *
     * @param string $string
     * @return bool
     * @see https://stackoverflow.com/questions/2643157/php-simple-validate-if-string-is-hex
     */
    public static function isHex( $string ) {
        static $PATTERN = "/^[a-f0-9]{2,}$/i";
        return ( is_string( $string ) &&
            ( 1 == @preg_match( $PATTERN, $string )) &&
            ! ( strlen( $string ) & 1 )
        );
    }

    /**
     * Return hex converted from string
     *
     * @param string $string
     * @return string
     * @static
     * @see https://stackoverflow.com/questions/14674834/php-convert-string-to-hex-and-hex-to-string
     */
    public static function strToHex( $string ) {
        static $ZERO = '0';
        $string = (string) $string;
        $strlen = strlen( $string );
        $hex    = '';
        for( $i = 0; $i < $strlen; $i++ ){
            $ord     = ord( $string[$i] );
            $hexCode = dechex( $ord );
            $hex    .= substr($ZERO . $hexCode, -2 );
        }
        return strToUpper( $hex );
    }

    /**
     * Return string converted from hex
     *
     * @param string $hex
     * @return string
     * @static
     * @see https://stackoverflow.com/questions/14674834/php-convert-string-to-hex-and-hex-to-string
     */
    public static function hexToStr( $hex ){
        $strlen = strlen( $hex ) -1;
        $string = '';
        for( $i = 0; $i < $strlen; $i += 2 ) {
            $string .= chr( hexdec($hex[$i] . $hex[$i+1] ));
        }
        return $string;
    }

    /** ***********************************************************************
     *  'H*' - pach/unpack (hex) data
     ** ******************************************************************** */

    /**
     * @var string
     * @static
     */
    private static $HAST = 'H*';

    /**
     * Return binary string from a 'H*' packed hexadecimally encoded (binary) string
     *
     * @param mixed $input
     * @return string
     * @static
     * @see https://www.php.net/manual/en/function.pack.php
     */
    public static function Hpach( $input ) {
        return pack( self::$HAST, $input );
    }

    /**
     * Return (mixed) data from a 'H*' unpacked binary string
     *
     * @param string $binaryData
     * @return mixed
     * @static
     * @see https://www.php.net/manual/en/function.unpack.php
     */
    public static function HunPach( $binaryData ) {
        return unpack( self::$HAST, $binaryData )[1];
    }
}