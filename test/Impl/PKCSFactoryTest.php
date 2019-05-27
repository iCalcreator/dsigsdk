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
namespace Kigkonsult\DsigSdk\Impl;

use Exception;
use Kigkonsult\DsigSdk\BaseTest;

/**
 * Class PKCSFactoryTest
 */
class PKCSFactoryTest extends BaseTest
{

    /**
     * testPbkdf2 dataProvider
     * @return array
     */
    public function pbkdf2Provider() {
        $dataArr = [];

        $algoHash = [
            'md2'        => '5fc07420aebeb766cc0e55e769f44852f7ac7c31a9bcbf854878265fa6ac',
            'md4'        => '2097b8f27f81fed6cf0cd6bee10a357bd4e63231223e1955bf2e64571f62',
            'md5'        => '4b51ebd6941010cc1563d5003426667e9d975c3163258fb827c5bcf75143',
            'sha1'       => '10b7153b707dc4840d8af9c702709a489992466c27ce9b96dcc6ac794c62',
            'sha256'     => '5e5d855747d70fcd0e7d72efaa78db6ffc96af66a251873a5efdc1488b97',
            'sha384'     => '31c6b9d0e104f666b6431e363ab514e5265353c66b537fed16ace705e84a',
            'sha512'     => 'e0719ea50f6004d40893beb30bb3fd863f5598fe25f3ded24978e5eea39c',
            'ripemd128'  => '31e43d31c53d89a2e6dfd51cd02ec72ff9ef2f0d30ddd7ec29588034d845',
            'ripemd160'  => '83b90aa169b786fd7fb82f47b3d012d2dfcfc4efe433b7bade5ca09f9be5',
            'ripemd256'  => '11cc2b6b18e7c73bcd8df38c42b4e7a02979aa6322e8811117b30a9306ac',
            'ripemd320'  => '624c2ea2aceb0600a77b6a08ba560274ee5039d3611af8631a8513ebb702',
            'whirlpool'  => 'c522d90b4bb0e5edf31d92dc248c0e234cc8156e33d508c567dfb41cfaa6',
            'tiger128,3' => 'b653e56a95d53f0a7bcc92fbc8e1d0319a47411af00393b214025221ace4',
            'tiger160,3' => 'de8ce0b64bc518413e06c62a6da478f371545b0efd463efa2decab51fcd9',
            'tiger192,3' => '75c4fb24aedfa2fc099b8263a78cbcc80a3299a4337b9bf956c0589e5f57',
            'tiger128,4' => 'fbef745fefc2f67dd4d54dbda712139a8a2a8165d8c50b85a5f0c45d6e82',
            'tiger160,4' => 'c61f9a9328ea14b66b31eb24b2152ae4ec149027e806f2f5736788c8a959',
            'tiger192,4' => '3da4d691386b5028008249849021e35f065bdc28ac3cef1ba682942659e3',
            'snefru'     => 'ee5edd0d1ebfc8d25e90b04f5930e77427d33c840952cf363a80e9a90f8e',
            'gost'       => '5f0917642b94876c19984881aee72aeb5674519540202a10244554fb6f76',
            'adler32'    => '0753004a05a1026003d6018605e0020402c0037e033601d5019a0282044a',
            'crc32'      => '6db6a78a8899a00e1c0be25ccf8170055b133257be3c35d32aae7781838a',
            'crc32b'     => 'cdf73d4481aa6282b3caa9801aa90e1a28c9c51864949ade56f451dc904d',
            'haval128,3' => 'b8e623048b5eb79b686be45bc3c94042ef1dc63612c27ea5a74478609952',
            'haval160,3' => 'c4916d25937d62e38f3e4c5e002c9a7429d748070f7c949eb55ddc00baa4',
            'haval192,3' => 'c5c4ca108905645daa631f91b7930cbfa3ff560f37bfa3616312a4afb559',
            'haval224,3' => 'c4e0d6b420837c3615a6bfd449a19b7621eadac7469ad840cef2e9d52288',
            'haval256,3' => '0332942e30f74891d1bf9f7d18ef89faf5ec551f5d672459cb9bda114bc0',
            'haval128,4' => 'd2758e52eaa7e87dbf042627bba660b046cfb12533f83952560cc7a31e89',
            'haval160,4' => '1cf7b84c68ae48b8fd28a3c4234535b042bc6c58da808b7fafc4f5c12ded',
            'haval192,4' => 'a7c3e48e3a7fc27b1620751168a5222c975a1a9acaa0c8697cfc057ed7a9',
            'haval224,4' => 'cd54c61469c678b6055c8ba98d3aa8378d55de0fe2ba0138fef6dbcc2893',
            'haval256,4' => '6b6021adaacbf39b9742e66d0987927f079ef6138227a6929d48b7c4598a',
            'haval128,5' => '7c0acfd7f1192086d521159af1b927c7ff93601bb2de9e849547dafe4fbd',
            'haval160,5' => '36aed47616bc297395e3a792141a679b79300df4ae6981eb460ca6b18c43',
            'haval192,5' => '8730769a26cf05720f7c5cbb4213c4b5523b698aef3aae88150c23422c57',
            'haval224,5' => 'b6607cc5631a86d10836c6dc6d8b1e16deb81079d9875110244fcb6bb993',
            'haval256,5' => '0218fd1593e1411124c4236567a74e3827b826bdb81bcd51b9ae6d9c2919',
        ];
        $data       = 'hello';
        $salt       = 'The quick brown fox jumped over the lazy dog.';
        $iterations = 1024;
        $keyLength  = 60;
        $case       = 1;
        foreach( $algoHash as $algorithm => $hash ) {
            $dataArr[] = [
                $case++,
                $algorithm,
                $data,
                $salt,
                $iterations,
                $keyLength,
                $hash,
            ];
        }

        return $dataArr;
    }

