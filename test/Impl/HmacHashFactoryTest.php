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
 * Class HmacHashFactoryTest
 */
class HmacHashFactoryTest extends BaseTest
{

    private static $phrase = 'The quick brown fox jumped over the lazy dog.';

    private static function getSecret() {
        static $secret = null;
        if( empty( $secret )) {
            $secret = base64_encode( self::$phrase );
        }
        return $secret;
    }

    /**
     * testAssertAlgorithm dataProvider
     * @return array
     */
    public function assertAlgorithmProvider() {
        $dataArr = [];

        $dataArr[] = [
            1,
            'ShA512',
            true
        ];

        $dataArr[] = [
            2,
            'noAlgorithm',
            false
        ];

        return $dataArr;
    }

    /**
     * Testing assertAlgorithm
     *
     * @test
     * @dataProvider assertAlgorithmProvider
     * @param int    $case
     * @param string $data
     * @param string $expected
     */
    public function testAssertAlgorithm( $case, $algorithm, $expected ) {
        static $FMT  = '%s Error in case #%d';

        $result  = null;
        $outcome = true;
        try {
            $result = HmacHashFactory::assertAlgorithm( $algorithm );
        }
        catch( Exception $e ) {
            $outcome = false;
        }

        $this->assertEquals( $expected, $outcome, sprintf( $FMT, self::getCm( __METHOD__ ), 1 ));
        if( $expected ) {
            $this->assertEquals( strtolower( $algorithm ), $result, sprintf( $FMT, self::getCm( __METHOD__ ), 2 ));
        }
    }

