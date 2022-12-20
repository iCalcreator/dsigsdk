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

use Exception;
use Kigkonsult\DsigSdk\XMLParse\DsigParser;
use Kigkonsult\DsigSdk\XMLWrite\DsigWriter;
use Kigkonsult\DsigSdk\DsigLoader\Signature as SignatureLoader;

/**
 * Class Signature3Test
 */
class Signature3Test extends BaseTest
{
    /**
     * Create full signature-instance loaded with Faker-data, write xml1 and parse again, write xml2 and compare
     *
     * @test
     * @throws Exception
     */
    public function signatureTest3() : void
    {

        echo PHP_EOL . ' START (full) ' . __FUNCTION__ . PHP_EOL;
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

        // ---- write XML again
        $startTime = microtime( true );
        $xml2      = DsigWriter::factoryWrite( $signature2 );
        echo sprintf( '%s write time 2 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            $fileName2 = self::getBasePath() . SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '2.xml';
            touch( $fileName2 );
            file_put_contents( $fileName2, $xml2 );
        }

        // compare
        $this->assertSame(
            $xml1,
            $xml2,
            'Failed (#1) asserting that two Dsig (signatureTest2) documents are equal.'
        );
        /* will not work... TypeError
//        $this->assertXmlStringEqualsXmlString(
        self::assertXmlStringEqualsXmlString(
            $xml1,
            $xml2,
            'Failed asserting that two Signature (signatureTest3) documents are equal.'

        );
        */
    }
}