    /**
     * Test pbkdf2
     *
     * @test
     * @dataProvider pbkdf2Provider
     * @param int    $case
     * @param string $algorithm
     * @param string $data
     * @param string $expected
     */
    public function testPbkdf2( $case, $algorithm, $data, $salt, $iterations, $keyLength, $expected ) {
        static $FMT = '%s Error in case #%d, algorithm: %s, hash: %s';

        $hash = PKCSFactory::pbkdf2( $algorithm, $data, $salt, $iterations, $keyLength );

        $this->assertTrue(
            HashFactory::hashEquals( $expected, $hash ),
            sprintf( $FMT, self::getCm( __METHOD__ ), $case, $algorithm, $hash )
        );
    }

    /**
     * testPbkdf2exeptions dataProvider
     * @return array
     */
    public function pbkdf2exeptionsProvider() {
        $dataArr = [];

        $dataArr[] = [
            1,
            'noAlgorithm',
            'data',
            'salt',
            8,
            1024
        ];

        $dataArr[] = [
            2,
            HmacHashFactory::SHA256,
            'data',
            'salt',
            -1,
            1024
        ];

        $dataArr[] = [
            3,
            HmacHashFactory::SHA256,
            'data',
            'salt',
            8,
            -1,
        ];

        return $dataArr;
    }

    /**
     * Testing pbkdf2 exceptions
     *
     * @test
     * @dataProvider pbkdf2exeptionsProvider
     * @param int    $case
     * @param string $data
     * @param string $expected
     */
    public function testPbkdf2exeptions( $case, $algorithm, $data, $salt, $iterations, $keyLength ) {
        static $FMT  = '%s Error in case #%d';
        $result  = null;
        $outcome = true;
        try {
            $result = PKCSFactory::pbkdf2( $algorithm, $data, $salt, $iterations, $keyLength );
        }
        catch( Exception $e ) {
            $outcome = false;
        }

        $this->assertFalse( $outcome, sprintf( $FMT, self::getCm( __METHOD__ ), $case ));

    }
}
