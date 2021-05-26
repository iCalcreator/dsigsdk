<?php
/**
 * DsigSdk   the PHP XML Digital Signature recomendation SDK,
 *           source http://www.w3.org/2000/09/xmldsig#
 *
 * This file is a part of DsigSdk.
 *
 * Copyright 2021 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * author    Kjell-Inge Gustafsson, kigkonsult
 * Link      https://kigkonsult.se
 * Version   0.974
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
namespace Kigkonsult\DsigSdk\DsigLoader;

class CommonFactory
{
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
     * Used by test/DtoLoader
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
}
