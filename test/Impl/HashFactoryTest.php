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
 * Class HashFactoryTest
 */
class HashFactoryTest extends BaseTest
{

    /**
     * testAssertAlgorithm dataProvider
     * @return array
     */
    public function assertAlgorithmProvider() {
        $dataArr = [];

        $dataArr[] =
            [
                11,
                'ShA512',
                true
            ];

        $dataArr[] =
            [
                12,
                'noAlgorithm',
                false
            ];

        return $dataArr;
    }

    /**
     * Testing ImplBase::assertAlgorithm
     *
     * @test
     * @dataProvider assertAlgorithmProvider
     * @param int    $case
     * @param string $algorithm
     * @param string $expected
     */
    public function testAssertAlgorithm( $case, $algorithm, $expected ) {
        static $FMT = '%s Error in case #%d';


        $result  = null;
        $outcome = true;
        try {
            $result = HashFactory::assertAlgorithm( $algorithm );
        }
        catch( Exception $e ) {
            $outcome = false;
        }

        $this->assertEquals( $expected, $outcome, sprintf( $FMT, self::getCm( __METHOD__ ), $case . '1' ));
        if( $expected ) {
            $this->assertEquals( strtolower( $algorithm ), $result, sprintf( $FMT, self::getCm( __METHOD__ ), $case . '2' ));
        }
    }

    /**
     * testHash dataProvider
     * @return array
     */
    public function HashProvider() {
        $dataArr = [];

        $algoHash = [
            'md2'        => 'a9046c73e00331af68917d3804f70655',
            'md4'        => '866437cb7a794bce2b727acc0362ee27',
            'md5'        => '5d41402abc4b2a76b9719d911017c592',
            'sha1'       => 'aaf4c61ddcc5e8a2dabede0f3b482cd9aea9434d',
            'sha256'     => '2cf24dba5fb0a30e26e83b2ac5b9e29e1b161e5c1fa7425e73043362938b9824',
            'sha384'     => '59e1748777448c69de6b800d7a33bbfb9ff1b463e44354c3553bcdb9c666fa90125a3c79f90397bdf5f6a13de828684f',
            'sha512'     => '9b71d224bd62f3785d96d46ad3ea3d73319bfbc2890caadae2dff72519673ca72323c3d99ba5c11d7c7acc6e14b8c5da0c4663475c2e5c3adef46f73bcdec043',
            'ripemd128'  => '789d569f08ed7055e94b4289a4195012',
            'ripemd160'  => '108f07b8382412612c048d07d13f814118445acd',
            'ripemd256'  => 'cc1d2594aece0a064b7aed75a57283d9490fd5705ed3d66bf9adfe3a58b25de5',
            'ripemd320'  => 'eb0cf45114c56a8421fbcb33430fa22e0cd607560a88bbe14ce70bdf59bf55b11a3906987c487992',
            'whirlpool'  => '0a25f55d7308eca6b9567a7ed3bd1b46327f0f1ffdc804dd8bb5af40e88d78b88df0d002a89e2fdbd5876c523f1b67bc44e9f87047598e7548298ea1c81cfd73',
            'tiger128,3' => '2cfd7f6f336288a7f2741b9bf874388a',
            'tiger160,3' => '2cfd7f6f336288a7f2741b9bf874388a54026639',
            'tiger192,3' => '2cfd7f6f336288a7f2741b9bf874388a54026639cadb7bf2',
            'tiger128,4' => 'e8e50e239f932a1c357194e5ead0f528',
            'tiger160,4' => 'e8e50e239f932a1c357194e5ead0f528dc2aebfe',
            'tiger192,4' => 'e8e50e239f932a1c357194e5ead0f528dc2aebfeaed01c74',
            'snefru'     => '7c5f22b1a92d9470efea37ec6ed00b2357a4ce3c41aa6e28e3b84057465dbb56',
            'gost'       => 'a7eb5d08ddf2363f1ea0317a803fcef81d33863c8b2f9f6d7d14951d229f4567',
            'adler32'    => '062c0215',
            'crc32'      => '3d653119',
            'crc32b'     => '3610a686',
            'haval128,3' => '85c3e4fac0ba4d85519978fdc3d1d9be',
            'haval160,3' => '0e53b29ad41cea507a343cdd8b62106864f6b3fe',
            'haval192,3' => 'bfaf81218bbb8ee51b600f5088c4b8601558ff56e2de1c4f',
            'haval224,3' => '92d0e3354be5d525616f217660e0f860b5d472a9cb99d6766be90b15',
            'haval256,3' => '26718e4fb05595cb8703a672a8ae91eea071cac5e7426173d4c25a611c4b8022',
            'haval128,4' => 'fe10754e0b31d69d4ece9c7a46e044e5',
            'haval160,4' => 'b9afd44b015f8afce44e4e02d8b908ed857afbd1',
            'haval192,4' => 'ae73833a09e84691d0214f360ee5027396f12599e3618118',
            'haval224,4' => 'e1ad67dc7a5901496b15dab92c2715de4b120af2baf661ecd9266317',
            'haval256,4' => '2d39577df3a6a63168826b2a10f07a65a676f5776a0772e0a877e27ec3c4c0ad',
            'haval128,5' => 'd20e920d5be9d9d34855accb501d1987',
            'haval160,5' => 'dac5e2024bfea142e53d1422b90c9ee2c8187cc6',
            'haval192,5' => 'bbb99b1e989ec3174019b20792fd92dd67175c2ff6ce5965',
            'haval224,5' => 'aa6551d75e33a9c5cd4141e9a068b1fc7b6d847f85c3ab1629578ed3',
            'haval256,5' => '348298791817d5088a6de6c1b6364756d404a50bd64e645035f8cd4291c482c7',
        ];
        $data  = 'hello';
        $case  = 201;
        foreach( $algoHash as $algorithm => $hash ) {
            $dataArr[] = [
                $case++,
                $algorithm,
                $data,
                $hash,
            ];
        }

        return $dataArr;
    }

