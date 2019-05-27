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
 */
namespace Kigkonsult\DsigSdk;

use Katzgrau\KLogger\Logger as KLogger;
use Kigkonsult\LoggerDepot\LoggerDepot;
use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;
use Psr\Log\NullLogger;

/**
 * Class BaseTest
 */
abstract class BaseTest extends TestCase
{

    /**
     * const int
     */
    const XMLReaderOptions = LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING | LIBXML_NSCLEAN | LIBXML_HTML_NODEFDTD;

    public static $SieXMLAttributes = [
        'xmlns:xsi'          => "http://www.w3.org/2001/XMLSchema-instance",
        'xmlns:xsd'          => "http://www.w3.org/2001/XMLSchema",
        'xsi:schemaLocation' => "http://www.sie.se/sie5 http://www.sie.se/sie5.xsd",
        'xmlns'              => "http://www.sie.se/sie5"
    ];

    public static $DsigXMLAttributes = [
        'xmlns' => "http://www.w3.org/2000/09/xmldsig#"
    ];

    public static function getCm( $name ) {
        return substr( $name, ( strrpos($name,  '\\' ) + 1 ));
    }

    public static function getRealPath() {
        return realpath( __DIR__ . DIRECTORY_SEPARATOR . '..' ) . DIRECTORY_SEPARATOR;
    }

    public static function setUpBeforeClass()
    {
        if( defined( 'LOG' ) && ( false !== LOG )) {
            $fileName = self::getCm( get_called_class()) . '.log';
            file_put_contents( self::getRealPath() . LOG . DIRECTORY_SEPARATOR . $fileName, '' );
            $logger  = new KLogger(
                LOG,
                LogLevel::DEBUG,
                [ 'filename' => $fileName ]
            );
        }
        else {
            $logger = new NullLogger();
        }
        $key = __NAMESPACE__;
        if( ! LoggerDepot::isLoggerSet( $key )) {
            LoggerDepot::registerLogger( $key, $logger );
        }
    }

    public static function tearDownAfterClass() {
        foreach( LoggerDepot::getLoggerKeys() as $key ) {
            LoggerDepot::unregisterLogger( $key );
        }
    }

}
