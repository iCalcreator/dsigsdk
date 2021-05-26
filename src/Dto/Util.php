<?php
/**
 * DsigSdk   the PHP XML Digital Signature recommendation SDK,
 *           source http://www.w3.org/2000/09/xmldsig#
 *
 * This file is a part of DsigSdk.
 *
 * Copyright 2019 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * author    Kjell-Inge Gustafsson, kigkonsult
 * Link      https://kigkonsult.se
 * Package   DsigSdk
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
namespace Kigkonsult\DsigSdk\Dto;

use InvalidArgumentException;

use function bin2hex;
use function floor;
use function openssl_random_pseudo_bytes;
use function sprintf;
use function strpos;
use function strrpos;
use function substr;

/**
 * Class Util
 */
class Util
{
    /**
     * Return cryptographically strong arg byteCnt bytes - uses openssl_random_pseudo_bytes
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
     * Return (trailing)) algorithm from (URI) identifier
     *
     * @param string $identifier
     * @return string
     * @throws InvalidArgumentException
     * @static
     */
    public static function extractAlgorithmFromUriIdentifier( $identifier ) {
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

}