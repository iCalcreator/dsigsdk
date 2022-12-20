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
declare( strict_types = 1 );
namespace Kigkonsult\DsigSdk;

use Katzgrau\KLogger\Logger as KLogger;
use Kigkonsult\LoggerDepot\LoggerDepot;
use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;
use Psr\Log\NullLogger;

abstract class BaseTest extends TestCase
{
    /**
     * @param string $name
     * @return string
     */
    public static function getCm( string $name ) : string
    {
        return substr( $name, ( strrpos($name,  '\\' ) + 1 ));
    }

    /**
     * @return string
     */
    public static function getBasePath() : string
    {
        $dir0 = $dir = __DIR__;
        $level = 6;
        while( ! is_dir( $dir . DIRECTORY_SEPARATOR . 'test' )) {
            $dir = realpath( __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR );
            if( false === $dir ) {
                $dir = $dir0;
                break;
            }
            --$level;
            if( empty( $level )) {
                $dir = $dir0;
                break;
            }
        }
        return $dir . DIRECTORY_SEPARATOR;
    }

    /**
     * @return void
     */
    public static function setUpBeforeClass() : void
    {
        if( defined( 'LOG' ) && ( false !== LOG )) {
            $basePath = self::getBasePath() . LOG . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR;
            $fileName = self::getCm( static::class ) . '.log';
            file_put_contents( $basePath . $fileName, '' ); // empty if exists
            $logger   = new KLogger(
                $basePath,
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

    /**
     * @return void
     */
    public static function tearDownAfterClass() : void
    {
        foreach( LoggerDepot::getLoggerKeys() as $key ) {
            LoggerDepot::unregisterLogger( $key );
        }
    }
}
