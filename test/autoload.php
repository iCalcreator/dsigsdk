<?php
/**
 * DsigSdk   the PHP XML Digital Signature recomendation SDK,
 *           source http://www.w3.org/2000/09/xmldsig#
 *
 * copyright (c) 2019 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * Link      https://kigkonsult.se
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
/**
 * Kigkonsult\DsigSdk test autoloader
 */
spl_autoload_register(
    function( $class ) {
        static $PREFIX   = 'Kigkonsult\\DsigSdk\\';
        static $BS       = '\\';
        static $DD       = '..';
        static $PATHSRC  = null;
        static $SRC      = 'src';
        static $PATHTEST = null;
        static $TEST     = 'test';
        static $FMT      = '%1$s%2$s.php';
        if( empty( $PATHSRC )) {
            $PATHSRC  =
                realpath(__DIR__ . DIRECTORY_SEPARATOR . $DD . DIRECTORY_SEPARATOR . $SRC ) . DIRECTORY_SEPARATOR;
            $PATHTEST =
                realpath(__DIR__ . DIRECTORY_SEPARATOR . $DD . DIRECTORY_SEPARATOR . $TEST ) . DIRECTORY_SEPARATOR;
        }
        if ( 0 != strncmp( $PREFIX, $class, 19 )) {
            return;
        }
        $class = substr( $class, 19 );
        if ( false !== strpos( $class, $BS )) {
            $class = str_replace( $BS, DIRECTORY_SEPARATOR, $class );
        }
        $file = sprintf( $FMT, $PATHSRC, $class );
        if ( file_exists( $file )) {
            include $file;
        }
        else {
            $file = sprintf( $FMT, $PATHTEST, $class );
            if( file_exists( $file ) ) {
                include $file;
            }
        }
    }
);