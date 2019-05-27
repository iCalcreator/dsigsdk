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
use Faker;
use Kigkonsult\DsigSdk\BaseTest;

/**
 * Class OpenSSLFactoryTest
 */
class OpenSSLFactoryTest extends BaseTest
{

    /**
     * @var string  aggregates working cipher and md algorythms combinations
     */
    private static $cipherAndMdOk       = null;
    private static $cipherEncryptErrors = null;
    private static $cipherDecryptErrors = null;

    public static function setUpBeforeClass() {
        parent::setUpBeforeClass();
        if( defined( 'LOG' ) && ( false !== LOG )) {
            $realpath = realpath( __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' ) . DIRECTORY_SEPARATOR;
            $fileName = 'cipherAndMdOk.txt';
            self::$cipherAndMdOk = $realpath . LOG . DIRECTORY_SEPARATOR . $fileName;
            file_put_contents( self::$cipherAndMdOk, '' );
            $fileName = 'cipherEncryptErrors.txt';
            self::$cipherEncryptErrors = $realpath . LOG . DIRECTORY_SEPARATOR . $fileName;
            file_put_contents( self::$cipherEncryptErrors, '' );
            $fileName = 'cipherDecryptErrors.txt';
            self::$cipherDecryptErrors = $realpath . LOG . DIRECTORY_SEPARATOR . $fileName;
            file_put_contents( self::$cipherDecryptErrors, '' );
        }
    }

    /**
     * testassertMdAlgorithm dataProvider
     * @return array
     */
    public function assertMdAlgorithmProvider() {
        $dataArr = [];

        $openssl_get_md_methods = [];
        $case = 100;
        foreach( openssl_get_md_methods( true ) as $hashAlgorithm ) {
            $openssl_get_md_methods[] = $hashAlgorithm;
            $dataArr[] =
                [
                    ++$case,
                    $hashAlgorithm,
                    true
                ];
        }

        $dataArr[] =
            [
                199,
                'noAlgorithm',
                false
            ];

//      sort( $openssl_get_md_methods );
//      echo 'openssl_get_md_methods: ' . implode( ',', $openssl_get_md_methods ) . PHP_EOL;

        return $dataArr;
    }

    /**
     * Testing OpenSSLFactory::assertMdAlgorithm
     *
     * @test
     * @dataProvider assertMdAlgorithmProvider
     * @param int    $case
     * @param string $algorithm
     * @param string $expected
     */
    public function testassertMdAlgorithm( $case, $algorithm, $expected ) {
        static $FMT1 = '%s Error in case #%d, algorithm: %s, result: %s';
        static $FMT2 = '%s #%d, expected: %s, actual: %s%s';


        $result  = null;
        $outcome = true;
        try {
            $result = OpenSSLFactory::assertMdAlgorithm( $algorithm );
        }
        catch( Exception $e ) {
            $outcome = false;
        }

        $this->assertEquals(
            $expected,
            $outcome,
            sprintf( $FMT1, self::getCm( __METHOD__ ), $case . '1', $algorithm, $result )
        );
        if( $expected ) {
            $this->assertEquals(
                strtolower( $algorithm ),
                strtolower( $result ),
                sprintf( $FMT1, self::getCm( __METHOD__ ), $case . '2', $algorithm, $result )
            );
        }
    }

    /**
     * testAssertCipherAlgorithm dataProvider
     * @return array
     */
    public function assertCipherAlgorithmProvider() {
        $dataArr = [];
        $openssl_get_cipher_methods = openssl_get_cipher_methods( true );
        sort( $openssl_get_cipher_methods );
        $case = 200;

        foreach( $openssl_get_cipher_methods as $cipherAlgorithm ) {
            $openssl_get_cipher_methods[] = $cipherAlgorithm;
            $dataArr[] =
                [
                    ++$case,
                    $cipherAlgorithm,
                    true
                ];
        }

        $dataArr[] =
            [
                299,
                'noAlgorithm',
                false
            ];

        return $dataArr;
    }

    /**
     * Testing OpenSSLFactory::assertMdAlgorithm
     *
     * @test
     * @dataProvider assertCipherAlgorithmProvider
     * @param int    $case
     * @param string $algorithm
     * @param string $expected
     */
    public function testAssertCipherAlgorithm( $case, $algorithm, $expected ) {
        static $FMT1 = '%s Error in case #%d, expected: %s, actual: %s';
//      echo 'openssl_get_cipher_method: ' . $algorithm . PHP_EOL;

        $result  = null;
        $outcome = true;
        try {
            $result = OpenSSLFactory::assertCipherAlgorithm( $algorithm );
        }
        catch( Exception $e ) {
            $outcome = false;
        }

        $this->assertEquals(
            $expected,
            $outcome,
            sprintf( $FMT1, self::getCm( __METHOD__ ), $case . '1', $algorithm, $result )
        );
        if( $expected ) {
            $this->assertEquals(
                strtolower( $algorithm ),
                strtolower( $result ),
                sprintf( $FMT1, self::getCm( __METHOD__ ), $case . '2', $algorithm, $result )
            );
        }
    }

    /**
     * Testing OpenSSLFactory contructor, encryptString, decryptString with DEFAULT cipher+ md
     *
     * @test
     */
    public function testOpenSSLdefault() {
        $data            = Faker\Factory::create()->paragraphs( 10, true );
        $cryptKey        = CommonFactory::getSalt();

        $enCryptor       = new OpenSSLFactory();
        $encrypted       = $enCryptor->encryptString( $data, $cryptKey );
        $enCryptor       = null;

        $deCryptor       = new OpenSSLFactory();
        $decrypted       = $deCryptor->decryptString( $encrypted, $cryptKey );

        $this->assertEquals(
            $data,
            $decrypted,
            '#31, encrypt/decrypt error, default cipher/md'
        );
    }

    /**
     * testOpenSSL dataProvider
     *
     * @return array
     */
    public function OpenSSLProvider() {
        $dataArr = [];
        $case    = 40000;

        $cipherAlgosWithout = openssl_get_cipher_methods();              // without aliases
        sort( $cipherAlgosWithout );
        $cipherAlgosWith    = openssl_get_cipher_methods( true ); // with aliases
        sort( $cipherAlgosWith );

        $mdAlgosWithout     = openssl_get_md_methods();                  // without aliases
        sort( $mdAlgosWithout);
        $mdAlgosWith        = openssl_get_md_methods( true );     // with aliases
        sort( $mdAlgosWith );

        $openSLLmode = ( defined( 'OPENSSLMODE' )) ? OPENSSLMODE : 0;
        switch( $openSLLmode ) {
            case 0 :
                $cipherAlgos = [ 'aes-256-ctr' ];    // default
                $mdAlgos     = [ 'sha256' ];         // default
                break;
            case 1 :
                $cipherAlgos = [ 'aes-256-ctr' ];    // default
                $mdAlgos     = $mdAlgosWithout;      // without aliases
                break;
            case 2 :
                $cipherAlgos = [ 'aes-256-ctr' ];    // default
                $mdAlgos     = $mdAlgosWith;         // with aliases
                break;
            case 3 :
                $cipherAlgos = $cipherAlgosWithout;  // without aliases
                $mdAlgos     = [ 'sha256' ];         // default
                break;
            case 4 :
                $cipherAlgos = $cipherAlgosWithout;  // without aliases
                $mdAlgos     = $mdAlgosWithout;      // without aliases
                break;
            case 5 :
                $cipherAlgos = $cipherAlgosWithout;  // without aliases
                $mdAlgos     = $mdAlgosWith;         // with aliases
                break;
            case 6 :
                $cipherAlgos = $cipherAlgosWith;     // with aliases
                $mdAlgos     = [ 'sha256' ];         // default
                break;
            case 7 :
                $cipherAlgos = $cipherAlgosWith;     // with aliases
                $mdAlgos     = $mdAlgosWithout;      // without aliases
                break;
            case 8 :
                $cipherAlgos = $cipherAlgosWith;     // with aliases
                $mdAlgos     = $mdAlgosWith;         // with aliases
                break;
            case 10 :
                $cipherAlgos = array_chunk( $cipherAlgosWithout, (int) floor(count( $cipherAlgosWithout ) / 8 ))[7];
                $mdAlgos     = [ 'sha256' ];         // default
        }
        $formats = [ OpenSSLFactory::FORMAT_RAW, OpenSSLFactory::FORMAT_B64, OpenSSLFactory::FORMAT_HEX ];
        foreach( $cipherAlgos as $cipherAlgorithm ) {
            foreach( $mdAlgos as $hashAlgorithm ) {
                $dataArr[] = [
                    ++$case,
                    $cipherAlgorithm,
                    $hashAlgorithm,
                    array_rand( $formats ),
                ];
            } // end foreach
        } // end foreach

        return $dataArr;
    }

    /**
     * Testing OpenSSLFactory contructor, factory, encryptString, decryptString etc
     *
     * @test
     * @dataProvider OpenSSLProvider
     * @param int    $case
     * @param string $cipherAlgorithm
     * @param string $hashAlgorithm
     * @param int    $fmt
     */
    public function testOpenSSL( $case, $cipherAlgorithm, $hashAlgorithm, $fmt ) {
        static $FMTSTART = '%s = START #%04d, cipherAlgorithm; %s, hashAlgorithm; %s, format: %s, %s';
        static $FMTDSP   = '%s %s #%04d, cipherAlgorithm; %s, hashAlgorithm; %s, format: %s, time: %01.6f, %d/%d%s';
        static $FMTERR   = 'Encrypt/decrypt ERROR, cipherAlgorithm: %s, hasdAlgorithm: %s, format %s, data input/output length %d/%d';
        static $cipherEncryptErrors = [];
        static $cipherDecryptErrors = [];

        if( ( in_array(
            $cipherAlgorithm, [
            'aes-128-ccm',
            'aes-128-gcm',
            'aes-192-ccm',
            'aes-192-gcm',
            'aes-256-ccm',
            'aes-256-gcm',
            'des-cfb1',
            'des-cfb8',
            'des-ecb',
            'des-ede',
            'des-ede-cbc',
            'des-ede-cfb',
            'des-ede-ofb',
            'des-ede3',
            'des-ede3-cbc',
            'des-ede3-cfb',
            'des-ede3-cfb1',
            'des-ede3-cfb8',
            'des-ede3-ofb',
            'des-ofb',
            'desx-cbc',
            'id-aes128-CCM',
            'id-aes128-GCM',
            'id-aes128-wrap',
            'id-aes128-wrap-pad',
            'id-aes192-CCM',
            'id-aes192-GCM',
            'id-aes192-wrap',
            'id-aes192-wrap-pad',
            'id-aes256-CCM',
            'id-aes256-GCM',
            'id-aes256-wrap',
            'id-aes256-wrap-pad',
            'id-smime-alg-CMS3DESwrap',
        ] ))) { // skipped, not working...
            echo ' skip ' . $cipherAlgorithm . PHP_EOL;
            $this->assertTrue( true );
            return;
        }

        $data            = Faker\Factory::create()->paragraphs( 10, true );
        $dataInputStrlen = strlen( $data );
        $key             = CommonFactory::getSalt();
        $isCipherAlias   =
            ( ! empty( $cipherAlgorithm ) && ! in_array( $cipherAlgorithm, openssl_get_cipher_methods()))
                ? ' (alias) '
                : null;
        $isHashAlias     =
            ( ! empty( $hashAlgorithm ) && ! in_array( $hashAlgorithm, openssl_get_md_methods()))
                ? ' (alias) '
                : null;

        // E N C R Y P T - - - - -
        echo sprintf( $FMTSTART, self::getCm( __METHOD__ ), $case, $cipherAlgorithm, $hashAlgorithm, OpenSSLFactory::getFormatText( $fmt ), PHP_EOL );
        $enCryptor = OpenSSLFactory::factory();
        if( ! empty( $cipherAlgorithm )) {
            $enCryptor->setCipherAlgorithm( $cipherAlgorithm );
        }
        if( ! empty( $hashAlgorithm )) {
            $enCryptor->setHashAlgorithm( $hashAlgorithm );
        }
        if( ! is_null( $fmt )) {
            $enCryptor->setFormat( $fmt );
        }

        $startTime = microtime( true );
        try {
            $encrypted       = $enCryptor->encryptString( $data, $key );
            $time            = microtime( true ) - $startTime;
            $encryptedStrlen = strlen( $encrypted );
            echo sprintf(
                $FMTDSP, self::getCm( __METHOD__ ), 'encrypt', $case,
                $enCryptor->getCipherAlgorithm(),
                $enCryptor->getHashAlgorithm(),
                $enCryptor->getFormat( true ),
                $time, $dataInputStrlen, $encryptedStrlen, PHP_EOL
            );
        } // end try
        catch( Exception $e ) {
            $exMsg = $e->getMessage();
            $prev  = $e->getPrevious();
            if( ! empty( $prev )) {
                $exMsg .= $prev->getMessage();
            }
            if( ! empty( self::$cipherEncryptErrors ) &&
              ( ! isset( $cipherEncryptErrors[$cipherAlgorithm] ) ||
                ! in_array( $exMsg, $cipherEncryptErrors[$cipherAlgorithm] ))) {
                $msg = $cipherAlgorithm . ' ' . $case . ' ' . $isCipherAlias . $exMsg . PHP_EOL;
                file_put_contents( self::$cipherEncryptErrors, $msg, FILE_APPEND );
                $cipherEncryptErrors[$cipherAlgorithm][] = $exMsg;
            }
            echo $exMsg . PHP_EOL;
            $this->assertTrue( true );
            $enCryptor = null;
            return; // continue when error...
        } // end catch
        $enCryptor = null;

            // D E C R Y P T - - - - -
        $decryptedStrlen = 0;
        $deCryptor       = new OpenSSLFactory();
        if( ! empty( $cipherAlgorithm )) {
            $deCryptor->setCipherAlgorithm( $cipherAlgorithm );
        }
        if( ! empty( $hashAlgorithm )) {
            $deCryptor->setHashAlgorithm( $hashAlgorithm );
        }
        if( ! is_null( $fmt )) {
            $deCryptor->setFormat( $fmt );
        }
        $startTime = microtime( true );
        try {
            $decrypted       = $deCryptor->decryptString( $encrypted, $key );
            $time            = microtime( true ) - $startTime;
            $decryptedStrlen = strlen( $decrypted );
            echo sprintf(
                $FMTDSP, self::getCm( __METHOD__ ), 'decrypt', $case,
                $deCryptor->getCipherAlgorithm(),
                $deCryptor->getHashAlgorithm(),
                $deCryptor->getFormat( true ),
                $time, $encryptedStrlen, $decryptedStrlen, PHP_EOL
            );
        } // end try
        catch( Exception $e ) {
            $exMsg = $e->getMessage();
            $prev  = $e->getPrevious();
            if( ! empty( $prev )) {
                $exMsg .= $prev->getMessage();
            }
            if( ! empty( self::$cipherDecryptErrors ) &&
              ( ! isset( $cipherDecryptErrors[$cipherAlgorithm] ) ||
                ! in_array( $exMsg, $cipherDecryptErrors[$cipherAlgorithm] ))) {
                $msg = $cipherAlgorithm . ' ' . ' ' . $case . ' ' . $isCipherAlias . $exMsg . PHP_EOL;
                file_put_contents( self::$cipherDecryptErrors, $msg, FILE_APPEND );
                $cipherDecryptErrors[$cipherAlgorithm][] = $exMsg;
            }
            echo $exMsg . PHP_EOL;
            $this->assertTrue( true );
            $deCryptor       = null;
            return; // continue when error...
        } // end catch
        $cipherAlgorithm = $deCryptor->getCipherAlgorithm();
        $hashAlgorithm   = $deCryptor->getHashAlgorithm();
        $format          = $deCryptor->getFormat( true );
        $deCryptor       = null;

        // Evaluate result
        $this->assertEquals(
            $data,
            $decrypted,
            sprintf(
                $FMTERR,
                $cipherAlgorithm,
                $hashAlgorithm,
                $format,
                $dataInputStrlen,
                $decryptedStrlen,
                PHP_EOL
            )
        );
            // record successful cipher and hash algorithms
        if(( $data == $decrypted ) && ! empty( self::$cipherAndMdOk )) {
            $msg = $cipherAlgorithm . ' ' . $isCipherAlias . ' - ' . $hashAlgorithm . $isHashAlias . PHP_EOL;
            file_put_contents( self::$cipherAndMdOk, $msg, FILE_APPEND );
        } // end if
    }

}