    /**
     * testHmacHash dataProvider
     * @return array
     */
    public function HashProvider() {
        $dataArr = [];

        $algoHash = [
            'md2'        => 'da84c3eaf85962349e6d174e1c4d059a',
            'md4'        => '86561c95385b36016e26f31f018bbefa',
            'md5'        => '3b73397d0667f85aae055d938e8671d1',
            'sha1'       => '6fb776d2d1bfb7f4780bb2899c845517b4a64de5',
            'sha224'     => 'd86957931fe36fa30a1365c9aae457f61dec903dc0de0ac7e66d36d0',
            'sha256'     => 'ae89ebde14262b0606757f5b62877fa9491b181c2a0530e1b97f546c71b30dac',
            'sha384'     => 'd4330f3dc52f6343b44678b5330eafdb8166fc5c9a6a4d46f6bd2adb5ac206d7e2f8ce6dc7a8b59a417071f7fae1b47e',
            'sha512'     => 'a0f03be6d17d114d0b542ac94accc806ca4c3594d5ab315ca88058509f0b47f2b556a063f0f47740344fbe6e5c0bc07287830e1e06dbc4a82429f01618d7d939',
            'ripemd128'  => 'bbefdb657bed40cf32ed1f59a9067098',
            'ripemd160'  => 'd6b81cbdad3231649b4f24b87ab18c1dcab32d45',
            'ripemd256'  => '95b016de4a4cd92b54a006d7f36db4fff462e717a13a11434b2e58195959905b',
            'ripemd320'  => 'c7b0c56fd60783221885592898094c2d21ea8d202982ed28617ace51984476626e6c67037d15fb9f',
            'whirlpool'  => '0d6556de6d24785523fab53d41bae95c11468b427291efd1e09c9fbfa27708f2a56e3075d480367ac5a88485d38bcd9c25bf08824343be6343a192dbfb9bd6c9',
            'tiger128,3' => '0ca6a79666730f6805ab4ca066899fc6',
            'tiger160,3' => 'c6defd74b8e095e102e4d85d4cb665556ebdcee4',
            'tiger192,3' => '12e282f9d48c075101b08998938b25ee2f710e1796169a03',
            'tiger128,4' => 'ac1ae0518df4db48f0631a618a43a456',
            'tiger160,4' => '13282745d8e33ec9f6522d5e0b7fc26e94f9bd4f',
            'tiger192,4' => '8496f83b653964fbd334dd7bff68c1b0214391aa32eaf26d',
            'snefru'     => 'ec5f5e435964173761c6f3e9f8b4859fda45f249c86fc4558605dc6ae20e56c0',
            'gost'       => 'eb8f19dd744e54a33f79c70875fd2df909a31af17eff3e3ad2de650ce97061fc',
            'adler32'    => '0b3502a5',
            'crc32'      => 'ef979417',
            'crc32b'     => 'cdede4d1',
            'haval128,3' => '93a1c1d56fc75f9fb3b5d59a5bf80405',
            'haval160,3' => '56e5e9c65b225828b158033c4fc1c847de35ca92',
            'haval192,3' => '7f3cff6684c236762f25b8153c16cc8ae7e31f7ae2421a03',
            'haval224,3' => '4846c603c97cbde7c8363ae265705f16db9b1aa7455f4286f82c4ad2',
            'haval256,3' => '6bb591791718caf302e06e3addd0b7ca7b08fa533776125c2f54879648ffec3d',
            'haval128,4' => '0bcd022b84c0629fcfc1bdf0909d6224',
            'haval160,4' => 'f93894f9726510e2ba1fe40a6dda724992a7fe0c',
            'haval192,4' => 'dcf11cc59b56ab2529f4cf6b65bb4407af28f4c323a73d4d',
            'haval224,4' => 'f87f8aa73db0b68708ce9a8e41f492dfedfe4365b6b909e03472921d',
            'haval256,4' => 'f2f27c3dba5b12d49087002765c09d4064bb21a4a03386d01e4f2f038252abd2',
            'haval128,5' => '708c64d8340d2b22bb8f98326fe979cb',
            'haval160,5' => 'cd68854da71da4fb4a7e998a20f0bdcd120719dc',
            'haval192,5' => '646d1ebbfa62d357aee0ccce8783bc79323fed22f8920277',
            'haval224,5' => '086b5dd1e97f48c29e5978116aeeaa494935d77ff875bea6b1a64253',
            'haval256,5' => 'b64d24773e48edf5950b68dac86f2a974c0d390f2bb7cbc1ae6c1238867af799',        ];
        $data  = 'hello';
        $case  = 1;
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
    public function testHmacHash( $case, $algorithm, $data, $expected ) {
        $FMT = '%s Error in case #%d, algorithm: %s, hash: %s';

        switch( $algorithm ) {
            case HmacHashFactory::MD5 :
                $hash = HmacHashFactory::generateMd5( $data, self::getSecret() );
                break;
            case HmacHashFactory::SHA224 :
                $hash = HmacHashFactory::generateSha224( $data, self::getSecret() );
                break;
            case HmacHashFactory::SHA256 :
                $hash = HmacHashFactory::generateSha256( $data, self::getSecret() );
                break;
            case HmacHashFactory::SHA384 :
                $hash = HmacHashFactory::generateSha384( $data, self::getSecret() );
                break;
            case HmacHashFactory::SHA512 :
                $hash = HmacHashFactory::generateSha512( $data, self::getSecret() );
                break;
            case HmacHashFactory::RIPEMD160 :
                $hash = HmacHashFactory::generateRipemd160( $data, self::getSecret() );
                break;
            default :
                $hash = HmacHashFactory::generate( $algorithm, $data, self::getSecret() );
                break;
        }

        $this->assertTrue(
            HmacHashFactory::hashEquals( $expected, $hash ),
            sprintf( $FMT, self::getCm( __METHOD__ ), $case, $algorithm, $hash )
        );
    }

    /**
     * testHmacHashFile dataProvider
     * @return array
     */
    public function HashFileProvider() {
        $dataArr = [];

        $algoHash = [
            'md2'        => '0911eeeb433585f1af233c9cfb2a2628',
            'md4'        => 'edede12d8b3cc1e3c411dbcba983b692',
            'md5'        => 'e894ef633c219bed585bdfe0155bbb56',
            'sha1'       => '38146f330e11a06c5f5cc776d9766d7a60c3d5f3',
            'sha224'     => '2b3902218c206883b17c2adfff5abeb595fb5980b9f2469a1fd6b023',
            'sha256'     => '0d83a1a8d28fefb954108de98f33ce4f6b8775e01710dcdfe32db5780e283265',
            'sha384'     => '748160bba4f96302c31efc4d951718c5b89245e500d6abb3d715d6ef33acf5267b6484a98bef0d72183499e705aab5ab',
            'sha512'     => '51a497adf7a4266edf3f22708c149f99fb592f49d4a2e7ee5c292efac9c4430344425f95dfa858508f3aaa8c684cf44cf3222217bb597188dce1a72b4b662bf8',
            'ripemd128'  => 'ec5d386b29395578cf35e043807ffc7c',
            'ripemd160'  => '84a782fdbb695749bf8edf3aeb76b834534a411d',
            'ripemd256'  => '64391c617fa78057e8b1fcb51505698dc965942d89f06af8a10550cbeaa0df61',
            'ripemd320'  => 'fd0950d38b0781705735353eb5e47a29c958f995f9cc17e87baf233ac12b0b863e942c59be810d2b',
            'whirlpool'  => 'ab8aaa7b686ee70008bd8dcceeceaf973d9659f5541cc15759edb992d6df96c8095454b23db421306a98917e32b0ca82a4b609d8fe61587f6454b1ffecd5f62c',
            'tiger128,3' => '63e7439d6069be265141263597710465',
            'tiger160,3' => '34faf11dc46801491bac9b6f466bd9e3ddc45635',
            'tiger192,3' => '99ad01283b02800d6fae84f685d59a5846764f4bcba90737',
            'tiger128,4' => '31e6233bf54260dd3795e6b4a381bb2f',
            'tiger160,4' => '8f407ff43e4aa9482bfd26d017c6a816ea668498',
            'tiger192,4' => '5bc2fb1b97002c4cc3166f69c09207fb15ab37ec7a85b0c5',
            'snefru'     => 'ecff69fa2f94d475578eb4f2cf270a266a6ffcd0d1f8bccb9defb7c4aa7ab8be',
            'gost'       => '6f0a0df8fb5090f11942090dda7411bda3e1f27a8edda3dcb6e93b0f190843da',
            'adler32'    => '09bd01b6',
            'crc32'      => '431f5bcb',
            'crc32b'     => 'a92e98d2',
            'haval128,3' => 'dc6017e44e4141568322a5e9be156236',
            'haval160,3' => '9636751bc9e5713c91761f885b761b6db1a3d398',
            'haval192,3' => '5893272b44425508cdcfb019477d6b96c040e7dd34f60f6f',
            'haval224,3' => '54a1aab59e89fffd5af89bb5851f772a778e04a240523509c55200ab',
            'haval256,3' => 'b524b9790ae6f03237d6f235600d3f8b997a60802ca606240a7293fe30511a49',
            'haval128,4' => '5ca8dcc4f1b3a3a189417dfae5099e7d',
            'haval160,4' => 'ac5df5a686cb3d266efbbaf25eab3df176be949f',
            'haval192,4' => '8860e9190d1239aae09a804e1cf61b5414ed2266d5322ce7',
            'haval224,4' => 'bd1e1df7d92ea3e23401d085d6c54057fad53b707086a1df21b56dc4',
            'haval256,4' => '50a064eb0d5d3401aafb6f9f1ed5a534056ce99aa349ef4778bff33444313665',
            'haval128,5' => 'c6ba661627bc66d862663bbafe8c9fe5',
            'haval160,5' => 'fa1275b4485138629d047234aa4b0cabda60c639',
            'haval192,5' => 'ae2644212eb814e5ae2c72b7273c18ea36ca8d4eabbff47c',
            'haval224,5' => '4ef7a9a34a5336e0706778af8cb425f851bf48855ff6a37f76d2431d',
            'haval256,5' => '4fa31bddcb9b725c5e7fa8fd78f8f8424b3c506d404806657c02792cc3214e6c',
        ];
        $data  = 'hello';
        $case  = 1;
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
    public function testHmacHashFile( $case, $algorithm, $data, $expected ) {
        static $TEST = 'test';
        static $FMT  = '%s Error in case #%d, algorithm: %s, hash: %s';

        $file = DIRECTORY_SEPARATOR .
            trim( sys_get_temp_dir(), DIRECTORY_SEPARATOR ) .
            DIRECTORY_SEPARATOR . $TEST;
        file_put_contents( $file, $data );
        CommonFactory::assertFileName( $file );

        switch( $algorithm ) {
            case HmacHashFactory::MD5 :
                $hash = HmacHashFactory::generateFileMd5( $file, self::getSecret() );
                break;
            case HmacHashFactory::SHA224 :
                $hash = HmacHashFactory::generateFileSha224( $file, self::getSecret() );
                break;
            case HmacHashFactory::SHA256 :
                $hash = HmacHashFactory::generateFileSha256( $file, self::getSecret() );
                break;
            case HmacHashFactory::SHA384 :
                $hash = HmacHashFactory::generateFileSha384( $file, self::getSecret() );
                break;
            case HmacHashFactory::SHA512 :
                $hash = HmacHashFactory::generateFileSha512( $file, self::getSecret() );
                break;
            case HmacHashFactory::RIPEMD160 :
                $hash = HmacHashFactory::generateFileRipemd160( $file, self::getSecret() );
                break;
            default :
                $hash = HmacHashFactory::generateFile( $algorithm, $file, self::getSecret() );
                break;
        }
        unlink( $file );

        $this->assertTrue(
            HmacHashFactory::hashEquals( $expected, $hash ),
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
            1,
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
            $result = HmacHashFactory::generateFile( $algorithm, $fileName, 'secret' );
        }
        catch( Exception $e ) {
            $outcome = false;
        }

        $this->assertFalse( $outcome, sprintf( $FMT, self::getCm( __METHOD__ ), $case ));
    }

    /**
     * testOauthTotp dataProvider
     * @return array
     */
    public function oauthTotpProvider() {
        $dataArr = [];

        $algoHash = [
            'md2'        => '0000000582259851',
            'md4'        => '0000002002753749',
            'md5'        => '0000001000175228',
            'sha1'       => '0000001681981013',
            'sha256'     => '0000001053049589',
            'sha384'     => '0000001466119322',
            'sha512'     => '0000002112887971',
            'ripemd128'  => '0000000854691662',
            'ripemd160'  => '0000001436037858',
            'ripemd256'  => '0000001949176770',
            'ripemd320'  => '0000000431168000',
            'whirlpool'  => '0000001391494533',
            'tiger128,3' => '0000000000000111',
            'tiger160,3' => '0000001570221234',
            'tiger192,3' => '0000000441565498',
            'tiger128,4' => '0000000515646332',
            'tiger160,4' => '0000002088352188',
            'tiger192,4' => '0000001405412832',
            'snefru'     => '0000001661822588',
            'gost'       => '0000002086446154',
            'adler32'    => '0000000000000000',
            'crc32'      => '0000000000000000',
            'crc32b'     => '0000001984903888',
            'haval128,3' => '0000002127729076',
            'haval160,3' => '0000000208786966',
            'haval192,3' => '0000001370849182',
            'haval224,3' => '0000001884673836',
            'haval256,3' => '0000001824628811',
            'haval128,4' => '0000001842114244',
            'haval160,4' => '0000001276770288',
            'haval192,4' => '0000001991363162',
            'haval224,4' => '0000001252128262',
            'haval256,4' => '0000001826511896',
            'haval128,5' => '0000001606893225',
            'haval160,5' => '0000001464791670',
            'haval192,5' => '0000000383802141',
            'haval224,5' => '0000001158646636',
            'haval256,5' => '0000000618153595',
        ];
        $data   = 'hello';
        $case   = 1;
        $time   = 1558286894;
        $digits = 16;
        foreach( $algoHash as $algorithm => $hash ) {
            $dataArr[] = [
                $case++,
                self::$phrase,
                $time,
                $digits,
                $algorithm,
                $hash,
            ];
        }

        return $dataArr;
    }

    /**
     * @test
     * @dataProvider oauthTotpProvider
     * @param int    $case
     * @param string $algorithm
     * @param string $data
     * @param string $expected
     */
    public function testOauthTotp( $case, $data, $time, $digits, $algorithm, $expected ) {
        static $FMT  = '%s Error in case #%d, algorithm: %s, hash: %s';

        $hash = HmacHashFactory::oauth_totp( $data, $time, $digits, $algorithm );

        $this->assertTrue(
            HmacHashFactory::hashEquals( $expected, $hash ),
            sprintf( $FMT, self::getCm( __METHOD__ ), $case, $algorithm, $hash )
        );
    }

    /**
     * @test
     */
    public function testOauthTotp2() {
        static $FMT  = '%s Error in case #%d, algorithm: %s, hash: %s';

        $data   = 'hello';
        $time   = 1558286894;
        $digits = 16;
        $sha256 = '0000000952491788';

        $hash   = HmacHashFactory::oauth_totp( $data, $time, $digits );

        $this->assertTrue(
            HmacHashFactory::hashEquals( $sha256, $hash ),
            sprintf( $FMT, self::getCm( __METHOD__ ), 1, HmacHashFactory::SHA256, $hash )
        );
    }

}
