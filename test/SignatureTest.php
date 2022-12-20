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

use DOMNode;
use Exception;
use Kigkonsult\DsigSdk\Dto\Signature;
use Kigkonsult\DsigSdk\XMLParse\DsigParser;
use Kigkonsult\DsigSdk\XMLWrite\DsigWriter;
use Kigkonsult\DsigSdk\DsigLoader\Signature2 as SignatureLoader;

/**
 * Class SignatureTest
 */
class SignatureTest extends BaseTest
{

    /**
     * Create minimal sie-instance loaded with Faker-data, write xml1 and parse again, write xml2 and compare
     *
     * @test
     * @throws Exception
     */
    public function signatureTest2() : void
    {

        echo PHP_EOL . ' START  (min) ' . __FUNCTION__ . PHP_EOL;
        $startTime  = microtime( true );               // ---- load
        $signature1 = SignatureLoader::loadFromFaker();
        echo sprintf( '%s load time    : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        $startTime = microtime( true );               // ---- write to XML
        $xml1      = DsigWriter::factoryWrite( $signature1 );
        echo sprintf( '%s write time 1 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            $fileName1 = self::getBasePath() . SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '1.xml';
            touch( $fileName1 );
            file_put_contents( $fileName1, $xml1 );
        }

        $startTime  = microtime( true );               // ---- parse XML
        $signature2 = DsigParser::factory()->parseXmlFromString( $xml1 );
        echo sprintf( '%s parse time   : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;
        //echo 'XML attr then ' . var_export( $signature1->getXMLattributes(), true ) . PHP_EOL; // test ###

        $startTime = microtime( true );               // ---- write XML again
        $xml2      = DsigWriter::factoryWrite( $signature2 );
        echo sprintf( '%s write time 2 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            $fileName2 = self::getBasePath() . SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '2.xml';
            touch( $fileName2 );
            file_put_contents( $fileName2, $xml2 );
        }
        echo 'xml1 : ' . substr( $xml1, 0, 200 ) . PHP_EOL; // test ###
        echo 'xml2 : ' . substr( $xml2, 0, 200 ) . PHP_EOL; // test ###

        $this->assertSame(
            $xml1,
            $xml2,
            'Failed (#1) asserting that two Dsig (signatureTest2) documents are equal.'
        );
        /* will not work... TypeError...
        try {
//            $this->assertXmlStringEqualsXmlString(
            self::assertXmlStringEqualsXmlString(
                $xml1,
                $xml2,
                'Failed asserting that two Dsig (signatureTest2) documents are equal.'
            );
        }
        catch( \ValueError $te ) {
            echo $te->getMessage() . PHP_EOL . $te->getTraceAsString() . PHP_EOL; // test ###
            $this->fail();
        }
        */
    }

    /**
     * Same as signatureTest2 but with prefix set
     *
     * @test
     * @throws Exception
     */
    public function signatureTest5() : void
    {

        echo PHP_EOL . ' START (min+prefix) ' . __FUNCTION__ . PHP_EOL;
        // ---- load
        $startTime  = microtime( true );
        $signature1 = SignatureLoader::loadFromFaker();
        echo sprintf( '%s load time    : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        // ---- write XML
        $startTime = microtime( true );
        $xml1      = DsigWriter::factoryWrite( $signature1 );
        echo sprintf( '%s write time 1 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            $fileName1 = self::getBasePath() . SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '1.xml';
            touch( $fileName1 );
            file_put_contents( $fileName1, $xml1 );
        }
        // ---- parse XML
        $startTime  = microtime( true );
        $signature2 = DsigParser::factoryParse( $xml1 );
        echo sprintf( '%s parse time   : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        // $XMLattributes = $signature2->getXMLattributes();
        // echo 'XML attr before ' . var_export( $XMLattributes, true ) . PHP_EOL; // test ###

        // ---- set XML schema attrs
        $signature2->unsetXMLattribute( Signature::XMLNS, true );
        $XMLnsDenom = Signature::XMLNS . ':dsig';
        $signature2->setXMLattribute( Signature::PREFIX, 'dsig', true );
        $signature2->setXMLattribute( $XMLnsDenom, Signature::DSIGURI, false );

        $XMLattributes = $signature2->getXMLattributes();
        $this->assertFalse( isset( $XMLattributes[Signature::XMLNS] ));
        $this->assertTrue( isset( $XMLattributes[$XMLnsDenom] ));
        // echo 'XML attr after ' . var_export( $XMLattributes, true ) . PHP_EOL; // test ###

        // real test ends here

        // ---- write XML again
        $startTime = microtime( true );
        $xml2      = DsigWriter::factoryWrite( $signature2 );
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
     * @throws Exception
     */
    public function signatureTest6() : void
    {
        echo PHP_EOL . ' START  (domNode) ' . __FUNCTION__ . PHP_EOL;
        $signature = SignatureLoader::loadFromFaker();

        $xml       = DsigWriter::factoryWrite( $signature );
        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            $fileName = self::getBasePath() . SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '1.xml';
            touch( $fileName );
            file_put_contents( $fileName, $xml );
        }

        $domNode   = DsigParser::factory()->parse( $xml, true );

        $this->assertInstanceOf( DOMNode::class, $domNode );
    }

    /**
     * Read XML from file
     *
     * @test
     * @throws Exception
     */
    public function signatureTest8() : void
    {
        echo PHP_EOL . ' START file write/read test in ' . __FUNCTION__ . PHP_EOL;
        $signature = SignatureLoader::loadFromFaker();
        $xml1      = DsigWriter::factoryWrite( $signature );

        $tmpFile   = tempnam( sys_get_temp_dir(), __FUNCTION__ );
        $handle    = fopen( $tmpFile, "wb" );
        fwrite( $handle,$xml1 );
        fclose( $handle );

        $signature2 = DsigParser::factory()->parseXmlFromFile( $tmpFile );
        $xml2      = DsigWriter::factoryWrite( $signature2 );

        $this->assertSame(
            $xml1,
            $xml2,
            'Failed asserting that two Dsig (signatureTest8) documents are equal.'
        );

        unlink( $tmpFile );
    }
}
