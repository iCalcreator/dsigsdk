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
namespace Kigkonsult\DsigSdk;

use Katzgrau\KLogger\Logger as KLogger;
use Kigkonsult\LoggerDepot\LoggerDepot;
use Kigkonsult\DsigSdk\XMLParse\DsigParser;
use Kigkonsult\DsigSdk\XMLWrite\DsigWriter;
use Kigkonsult\DsigSdk\DsigLoader\SignaturePropertiesType;
use Psr\Log\LogLevel;
use Psr\Log\NullLogger;

/**
 * Class TestSignatureProperties
 */
class TestSignatureProperties extends BaseTest
{

    public static function setUpBeforeClass()
    {
        if( defined( 'LOG' ) && ( false !== LOG )) {
            $fileName = 'TestSignatureProperties.log';
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

    /**
     * Create full signatureProperties-instance loaded with Faker-data, write xml1 and parse again, write xml2 and compare
     *
     * @test
     */
    public function signaturePropertiesTest3() {

        echo PHP_EOL . ' START  ' . __FUNCTION__ . PHP_EOL;
        $startTime            = microtime( true );      // ---- load
        $signatureProperties1 = SignaturePropertiesType::loadFromFaker();
        echo sprintf( '%s load time    : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        $signatureProperties1->setXMLattribute( 'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance' );
        $signatureProperties1->setXMLattribute( 'xmlns:xsd', 'http://www.w3.org/2001/XMLSchema' );
        $signatureProperties1->setXMLattribute( 'xsi:schemaLocation', 'http://www.w3.org/2000/09/xmldsig# http://www.w3.org/2000/09/xmldsig#' );
        $signatureProperties1->setXMLattribute( 'xmlns', 'http://www.w3.org/2000/09/xmldsig#' );

        $startTime = microtime( true );                 // ---- write XML
        $xml1      = DsigWriter::factory()->write( $signatureProperties1 );
        echo sprintf( '%s write time 1 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            file_put_contents( SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '.xml', $xml1 );
        }

        $startTime            = microtime( true );      // ---- parse XML
        $signatureProperties2 = DsigParser::factory()->parse( $xml1 );
        echo sprintf( '%s parse time   : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        $startTime = microtime( true );                 // ---- write XML again
        $xml2      = DsigWriter::factory()->write( $signatureProperties2 );
        echo sprintf( '%s write time 2 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        $this->assertXmlStringEqualsXmlString(
            $xml1,
            $xml2,
            'Failed asserting that two Signatureproperties (signatureTest3) documents are equal.'

        );
        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            file_put_contents( SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '.xml', $xml2 );
        }
    }

}