    /**
     * @test
     * @dataProvider HashProvider
     * @param int    $case
     * @param string $algorithm
     * @param string $data
     * @param string $expected
     */
    public function testHash( $case, $algorithm, $data, $expected ) {
        static $FMT = '%s Error in case #%d, algorithm: %s, hash: %s';

        $hash = HashFactory::generate( $algorithm, $data );

        $this->assertTrue(
            HashFactory::hashEquals( $expected, $hash ),
            sprintf( $FMT, self::getCm( __METHOD__ ), $case, $algorithm, $hash )
        );
    }

    /**
     * testHashFile dataProvider
     * @return array
     */
    public function HashFileProvider() {
        $dataArr = [];

        $algoHash = [
            'md2'        => '8cd3b564d69867c9a1a54a18c256c284',
            'md4'        => 'c04f05e368caa43bb4962c281e090142',
            'md5'        => 'd1309ac1e2719cdf777c0d6e936fc92b',
            'sha1'       => 'f78bf4900bc160fcc5d4e67ae53e392b2775b190',
            'sha256'     => '0872effe487c8eb8681b0a627ce6f04c7a25bcd2a28834db42bdc40a52a85af1',
            'sha384'     => 'e13c0e9946d11fc840399869b5dd7ffd75de7d42e0aa9bd24e266560c76c4393c0e5ca647f2ff788d23ff12eb57be9c5',
            'sha512'     => 'e6fb375bb8833a79e827871bbc4ad0d9ad4324d59887d9ea82d693203df9ccae69770cbcf4844e92722aadca149d5dfd903669298c7a936843df832553273294',
            'ripemd128'  => '5394a47d55838eaba8dbcb264ca1bb17',
            'ripemd160'  => 'a98939fd02b10bcb1ed60ed0508f6f055b56e751',
            'ripemd256'  => '1b94af9c4ee93e7de5c48a8e3fadecf92de637872236b96e271d442b6dd63557',
            'ripemd320'  => 'fd99c7fbd64ae10f8a3d3c06d4a6df0ce28a99ff5163f7cdd2d7c9fb102e1ea00f12deab31879644',
            'whirlpool'  => 'b1b5e8dea35d91f77da88541a2c8ec6175162e5d3a768d4d047ef1bff73f4aa65269ab53dd4fd79e934ca699866f726c9c001e868017fac6718bc895d2432163',
            'tiger128,3' => '2a33c43fccd995b551385ccb31010d72',
            'tiger160,3' => '2a33c43fccd995b551385ccb31010d7296701589',
            'tiger192,3' => '2a33c43fccd995b551385ccb31010d729670158908f41b8c',
            'tiger128,4' => 'f3361649c10ebec01209cb122fab6b50',
            'tiger160,4' => 'f3361649c10ebec01209cb122fab6b507f0c048b',
            'tiger192,4' => 'f3361649c10ebec01209cb122fab6b507f0c048b2fcfdf39',
            'snefru'     => '8996eeb1cee904b38bf64b49c91551cca1db88760a6574fbd6b078304a34aaeb',
            'gost'       => '9bd0009ef61e190ef9bceb2730892f1cca43e57caa3b0e8b00658a258c137683',
            'adler32'    => '102f0370',
            'crc32'      => '88c2a8df',
            'crc32b'     => 'c8b2ff97',
            'haval128,3' => 'eb245265fa6190fe9e2441e8589ab16d',
            'haval160,3' => '421213bddd5aa0b2bdbc2f23a1f39f23f1175381',
            'haval192,3' => '494b296e794d3f3dd49bc1d5caa682d26f64c82b2dd0ac77',
            'haval224,3' => '3aefc97b2f001dfd64d1bafa114bf5f1d8508c9d415324270895dc7d',
            'haval256,3' => 'd9b321d927bf9e46533f5925103fd4f2d016795b73045412eb8e230fdf943204',
            'haval128,4' => '3a9d0fff2ea589393314d73e570f795a',
            'haval160,4' => 'f8bf9c061e3087323c059c2e8e8af837a6627813',
            'haval192,4' => 'ac4723cf5659a871d7f1f6cbf0617bd9b76aabf9c836e000',
            'haval224,4' => '4754aa23bf1cd3d23347ed1b7264316d929d12abf19dd4dc3f81323b',
            'haval256,4' => 'bb703c9b4b8f417ea55abf308d10279e3a7adecec231fc6d04aad3e9d794b38b',
            'haval128,5' => 'eeb96a5bd56a2333762299861fb900a0',
            'haval160,5' => '4f1ae01f31d322ba806a69fe79169feab0262146',
            'haval192,5' => '61fa0e0d35bd764a1383d55d42d6a1388d9f836963ac4efd',
            'haval224,5' => '1d4d09f4a6711f178bb6ce867bbf3bcf692756a8527cce6d8c6c7fe2',
            'haval256,5' => '105e0c4fee2ed550867b4d5d3c690b9d541a2de72ddb0d2f46b6d515235a23c6',
        ];
        $data  = 'hello';
        $case  = 301;
        foreach( $algoHash as $algorithm => $hash ) {
            $dataArr[] = [
                $case++,
                $algorithm,
                $data,
                $hash,
            ];
        }

        return $dataArr;
    }

