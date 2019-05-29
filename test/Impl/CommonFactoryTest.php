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
 * Version   0.971
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
namespace Kigkonsult\DsigSdk\Impl;

use Exception;
use Faker;
use Kigkonsult\DsigSdk\DsigIdentifiersInterface;
use Kigkonsult\DsigSdk\DsigInterface;
use Kigkonsult\DsigSdk\BaseTest;

/**
 * Class CommonFactoryTest
 */
class CommonFactoryTest extends BaseTest implements DsigInterface, DsigIdentifiersInterface
{
    private static $FMT  = '%s Error in case #%d';
    private static $FMT2 = '%s Error in case #%d, expected %d, actual %d';

    /**
     * testAssertString dataProvider
     * @return array
     */
    public function assertStringProvider() {
        $dataArr = [];

        $dataArr[] = 
        [
            21,
            'string',
            true
        ];

        $dataArr[] = 
        [
            21,
            [],
            false
        ];

        return $dataArr;
    }

    /**
     * Testing ImplBase::AssertString
     *
     * @test
     * @dataProvider assertStringProvider
     * @param int    $case
     * @param string $data
     * @param string $expected
     */
    public function testAssertString( $case, $data, $expected ) {

        $outcome = true;
        try {
            CommonFactory::assertString( $data );
        }
        catch( Exception $e ) {
            $outcome = false;
        }

        $this->assertEquals( $expected, $outcome, sprintf( self::$FMT, self::getCm( __METHOD__ ), $case . '1' ));
    }

    /**
     * getRandomPseudoBytes dataProvider
     * @return array
     */
    public function getRandomPseudoBytesProvider() {
        $dataArr = [];

        $dataArr[] =
            [
                31,
                32,
                32
            ];

        $dataArr[] =
            [
                32,
                64,
                64
            ];

        $dataArr[] =
            [
                33,
                128,
                128
            ];

        return $dataArr;
    }

    /**
     * Testing CommonFactory::getRandomPseudoBytes
     *
     * @test
     * @dataProvider getRandomPseudoBytesProvider
     * @param int   $case
     * @param mixed $byteCnt
     * @param int   $expected
     */
    public function testgetRandomPseudoBytes( $case, $byteCnt, $expected ) {
        $result = CommonFactory::getRandomPseudoBytes( $byteCnt );
        $this->assertTrue(
            is_string( $result ),
            sprintf( self::$FMT, self::getCm( __METHOD__ ), $case . 1 )
        );
        $this->assertTrue(
            ( $byteCnt == strlen( $result )),
            sprintf( self::$FMT2, self::getCm( __METHOD__ ), $case . 2, $expected, strlen( $result ))
        );
    }

    /**
     * testgetSalt dataProvider
     * @return array
     */
    public function getSaltProvider() {
        $dataArr = [];

        $dataArr[] =
            [
                41,
                null,
                64
            ];

        $dataArr[] =
            [
                42,
                64,
                64
            ];

        $dataArr[] =
            [
                43,
                128,
                128
            ];

        return $dataArr;
    }

    /**
     * Testing CommonFactory::getSalt
     *
     * @test
     * @dataProvider getSaltProvider
     * @param int   $case
     * @param mixed $byteCnt
     * @param int   $expected
     */
    public function testgetSalt( $case, $byteCnt, $expected ) {
        $result = CommonFactory::getSalt( $byteCnt );
        $this->assertTrue(
            is_string( $result ),
            sprintf( self::$FMT, self::getCm( __METHOD__ ), $case . 1 )
        );
        $this->assertTrue(
            ( $expected == strlen( $result )),
            sprintf( self::$FMT2, self::getCm( __METHOD__ ), $case . 2, $expected, strlen( $result ))
        );
        $this->assertTrue(
            CommonFactory::isHex( $result ),
            sprintf( self::$FMT, self::getCm( __METHOD__ ), $case . 3 )
        );
    }

