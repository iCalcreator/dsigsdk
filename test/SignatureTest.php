<?php
/**
 * DsigSdk    the PHP XML Digital Signature recommendation SDK,
 *            source http://www.w3.org/2000/09/xmldsig#
 *
 * This file is a part of DsigSdk.
 *
 * @author    Kjell-Inge Gustafsson, kigkonsult <ical@kigkonsult.se>
 * @copyright 2019-21 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
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

use DOMNode;
use InvalidArgumentException;
use Katzgrau\KLogger\Logger as KLogger;
use Kigkonsult\DsigSdk\Dto\SignatureType;
use Kigkonsult\DsigSdk\Dto\Util;
use Kigkonsult\DsigSdk\XMLParse\DsigParser;
use Kigkonsult\DsigSdk\XMLWrite\DsigWriter;
use Kigkonsult\DsigSdk\DsigLoader\SignatureType as SignatureType1;
use Kigkonsult\DsigSdk\DsigLoader\SignatureType2;
use Kigkonsult\LoggerDepot\LoggerDepot;
use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;
use Psr\Log\NullLogger;

/**
 * Class SignatureTest
 */
class SignatureTest extends TestCase
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

    public static function getCm( $name ) : string
    {
        return substr( $name, ( strrpos($name,  '\\' ) + 1 ));
    }

    public static function getBasePath() : string
    {
        $dir0 = $dir = __DIR__;
        $level = 6;
        while( ! is_dir( $dir . DIRECTORY_SEPARATOR . 'test' )) {
            $dir = realpath( __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR );
            if( false == $dir ) {
                $dir = $dir0;
                break;
            }
            $level -= 1;
            if( empty( $level )) {
                $dir = $dir0;
                break;
            }
        }
        return $dir . DIRECTORY_SEPARATOR;
    }

    public static function setUpBeforeClass()
    {
        if( defined( 'LOG' ) && ( false !== LOG )) {
            $basePath = self::getBasePath() . LOG . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR;
            $fileName = self::getCm( get_called_class()) . '.log';
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

    public static function tearDownAfterClass()
    {
        foreach( LoggerDepot::getLoggerKeys() as $key ) {
            LoggerDepot::unregisterLogger( $key );
        }
    }

    /**
     * Create minimal sie-instance loaded with Faker-data, write xml1 and parse again, write xml2 and compare
     *
     * @test
     */
    public function signatureTest2()
    {

        echo PHP_EOL . ' START  (min) ' . __FUNCTION__ . PHP_EOL;
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
            $fileName1 = self::getBasePath() . SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '1.xml';
            touch( $fileName1 );
            file_put_contents( $fileName1, $xml1 );
        }

        $startTime  = microtime( true );               // ---- parse XML
        $signature2 = DsigParser::factory()->parse( $xml1 );
        echo sprintf( '%s parse time   : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;
        //echo 'XML attr then ' . var_export( $signature1->getXMLattributes(), true ) . PHP_EOL; // test ###

        $startTime = microtime( true );               // ---- write XML again
        $xml2      = DsigWriter::factory()->write( $signature2 );
        echo sprintf( '%s write time 2 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            $fileName2 = self::getBasePath() . SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '2.xml';
            touch( $fileName2 );
            file_put_contents( $fileName2, $xml2 );
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
    public function signatureTest3()
    {

        echo PHP_EOL . ' START (full) ' . __FUNCTION__ . PHP_EOL;
        // ---- load
        $startTime  = microtime( true );
        $signature1 = SignatureType1::loadFromFaker();
        echo sprintf( '%s load time    : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        $signature1->setXMLattribute( 'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance' );
        $signature1->setXMLattribute( 'xmlns:xsd', 'http://www.w3.org/2001/XMLSchema' );
        $signature1->setXMLattribute( 'xsi:schemaLocation', 'http://www.w3.org/2000/09/xmldsig# http://www.w3.org/2000/09/xmldsig#' );
        $signature1->setXMLattribute( 'xmlns', 'http://www.w3.org/2000/09/xmldsig#' );

        // ---- write XML
        $startTime = microtime( true );
        $xml1      = DsigWriter::factory()->write( $signature1 );
        echo sprintf( '%s write time 1 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            $fileName1 = self::getBasePath() . SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '1.xml';
            touch( $fileName1 );
            file_put_contents( $fileName1, $xml1 );
        }

        // ---- parse XML
        $startTime  = microtime( true );
        $signature2 = DsigParser::factory()->parse( $xml1 );
        echo sprintf( '%s parse time   : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        // ---- write XML again
        $startTime = microtime( true );
        $xml2      = DsigWriter::factory()->write( $signature2 );
        echo sprintf( '%s write time 2 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        // compare
        $this->assertXmlStringEqualsXmlString(
            $xml1,
            $xml2,
            'Failed asserting that two Signature (signatureTest3) documents are equal.'

        );
        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            $fileName2 = self::getBasePath() . SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '2.xml';
            touch( $fileName2 );
            file_put_contents( $fileName2, $xml2 );
        }
    }

    /**
     * Same as signatureTest2 but with prefix set
     *
     * @test
     */
    public function signatureTest5()
    {

        echo PHP_EOL . ' START (min+prefix) ' . __FUNCTION__ . PHP_EOL;
        // ---- load
        $startTime  = microtime( true );
        $signature1 = SignatureType2::loadFromFaker();
        echo sprintf( '%s load time    : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        $signature1->setXMLattribute( 'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance' );
        $signature1->setXMLattribute( 'xmlns:xsd', 'http://www.w3.org/2001/XMLSchema' );
        $signature1->setXMLattribute( 'xsi:schemaLocation', 'http://www.w3.org/2000/09/xmldsig# http://www.w3.org/2000/09/xmldsig#' );
        $signature1->setXMLattribute( 'xmlns', 'http://www.w3.org/2000/09/xmldsig#' );

        // ---- write XML
        $startTime = microtime( true );
        $xml1      = DsigWriter::factory()->write( $signature1 );
        echo sprintf( '%s write time 1 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            $fileName1 = self::getBasePath() . SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '1.xml';
            touch( $fileName1 );
            file_put_contents( $fileName1, $xml1 );
        }
        // ---- parse XML
        $startTime  = microtime( true );
        $signature2 = DsigParser::factory()->parse( $xml1 );
        echo sprintf( '%s parse time   : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        // $XMLattributes = $signature2->getXMLattributes();
        // echo 'XML attr before ' . var_export( $XMLattributes, true ) . PHP_EOL; // test ###

        // ---- set XML schema attrs
        $signature2->unsetXMLattribute( SignatureType::XMLNS, true );
        $XMLnsDenom = SignatureType::XMLNS . ':dsig';
        $signature2->setXMLattribute( SignatureType::PREFIX, 'dsig', true );
        $signature2->setXMLattribute( $XMLnsDenom, self::$DsigXMLAttributes[SignatureType::XMLNS], false );

        $XMLattributes = $signature2->getXMLattributes();
        $this->assertFalse( isset( $XMLattributes[SignatureType::XMLNS] ));
        $this->assertTrue( isset( $XMLattributes[$XMLnsDenom] ));
        // echo 'XML attr after ' . var_export( $XMLattributes, true ) . PHP_EOL; // test ###

        // real test ends here

        // ---- write XML again
        $startTime = microtime( true );
        $xml2      = DsigWriter::factory()->write( $signature2 );
        echo sprintf( '%s write time 2 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            $fileName2 = self::getBasePath() . SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '2.xml';
            touch( $fileName2 );
            file_put_contents( $fileName2, $xml2 );
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
    public function signatureTest6()
    {
        echo PHP_EOL . ' START  (domNode) ' . __FUNCTION__ . PHP_EOL;
        $signature = SignatureType2::loadFromFaker();

        $xml       = DsigWriter::factory()->write( $signature );
        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            $fileName = self::getBasePath() . SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '1.xml';
            touch( $fileName );
            file_put_contents( $fileName, $xml );
        }

        $domNode   = DsigParser::factory()->parse( $xml, true );

        $this->assertTrue( $domNode instanceof DOMNode );
    }

    /**
     * @test
     */
    public function algorithmTest()
    {
        foreach( SignatureType1::ALGORITHMS as $algorithmIdentifier ) {
            $algorithm = Util::extractAlgorithmFromUriIdentifier( $algorithmIdentifier );
            $offset    = 0 - strlen( $algorithm ) - 2;
            $searchStr = substr( $algorithmIdentifier, $offset );
            $this->assertNotFalse(
                @strpos( $searchStr, $algorithm ),
                $algorithm . ' NOT found in ' . $algorithmIdentifier
            );
        } // end foreach
        $ieFound = false;
        try {
            $algorithm = Util::extractAlgorithmFromUriIdentifier( 'grodan boll' );
        }
        catch( InvalidArgumentException $e ) {
            $ieFound = true;
        }
        $this->assertTrue( $ieFound );
    }
}
