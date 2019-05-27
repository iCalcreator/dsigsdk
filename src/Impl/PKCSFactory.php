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

use function intval;
use function sprintf;

/**
 * Class PKCSFactory
 *
 * @see     https://en.wikipedia.org/wiki/PKCS
 * @see     https://tools.ietf.org/html/rfc2315
 * @todo
 */
class PKCSFactory extends ImplBase
{

    /**
     * Return a (PKCS #5) PBKDF2 key derivation of a supplied password
     *
     * @see https://www.php.net/manual/en/function.hash-pbkdf2.php
     *
     * @param string $algorithm  - Name of selected hashing algorithm, recommended: SHA256
     * @param string $password   - The password to use for the derivation.
     * @param string $salt       - The salt to use for the derivation. This value should be generated randomly.
     * @param int $iterations    - The number of internal iterations to perform for the derivation,
     *                             recommended: At least 1024.
     * @param int    $keyLength  - The length of the output string.
     *                             If raw_output is TRUE this corresponds to the byte-length of the derived key,
     *                             if raw_output is FALSE this corresponds to twice the byte-length of the derived key
     *                             (as every byte of the key is returned as two hexits).
     *                             If 0 is passed, the entire output of the supplied algorithm is used.
     * @param bool   $rawOutput  - When set to TRUE, outputs raw binary data. FALSE outputs lowercase hexits.
     * @return string             A $keyLength-byte key derived from the password and salt.
     * @throws InvalidArgumentException
     */
    public static function pbkdf2(
        $algorithm,
        $password,
        $salt,
        $iterations = 1024,
        $keyLength  = 0,
        $rawOutput  = false
    ) {
        static $FMT        = 'PBKDF2 ERROR: Invalid parameter \'%s\'';
        static $ITERATIONS = 'iterations';
        static $KEYLENGTH  = 'keyLength';
        $algorithm  = HashFactory::assertAlgorithm( $algorithm );
        $iterations = intval( $iterations );
        if( 0 >= $iterations ) {
            throw new InvalidArgumentException( sprintf( $FMT, $ITERATIONS ));
        }
        $keyLength = intval( $keyLength );
        if( 0 > $keyLength ) {
            throw new InvalidArgumentException( sprintf( $FMT, $KEYLENGTH ));
        }
        return hash_pbkdf2( $algorithm, $password, $salt, $iterations, $keyLength, $rawOutput );
    }
}