    /**
     * testGetAlgorithmFromIdentifier dataProvider
     * @return array
     */
    public function getAlgorithmFromIdentifierProvider() {
        $dataArr = [];

        $dataArr[] = [ 501, self::MD5,                  'md5',  ];
        $dataArr[] = [ 502, self::SHA_224,              'sha224',  ];
        $dataArr[] = [ 503, self::SHA_384,              'sha384', ];
        $dataArr[] = [ 504, self::HMAC_MD5,             'hmac-md5',  ];
        $dataArr[] = [ 505, self::HMAC_SHA224,          'hmac-sha224', ];
        $dataArr[] = [ 506, self::HMAC_SHA256,          'hmac-sha256', ];
        $dataArr[] = [ 507, self::HMAC_SHA384,          'hmac-sha384', ];
        $dataArr[] = [ 508, self::HMAC_SHA512,          'hmac-sha512', ];
        $dataArr[] = [ 509, self::HMAC_RIPEMD160,       'hmac-ripemd160', ];
        $dataArr[] = [ 510, self::RSA_MD5,              'rsa-md5', ];
        $dataArr[] = [ 511, self::RSA_SHA256,           'rsa-sha256', ];
        $dataArr[] = [ 512, self::RSA_SHA384,           'rsa-sha384', ];
        $dataArr[] = [ 513, self::RSA_SHA512,           'rsa-sha512', ];
        $dataArr[] = [ 514, self::RSA_RIPEMD160,        'rsa-ripemd160', ];
        $dataArr[] = [ 515, self::ECDSA_SHA1,           'ecdsa-sha1', ];
        $dataArr[] = [ 516, self::ECDSA_SHA224,         'ecdsa-sha224', ];
        $dataArr[] = [ 517, self::ECDSA_SHA256,         'ecdsa-sha256', ];
        $dataArr[] = [ 518, self::ECDSA_SHA384,         'ecdsa-sha384', ];
        $dataArr[] = [ 519, self::ECDSA_SHA512,         'ecdsa-sha512', ];
        $dataArr[] = [ 520, self::ESIGN_SHA1,           'esign-sha1', ];
        $dataArr[] = [ 521, self::ESIGN_SHA224,         'esign-sha224', ];
        $dataArr[] = [ 522, self::ESIGN_SHA256,         'esign-sha256', ];
        $dataArr[] = [ 523, self::ESIGN_SHA384,         'esign-sha384', ];
        $dataArr[] = [ 524, self::ESIGN_SHA512,         'esign-sha512', ];
        $dataArr[] = [ 525, self::MINICANONICAL,        'minimal', ];
        $dataArr[] = [ 526, self::CANONICAL,            'REC-xml-c14n-20010315' ];
        $dataArr[] = [ 527, self::XPOINTER,             'xptr', ];
        $dataArr[] = [ 528, self::ARCFOUR,              'arcfour', ];
        $dataArr[] = [ 529, self::CAMELLIA128,          'camellia128-cbc', ];
        $dataArr[] = [ 530, self::CAMELLIA192,          'camellia192-cbc', ];
        $dataArr[] = [ 531, self::CAMELLIA256,          'camellia256-cbc', ];
        $dataArr[] = [ 532, self::KWCAMELLIA128,        'kw-camellia128', ];
        $dataArr[] = [ 533, self::KWCAMELLIA192,        'kw-camellia192', ];
        $dataArr[] = [ 534, self::KWCAMELLIA256,        'kw-camellia256', ];
        $dataArr[] = [ 535, self::PSEC_KEM,             'psec-kem', ];
        $dataArr[] = [ 536, self::RMKEYVALUE,           'KeyValue', ];
        $dataArr[] = [ 537, self::RMRETRIEVALMETHOD,    'RetrievalMethod', ];
        $dataArr[] = [ 538, self::RMKENAME,             'KeyName', ];
        $dataArr[] = [ 539, self::RMRAWX509CRL,         'rawX509CRL', ];
        $dataArr[] = [ 540, self::RMRAWPGPKEYPACKET,    'rawPGPKeyPacket', ];
        $dataArr[] = [ 541, self::RMRAWSPKISEXP,        'rawSPKISexp', ];
        $dataArr[] = [ 542, self::RMPKCS7SIGNEDDATA,    'PKCS7signedData', ];
        $dataArr[] = [ 543, self::RMRAWPKCS7SIGNEDDATA, 'rawPKCS7signedData', ];
        
        return $dataArr;
    }
        