    /**
     * @test
     * @dataProvider HashFileProvider
     * @param int    $case
     * @param string $algorithm
     * @param string $data
     * @param string $expected
     */
    public function testHashFile( $case, $algorithm, $data, $expected ) {
        static $TEST = 'test';
        static $FMT  = '%s Error in case #%d, algorithm: %s, hash: %s';

        $file = DIRECTORY_SEPARATOR .
            trim( sys_get_temp_dir(), DIRECTORY_SEPARATOR ) .
            DIRECTORY_SEPARATOR . $TEST;
        file_put_contents( $file, $data );
        CommonFactory::assertFileName( $file );

        $hash = HashFactory::generateFile( $algorithm, $file );
        unlink( $file );

        $this->assertTrue(
            HashFactory::hashEquals( $expected, $hash ),
            sprintf( $FMT, self::getCm( __METHOD__ ), $case, $algorithm, $hash )
        );
    }

    /**
     * testgenerateFileexeptions dataProvider
     * @return array
     */
    public function generateFileexeptionsProvider() {
        $dataArr = [];

        $dataArr[] = [
            401,
            HmacHashFactory::SHA256,
            'fileName'
        ];

        return $dataArr;
    }

    /**
     * Testing generateFile exceptions
     *
     * @test
     * @dataProvider generateFileexeptionsProvider
     * @param int    $case
     * @param string $data
     * @param string $expected
     */
    public function testgenerateFileexeptions( $case, $algorithm, $fileName ) {
        static $FMT  = '%s Error in case #%d';
        $result  = null;
        $outcome = true;
        try {
            $result = HashFactory::generateFile( $algorithm, $fileName );
        }
        catch( Exception $e ) {
            $outcome = false;
        }

        $this->assertFalse( $outcome, sprintf( $FMT, self::getCm( __METHOD__ ), $case ));
    }
}
