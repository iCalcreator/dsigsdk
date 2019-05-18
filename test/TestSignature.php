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

use DOMNode;
use Katzgrau\KLogger\Logger as KLogger;
use Kigkonsult\LoggerDepot\LoggerDepot;
use Kigkonsult\DsigSdk\Dto\SignatureType;
use Kigkonsult\DsigSdk\XMLParse\DsigParser;
use Kigkonsult\DsigSdk\XMLWrite\DsigWriter;
use Kigkonsult\DsigSdk\DsigLoader\SignatureType1;
use Kigkonsult\DsigSdk\DsigLoader\SignatureType2;
use Psr\Log\LogLevel;
use Psr\Log\NullLogger;

/**
 * Class TestSignature
 */
class TestSignature extends BaseTest
{

    public static function setUpBeforeClass()
    {
        if( defined( 'LOG' ) && ( false !== LOG )) {
            $fileName = 'TestSignature.log';
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
     * Create minimal sie-instance loaded with Faker-data, write xml1 and parse again, write xml2 and compare
     *
     * @test
     */
    public function signatureTest2() {

        echo PHP_EOL . ' START  ' . __FUNCTION__ . PHP_EOL;
        $startTime  = microtime( true );               // ---- load
        $signature1 = SignatureType2::loadFromFaker();
        echo sprintf( '%s load time    : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        $signature1->setXMLattribute( 'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance' );
        $signature1->setXMLattribute( 'xmlns:xsd', 'http://www.w3.org/2001/XMLSchema' );
        $signature1->setXMLattribute( 'xsi:schemaLocation', 'http://www.w3.org/2000/09/xmldsig# http://www.w3.org/2000/09/xmldsig#' );
        $signature1->setXMLattribute( 'xmlns', 'http://www.w3.org/2000/09/xmldsig#' );
        // echo 'XML attr first ' . var_export( $signature1->getXMLattributes(), true ) . PHP_EOL; // test ###

        $startTime = microtime( true );               // ---- write to XML
        $xml1      = DsigWriter::factory()->write( $signature1 );
        echo sprintf( '%s write time 1 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            file_put_contents( SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '1.xml', $xml1 );
        }

        $startTime  = microtime( true );               // ---- parse XML
        $signature2 = DsigParser::factory()->parse( $xml1 );
        echo sprintf( '%s parse time   : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;
        //echo 'XML attr then ' . var_export( $signature1->getXMLattributes(), true ) . PHP_EOL; // test ###

        $startTime = microtime( true );               // ---- write XML again
        $xml2      = DsigWriter::factory()->write( $signature2 );
        echo sprintf( '%s write time 2 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            file_put_contents( SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '2.xml', $xml2 );
        }
        $this->assertXmlStringEqualsXmlString(
            $xml1,
            $xml2,
            'Failed asserting that two Dsig (signatureTest2) documents are equal.'

        );
    }

    /**
     * Create full signature-instance loaded with Faker-data, write xml1 and parse again, write xml2 and compare
     *
     * @test
     */
    public function signatureTest3() {

        echo PHP_EOL . ' START  ' . __FUNCTION__ . PHP_EOL;
        $startTime  = microtime( true );               // ---- load
        $signature1 = SignatureType1::loadFromFaker();
        echo sprintf( '%s load time    : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        $signature1->setXMLattribute( 'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance' );
        $signature1->setXMLattribute( 'xmlns:xsd', 'http://www.w3.org/2001/XMLSchema' );
        $signature1->setXMLattribute( 'xsi:schemaLocation', 'http://www.w3.org/2000/09/xmldsig# http://www.w3.org/2000/09/xmldsig#' );
        $signature1->setXMLattribute( 'xmlns', 'http://www.w3.org/2000/09/xmldsig#' );

        $startTime = microtime( true );               // ---- write XML
        $xml1      = DsigWriter::factory()->write( $signature1 );
        echo sprintf( '%s write time 1 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            file_put_contents( SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '.xml', $xml1 );
        }

        $startTime  = microtime( true );               // ---- parse XML
        $signature2 = DsigParser::factory()->parse( $xml1 );
        echo sprintf( '%s parse time   : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        $startTime = microtime( true );               // ---- write XML again
        $xml2      = DsigWriter::factory()->write( $signature2 );
        echo sprintf( '%s write time 2 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        $this->assertXmlStringEqualsXmlString(
            $xml1,
            $xml2,
            'Failed asserting that two Signature (signatureTest3) documents are equal.'

        );
        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            file_put_contents( SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '.xml', $xml2 );
        }
    }

    /**
     * Same as signatureTest2 but with prefix set
     *
     * @test
     */
    public function signatureTest5() {

        echo PHP_EOL . ' START  ' . __FUNCTION__ . PHP_EOL;
        $startTime  = microtime( true );               // ---- load
        $signature1 = SignatureType2::loadFromFaker();
        echo sprintf( '%s load time    : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        $signature1->setXMLattribute( 'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance' );
        $signature1->setXMLattribute( 'xmlns:xsd', 'http://www.w3.org/2001/XMLSchema' );
        $signature1->setXMLattribute( 'xsi:schemaLocation', 'http://www.w3.org/2000/09/xmldsig# http://www.w3.org/2000/09/xmldsig#' );
        $signature1->setXMLattribute( 'xmlns', 'http://www.w3.org/2000/09/xmldsig#' );

        $startTime = microtime( true );               // ---- write XML
        $xml1      = DsigWriter::factory()->write( $signature1 );
        echo sprintf( '%s write time 1 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            file_put_contents( SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '1.xml', $xml1 );
        }

        $startTime  = microtime( true );               // ---- parse XML
        $signature2 = DsigParser::factory()->parse( $xml1 );
        echo sprintf( '%s parse time   : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        // $XMLattributes = $signature2->getXMLattributes();
        // echo 'XML attr before ' . var_export( $XMLattributes, true ) . PHP_EOL; // test ###

        $signature2->unsetXMLattribute( SignatureType::XMLNS, true );      // ---- set XML schema attrs
        $XMLnsDenom = SignatureType::XMLNS . ':dsig';
        $signature2->setXMLattribute( SignatureType::PREFIX, 'dsig', true );
        $signature2->setXMLattribute( $XMLnsDenom, self::$DsigXMLAttributes[SignatureType::XMLNS], false );

        $XMLattributes = $signature2->getXMLattributes();
        $this->assertFalse( isset( $XMLattributes[SignatureType::XMLNS] ));
        $this->assertTrue( isset( $XMLattributes[$XMLnsDenom] ));
        // echo 'XML attr after ' . var_export( $XMLattributes, true ) . PHP_EOL; // test ###

        // real test ends here

        $startTime = microtime( true );               // ---- write XML again
        $xml2      = DsigWriter::factory()->write( $signature2 );
        echo sprintf( '%s write time 2 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            file_put_contents( SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '2.xml', $xml2 );
        }
        $this->assertTrue(
            2 < substr_count( $xml2, 'dsig:' ),
            'Missing XMLNS denom propagated down.'

        );

    }

    /**
     * Same as signatureTest2 but output as DomNode
     *
     * @test
     */
    public function signatureTest6() {

        echo PHP_EOL . ' START  ' . __FUNCTION__ . PHP_EOL;
        $signature = SignatureType2::loadFromFaker();

        $xml       = DsigWriter::factory()->write( $signature );
        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            file_put_contents( SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '.xml', $xml );
        }

        $domNode   = DsigParser::factory()->parse( $xml, true );

        $this->assertTrue( $domNode instanceof DOMNode );

    }
}