    /**
     * Testing CommonFactory::getAlgorithmFromIdentifier
     *
     * @test
     * @dataProvider getAlgorithmFromIdentifierProvider
     * @param int    $case
     * @param string $identifier
     * @param string $expected
     */
    public function testGetAlgorithmFromIdentifier( $case, $identifier, $expected ) {
        static $FMT  = '%s Error in case #%d, identifier: %s, actual: %s, expected: %s';
        
        $result = CommonFactory::getAlgorithmFromIdentifier( $identifier );

        $this->assertEquals( 
            $expected, 
            $result, 
            sprintf( $FMT, self::getCm( __METHOD__ ), $case, $identifier, $expected, $result )
        );
    }

    /** ***********************************************************************
     * textProvider
     *
     * @return array
     */
    public function textProvider() {
        $faker   = Faker\Factory::create();
        $dataArr = [];

        $case    = 10;
        for( $x = 0; $x < 3; $x++ ) {
            $dataArr[] =
                [
                    ++$case,
                    $faker->randomNumber( null, true )
                ];
        }

        $case    = 20;
        for( $x = 0; $x < 3; $x++ ) {
            $dataArr[] =
                [
                    ++$case,
                    number_format( $faker->randomFloat(), 6, '.', '' )
                ];
        }

        $dataArr[] =
            [
                31,
                $faker->word,
            ];

        $dataArr[] =
            [
                41,
                $faker->paragraphs( 1, true ),
            ];
        $dataArr[] =
            [
                51,
                $faker->paragraphs( 10, true )
            ];

        $dataArr[] =
            [
                61,
                $faker->paragraphs( 100, true )
            ];

        $dataArr[] =
            [
                71,
                $faker->paragraphs( 1000, true )
            ];

        return $dataArr;
    }

    private static $FMT3  = '%s #%d, %s time : %01.6f testing on %d characters string';


    /** ***********************************************************************
     *  Base64
     ** ******************************************************************** */

    /**
     * @test
     * @dataProvider textProvider
     * @param int    $case
     * @param string $string
     */
    public function testBase64EnDecode( $case, $string ) {

        $case = 600 + $case;
        $startTime = microtime( true );
        $encoded   = CommonFactory::base64Encode( $string );
        $time1     = microtime( true ) - $startTime;

        $startTime = microtime( true );
        $decoded  = CommonFactory::base64Decode( $encoded );
        $time2     = microtime( true ) - $startTime;
        if( 660 <= $case ) {
            echo sprintf(
                self::$FMT3, self::getCm( __METHOD__ ), $case, 'encode', $time1, strlen( $string )
                ) . PHP_EOL;
            echo sprintf(
                self::$FMT3, self::getCm( __METHOD__ ), $case, 'decode', $time2, strlen( $encoded )
                ) . PHP_EOL;
        }
        $this->assertEquals( $string, $decoded, sprintf( self::$FMT, self::getCm( __METHOD__ ), $case . 1 ));
    }

