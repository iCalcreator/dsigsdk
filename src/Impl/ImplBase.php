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

use function clearstatcache;
use function gettype;
use function in_array;
use function is_file;
use function is_readable;
use function is_scalar;
use function sprintf;


abstract class ImplBase
{

    /**
     * @var string
     */
    protected static $FMT1 = 'Algorithm %s is not found';

    /**
     * Assert algorithm - matched returned
     *
     * @param array  $algorithms
     * @param string $algorithm
     * @param bool   $strict     -  if false : anycase search
     * @throws InvalidArgumentException
     * @return string  - found algorithm
     * @access protected
     * @static
     */
    protected static function baseAssertAlgorithm( array $algorithms, $algorithm, $strict = false ) {
        if( in_array( $algorithm, $algorithms, true )) {
            return $algorithm;
        }
        if( ! $strict ) {
            foreach( $algorithms as $supported ) {
                if( 0 == strcasecmp( $algorithm, $supported )) {
                    return $supported;
                }
            }
        }
        throw new InvalidArgumentException( sprintf( self::$FMT1, $algorithm ));
    }

    /**
     * @var callable
     */
    protected static $ERRORHANDLER = [ ImplBase::class, 'PhpErrors2Exception' ];

    /**
     * Throw PHP errors as PhpErrorException
     *
     * @param int    $errno
     * @param string $errstr
     * @param string $errfile
     * @param int    $errline
     * @throws PhpErrorException
     * @access protected
     * @static
     */
    protected static function PhpErrors2Exception( $errno, $errstr, $errfile, $errline ) {
        static $csp = ', ';
        $message = PhpErrorException::getSeverityText( $errno ) . $csp . $errstr;
        throw new PhpErrorException( $message, 500, $errno, $errfile, $errline );
    }

}