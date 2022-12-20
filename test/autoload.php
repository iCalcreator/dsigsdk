<?php
/**
 * DsigSdk    the PHP XML Digital Signature recommendation SDK,
 *            source http://www.w3.org/2000/09/xmldsig#
 *
 * This file is a part of DsigSdk.
 *
 * @author    Kjell-Inge Gustafsson, kigkonsult <ical@kigkonsult.se>
 * @copyright 2019-2022 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
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
/**
 * Kigkonsult\DsigSdk test autoloader
 */
spl_autoload_register(
    function( $class ) {
        static $BS       = '\\';
        static $PATHSRC  = null;
        static $PATHTEST = null;
        static $PHP     = '.php';
        static $PREFIX   = 'Kigkonsult\\DsigSdk\\';
        static $SRC      = 'src';
        static $TEST     = 'test';
        if( empty( $PATHSRC )) {
            $PATHSRC  = dirname( __DIR__ ) . DIRECTORY_SEPARATOR . $SRC . DIRECTORY_SEPARATOR;
            $PATHTEST = dirname( __DIR__ ) . DIRECTORY_SEPARATOR . $TEST . DIRECTORY_SEPARATOR;
        }
        if ( 0 !== strncmp( $PREFIX, $class, 19 )) {
            return;
        }
        $class = substr( $class, 19 );
        if ( false !== strpos( $class, $BS )) {
            $class = str_replace( $BS, DIRECTORY_SEPARATOR, $class );
        }
        $file = $PATHSRC . $class . $PHP;
        if ( file_exists( $file )) {
            include $file;
        }
        else {
            $file = $PATHTEST . $class . $PHP;
            if( file_exists( $file ) ) {
                include $file;
            }
        }
    }
);