    /**
     * @test
     */
    public function testBase64UrlEnDecode() {
        $url = Faker\Factory::create()->url;

        $this->assertEquals(
            $url,
            CommonFactory::base64UrlDecode(
                CommonFactory::base64UrlEncode( $url )
            ),
            sprintf( self::$FMT, self::getCm( __METHOD__ ), 71 )
        );
        /*
                // proof
                for( $i = 0, $s = ''; $i < 24; ++$i, $s .= substr("$i", -1 )) {
                    $base64_encoded    = CommonFactory::base64Encode( $s );
                    $base64url_encoded = CommonFactory::base64UrlEncode( $s );
                    $base64url_decoded = CommonFactory::base64UrlDecode( $base64url_encoded );
                    $base64_restored   = strtr( $base64url_encoded, '-_', '+/' )
                        . str_repeat( '=',
                                      3 - ( 3 + strlen( $base64url_encoded ) ) % 4
                        );
                    echo PHP_EOL .
                        'raw           : ' . $s . PHP_EOL .
                        '64url_decoded : ' . $base64url_decoded . PHP_EOL .
                        '64_encoded    : ' . $base64_encoded . PHP_EOL .
                        '64_restored   : ' . $base64_restored . PHP_EOL .
                        '64url_encoded : ' . $base64url_encoded . PHP_EOL;
                }
        */
    }

    /** ***********************************************************************
     * isHex, strToHex, hexToStr
     ** ******************************************************************** */

    /**
     * Testing isHex, strToHex, hexToStr
     *
     * @test
     * @dataProvider textProvider
     * @param int    $case
     * @param string $string
     */
    public function testHex( $case, $string ) {
        $case = 800 + $case;

        $startTime = microtime( true );
        $hex       = CommonFactory::strToHex( $string );
        $time1     = microtime( true ) - $startTime;

        $this->assertTrue(
            CommonFactory::isHex( $hex ),
            sprintf( self::$FMT, self::getCm( __METHOD__ ), $case . '1' )
        );

        $startTime = microtime( true );
        $string2   = CommonFactory::hexToStr( $hex );
        $time2     = microtime( true ) - $startTime;
        if( 860 <= $case ) {
            echo sprintf(
                self::$FMT3, self::getCm( __METHOD__ ), $case, 'encode', $time1, strlen( $string )
                ) . PHP_EOL;
            echo sprintf(
                self::$FMT3, self::getCm( __METHOD__ ), $case, 'decode', $time2, strlen( $hex )
                ) . PHP_EOL;
        }

        if( ! ctype_digit( $string2 )) {
            $this->assertFalse(
                CommonFactory::isHex( $string2 ),
                sprintf( self::$FMT, self::getCm( __METHOD__ ), $case . '2' ) . ' pos1-10: \'' . substr( $string2, 0, 10 ) . '\''
            );
        }

        $this->assertEquals(
            $string,
            $string2,
            sprintf( self::$FMT, self::getCm( __METHOD__ ), $case . '3' )
        );

    }

    /** ***********************************************************************
     *  'H*' - pach/unpack data
     ** ******************************************************************** */

    /**
     * Test pack/unpack
     *
     * @test
     * @dataProvider textProvider
     * @param int    $case
     * @param string $string
     */
    public function testPackUnpack( $case, $string ) {
        static $FMT1 = ', input: %d, hex: %d, packed: %d, unpacked: %d, result: %d';
        $case = 900 + $case;
        $hex       = CommonFactory::strToHex( $string );

        $startTime = microtime( true );
        $packed    = CommonFactory::Hpach( $hex );
        $time1     = microtime( true ) - $startTime;

        $startTime = microtime( true );
        $unPacked  = CommonFactory::HunPach( $packed );
        $time2     = microtime( true ) - $startTime;

        $result    = CommonFactory::hexToStr( $unPacked );
        if( 960 <= $case ) {
            echo sprintf(
                self::$FMT3, self::getCm( __METHOD__ ), $case, 'encode', $time1, strlen( $hex )
                ) . PHP_EOL;
            echo sprintf(
                self::$FMT3, self::getCm( __METHOD__ ), $case, 'decode', $time2, strlen( $packed )
                ) . PHP_EOL;
        }

        $this->assertEquals(
            $string,
            $result,
            sprintf(
                self::$FMT,
                self::getCm( __METHOD__ ),
                $case ) .
            sprintf( $FMT1, strlen( $string ), strlen( $hex ), strlen( $packed ), strlen( $unPacked ), strlen( $result ))
        );
    }

}
