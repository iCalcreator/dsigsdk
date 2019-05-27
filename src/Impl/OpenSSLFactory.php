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
 *
 * Disclaimer of rights
 *
 *           Substantial portion of software below, originates from
 *             https://github.com/ioncube/php-openssl-cryptor,
 *           available under the MIT License.
 *
 *           copyright  2016 ionCube Ltd.
 *
 *           Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 *           and associated documentation files (the "Software"), to deal in the Software without restriction,
 *           including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 *           and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 *           subject to the following conditions:
 *
 *           The above copyright notice and this permission notice shall be included in all copies or substantial
 *           portions of the Software.
 *
 *           THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 *           INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE
 *           AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 *           DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *           OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 *
 *           Herein may exist software logic (hereafter solution(s))
 *           found on internet (hereafter originator(s)).
 *           The rights of each solution belongs to respective originator;
 *
 *           Credits and acknowledgements to originators!
 *           Links to originators are found wherever appropriate.
 *
 *           Only DsigSdk copyright holder works, DsigSdk author(s) works and solutions derived works
 *           and collection of solutions are covered by GNU Lesser General Public License, above.
 */
namespace Kigkonsult\DsigSdk\Impl;

use Exception;
use InvalidArgumentException;
use Kigkonsult\LoggerDepot\LoggerDepot;
use Psr\Log\LogLevel;
use RuntimeException;

use function is_null;
use function in_array;
use function ltrim;
use function openssl_cipher_iv_length;
use function openssl_decrypt;
use function openssl_digest;
use function openssl_encrypt;
use function restore_error_handler;
use function set_error_handler;
use function sprintf;
use function strlen;
use function substr;

/**
 * Class OpenSSLFactory
 *
 * Wrapper for OpenSSL : openssl_decrypt, openssl_encrypt, openssl_digest, openssl_cipher_iv_length
 * Require a Psr\Log logger, provided by LoggerDepot
 */
class OpenSSLFactory extends OpenSSLBase
{

    /** ***********************************************************************
     * Software below originates from
     * https://github.com/ioncube/php-openssl-cryptor
     * @copyright 2016 ionCube Ltd.
     * @license MIT - ionCube Ltd
     * @license LGPL - derived works
     ** ******************************************************************** */

    /**
     * Format constants
     */
    const FORMAT_RAW = 0;
    const FORMAT_B64 = 1;
    const FORMAT_HEX = 2;

    /**
     * @var array
     * @access private
     */
    private static $FORMATS = [ self::FORMAT_RAW => 'raw', self::FORMAT_B64 => 'base64', self::FORMAT_HEX => 'hex' ];

    /**
     * Assert format
     *
     * @param int $format
     * @throws InvalidArgumentException
     */
    private static function assertFormat( $format ) {
        $FMTERR2 = 'Invalid format \'%s\'';
        if( ! in_array( $format, array_keys( self::$FORMATS ))) {
            throw new InvalidArgumentException( sprintf( $FMTERR2, $format ));
        }
    }

    /**
     * Return format text
     *
     * @param string $format
     * @return string
     */
    public static function getFormatText( $format ) {
        self::assertFormat( $format );
        return self::$FORMATS[$format];
    }
    
    /**
     * @var string  Algorithm defaults
     */
    private static $cipherAlgorithmDefault = 'aes-256-ctr';
    private static $hashAlgorithmDefault   = 'sha256';

    /**
     * @var string
     * @access private
     */
    private $cipherAlgorithm;

    /**
     * @var string
     * @access private
     */
    private $hashAlgorithm;

    /**
     * @var int
     * @access private
     */
    private $initializationVectorNumBytes;

    /**
     * @var string
     * @access private
     */
    private $format;

    /**
     * @var string
     * @access private
     * @static
     */
    private static $FMTENCTXT   = ' Set encoding for encrypted data : ';
    private static $FMTCIPHER   = ' Set cipherAlgorithm: ';
    private static $FMTHASHALGO = ' Set hashAlgorithm: ';
    private static $FMTIVTXT    = ' InitializationVector length: ';
    private static $FMTKHTXT    = ' KeyHash length: ';
    private static $FMTSTART    = 'START %s, input data length: %d';
    private static $FMTEND      = 'END %s input/output byte length: %d/%d, time: %01.6f';

    /**
     * Class constructor
     *
     * @param string $cipherAlgorithm     The cipher algorithm
     *                                    default aes256 encryption
     * @param string $hashAlgorithm       Key hashing algorithm
     *                                    default sha256 key hashing
     * @param int    $encryptedEncoding   Format of the encrypted data
     *                                    one of FORMAT_RAW, FORMAT_B64 or FORMAT_HEX
     *                                    default base64 encoding
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function __construct( $cipherAlgorithm = null, $hashAlgorithm = null, $encryptedEncoding = null ) {
        static $FMTSTART1  = 'START %s';
        static $FMTINITOUT = 'Init %s, %s, cipher: %s, hash: %s, format: %s ';
        $this->logger = LoggerDepot::getLogger( get_class());
        $this->log(
            LogLevel::DEBUG,
            str_pad( sprintf( $FMTSTART1, OPENSSL_VERSION_TEXT ), 80, '  --' )
        );
        if( empty( $cipherAlgorithm )) {
            $this->cipherAlgorithm              = self::assertCipherAlgorithm( self::$cipherAlgorithmDefault );
            $this->initializationVectorNumBytes = $this->DoOpensslCipherIvLength( $this->cipherAlgorithm );
        }
        else {
            $this->setCipherAlgorithm( $cipherAlgorithm );
        }
        if( empty( $hashAlgorithm )) {
            $this->hashAlgorithm = self::assertMdAlgorithm( self::$hashAlgorithmDefault );
        }
        else {
            $this->hashAlgorithm = $this->setHashAlgorithm( $hashAlgorithm );
        }
        if( empty( $encryptedEncoding )) {
            $this->format = self::FORMAT_B64;
        }
        else {
            $this->setFormat( $encryptedEncoding );
        }
        $this->log(
            LogLevel::INFO,
            sprintf(
                $FMTINITOUT, self::class, OPENSSL_VERSION_TEXT, $this->cipherAlgorithm, $this->hashAlgorithm, self::getFormatText( $this->format )
            )
        );

    }

    /**
     * Class factory method
     *
     * @param string  $cipherAlgorithm    The cipher algorithm, default aes256 encryption
     * @param string  $hashAlgorithm      Key hashing algorithm, default sha256 key hashing
     * @param int     $encryptedEncoding  Format of the encrypted data
     *                                    one of FORMAT_RAW, FORMAT_B64 or FORMAT_HEX
     * @return static
     * @throws InvalidArgumentException
     * @access static
     */
    public static function factory( $cipherAlgorithm = null, $hashAlgorithm = null, $encryptedEncoding = null ) {
        return new self( $cipherAlgorithm, $hashAlgorithm, $encryptedEncoding );
    }

    /**
     * Class destructor
     */
    public function __destruct() {
        unset(
            $this->cipherAlgorithm,
            $this->initializationVectorNumBytes,
            $this->hashAlgorithm,
            $this->format
        );
    }

    /**
     * Return Encrypted string.
     *
     * @param  string $data            String to encrypt.
     * @param  string $encryptKey      Encryption key.
     * @param int $outputEncoding      Optional override for the output encoding
     *                                 one of FORMAT_RAW, FORMAT_B64 or FORMAT_HEX
     * @return string                  The encrypted string.
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function encryptString( $data, $encryptKey, $outputEncoding = null ) {
        static $FMTERR1 = 'Not a strong key';
        $this->log( LogLevel::DEBUG, sprintf( self::$FMTSTART, __FUNCTION__, strlen( $data )));
        $startTime = microtime( true );
        CommonFactory::assertString( $data, 1 );
        CommonFactory::assertString( $encryptKey, 2 );
        if( is_null( $outputEncoding) ) {
            $outputEncoding = $this->format;
        }
        else {
            $this->setFormat( $outputEncoding );
        }
        // Build an initialisation vector
        if( empty( $this->initializationVectorNumBytes )) {
            $initializationVector = '';
        }
        else {
            $initializationVector = CommonFactory::getRandomPseudoBytes(
                $this->initializationVectorNumBytes,
                $isStrongCrypto
            );
            if( ! $isStrongCrypto ) {
                throw new RuntimeException( $FMTERR1 );
            }
        }
        $this->log( LogLevel::DEBUG, 3 . self::$FMTIVTXT . strlen( $initializationVector ));
        // Hash the key
        $keyHash = $this->DoOpensslDigest( $encryptKey, $this->hashAlgorithm );
        $this->log( LogLevel::DEBUG, 4 . self::$FMTKHTXT . strlen( $keyHash ));
        // and encrypt
        $encrypted = $this->DoOpensslEncrypt(
            $data, $this->cipherAlgorithm, $keyHash, OPENSSL_RAW_DATA, $initializationVector
        );
        // The result comprises the IV and encrypted data
        $result = $initializationVector . $encrypted;
        // and format the result if required.
        switch( $outputEncoding ) {
            case self::FORMAT_B64 :
                $result = CommonFactory::base64Encode( $result );
                break;
            case self::FORMAT_HEX :
                $result = CommonFactory::HunPach( $result );
                break;
        }
        $this->log(
            LogLevel::INFO,
            sprintf( self::$FMTEND, __FUNCTION__, strlen( $data ), strlen( $result ), self::getExecTime( $startTime ))
        );
        return $result;
    }
    /**
     * Return decrypted string.
     *
     * @param  string $data        String to decrypt.
     * @param  string $decryptKey  Decryption key.
     * @param int $dataEncoding    Optional override for the input encoding,
     *                             one of FORMAT_RAW, FORMAT_B64 or FORMAT_HEX
     * @return string              The decrypted string.
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function decryptString( $data, $decryptKey, $dataEncoding = null ) {
        static $FMTERR1 = 'Data length (%d) is less than iv length %d';
        $this->log( LogLevel::DEBUG, sprintf( self::$FMTSTART, __FUNCTION__, strlen( $data )));
        $startTime      = microtime( true );
        CommonFactory::assertString( $data, 1 );
        CommonFactory::assertString( $decryptKey, 2 );
        if( is_null( $dataEncoding )) {
            $dataEncoding = $this->format;
        }
        else {
            self::assertFormat( $dataEncoding );
            $this->log( LogLevel::INFO, 2 . self::$FMTENCTXT . self::getFormatText( $dataEncoding ));
        }
        // Restore the encrypted data if encoded
        switch( $dataEncoding ) {
            case self::FORMAT_B64 :
                $raw = CommonFactory::base64Decode( $data );
                break;
            case self::FORMAT_HEX :
                $raw = CommonFactory::Hpach( $data );
                break;
            default :
                $raw = $data;
                break;
        }
        // and do an integrity check on the size.
        $strlenRaw = strlen( $raw );
        if( $strlenRaw < $this->initializationVectorNumBytes ) {
            throw new RuntimeException( sprintf( $FMTERR1, $strlenRaw, $this->initializationVectorNumBytes ));
        }
        // Extract the initialisation vector and encrypted data
        $initializationVector = substr( $raw, 0, $this->initializationVectorNumBytes );
        $this->log( LogLevel::DEBUG, 3 . self::$FMTIVTXT . strlen( $initializationVector ));
        $raw     = substr( $raw, $this->initializationVectorNumBytes );
        // Hash the key
        $keyHash = $this->DoOpensslDigest( $decryptKey, $this->hashAlgorithm );
        $this->log( LogLevel::DEBUG, 4 . self::$FMTKHTXT . strlen( $keyHash ));
        // and decrypt
        $result  = $this->DoOpensslDecrypt(
            $raw, $this->cipherAlgorithm, $keyHash, OPENSSL_RAW_DATA, $initializationVector
        );
        $this->log(
            LogLevel::INFO,
            sprintf( self::$FMTEND, __FUNCTION__, strlen( $data ), strlen( $result ), self::getExecTime( $startTime ))
        );
        return $result;
    }

    /**
     * Return openssl cipher initialization vector byte length
     *
     * @param string $cipherAlgorithm
     * @return int
     * @throws RuntimeException
     */
    private function DoOpensslCipherIvLength( $cipherAlgorithm ) {
        $FMTERR = 'initialization vector %s (#%d), byte length for cipherAlgorithm: %s, %s';
        self::clearOpenSSLErrors();
        $initializationVectorNumBytes = false;
        set_error_handler( self::$ERRORHANDLER );
        try {
            $initializationVectorNumBytes = openssl_cipher_iv_length( $cipherAlgorithm );
        }
        catch( Exception $e ) {
            $OpenSSLErrors = self::getOpenSSLErrors();
            $logLevel      = ( false !== $initializationVectorNumBytes ) ? LogLevel::WARNING : LogLevel::ERROR;
            $message       = sprintf( $FMTERR, $logLevel, 1, $cipherAlgorithm, $OpenSSLErrors);
            $this->log( $logLevel, $message );
            $this->log( $logLevel, $e->getMessage());
            if( false === $initializationVectorNumBytes ) {
                throw new RuntimeException( $message, null, $e );
            }
        }
        finally {
            restore_error_handler();
        }
        if( false === $initializationVectorNumBytes ) {
            $message = sprintf( $FMTERR, LogLevel::ERROR, 2, $cipherAlgorithm, self::getOpenSSLErrors());
            $this->log( LogLevel::ERROR, $message );
            throw new RuntimeException( $message );
        }
        return $initializationVectorNumBytes;
    }

    /**
     * Return hashed key
     *
     * @param string $key
     * @param string $hashAlgorithm
     * @return string
     * @throws RuntimeException
     */
    private function DoOpensslDigest( $key, $hashAlgorithm ) {
        static $FMTERR = 'Hashing digest key %s (#%d), hashAlgorithm: %s, %s';
        self::clearOpenSSLErrors();
        $keyHash = false;
        set_error_handler( self::$ERRORHANDLER );
        try {
            $keyHash = openssl_digest( $key, $hashAlgorithm, true );
        }
        catch( Exception $e ) {
            $OpenSSLErrors = self::getOpenSSLErrors();
            $logLevel      = ( false !== $keyHash ) ? LogLevel::WARNING : LogLevel::ERROR;
            $message       = sprintf( $FMTERR, $logLevel, 1, $hashAlgorithm, self::getOpenSSLErrors(), $OpenSSLErrors );
            $this->log( $logLevel, $message );
            $this->log( $logLevel, $e->getMessage());
            if( false === $keyHash ) {
                throw new RuntimeException( $message, null, $e );
            }
        }
        finally {
            restore_error_handler();
        }
        if( false === $keyHash ) {
            $message = sprintf(
                $FMTERR, LogLevel::ERROR, 2, $hashAlgorithm, self::getOpenSSLErrors(), self::getOpenSSLErrors()
            );
            $this->log( LogLevel::ERROR, $message );
            throw new RuntimeException( $message );
        }
        return $keyHash;
    }

    /**
     * Return openssl_encrypt-ed data
     *
     * @param string $data
     * @param string $cipherAlgorithm
     * @param string $keyHash
     * @param int    $opts
     * @param string $initializationVector
     * @return string
     * @throws RuntimeException
     */
    private function DoOpensslEncrypt( $data, $cipherAlgorithm, $keyHash, $opts, $initializationVector ) {
        static $FMTERR = 'Encryption %s (#%d), cipherAlgorithm: %s, keyHash length: %d (iv length: %d) %s';
        $encrypted = false;
        self::clearOpenSSLErrors();
        set_error_handler( self::$ERRORHANDLER );
        try {
            $encrypted = openssl_encrypt( $data, $cipherAlgorithm, $keyHash, $opts, $initializationVector );
        }
        catch( Exception $e ) {
            $OpenSSLErrors = self::getOpenSSLErrors();
            $logLevel      = ( false !== $encrypted ) ? LogLevel::WARNING : LogLevel::ERROR;
            $message = sprintf(
                $FMTERR,
                $logLevel,
                1,
                $cipherAlgorithm,
                strlen( $keyHash ),
                strlen( $initializationVector ),
                $OpenSSLErrors
            );
            $this->log( $logLevel, $message );
            $this->log( $logLevel, $e->getMessage());
            if( false === $encrypted ) {
                throw new RuntimeException( $message, null, $e );
            }
        }
        finally {
            restore_error_handler();
        }
        if( false === $encrypted ) {
            $message = sprintf(
                $FMTERR,
                LogLevel::ERROR,
                2,
                $cipherAlgorithm,
                strlen( $keyHash ),
                strlen( $initializationVector ),
                self::getOpenSSLErrors()
            );
            $this->log( LogLevel::ERROR, $message );
            throw new RuntimeException( $message );
        }
        return $encrypted;
    }

    /**
     * Return openssl_decrypted data
     *
     * @param string $raw
     * @param string $cipherAlgorithm
     * @param string $keyHash
     * @param int    $opts
     * @param int    $initializationVector
     * @return string
     * @throws RunTimeException
     */
    private function DoOpensslDecrypt( $raw, $cipherAlgorithm, $keyHash, $opts, $initializationVector ) {
        static $FMTERR = 'decryption %s (#%d), cipherAlgorithm: %s, keyHash length: %d, (iv length: %d) %s';
        $decrypted = false;
        self::clearOpenSSLErrors();
        set_error_handler( self::$ERRORHANDLER );
        try {
            $decrypted = openssl_decrypt( $raw, $cipherAlgorithm, $keyHash, $opts, $initializationVector );
        }
        catch( Exception $e ) {
            $OpenSSLErrors = self::getOpenSSLErrors();
            $logLevel      = ( false !== $decrypted ) ? LogLevel::WARNING : LogLevel::ERROR;
            $message       = sprintf(
                $FMTERR,
                $logLevel,
                1,
                $cipherAlgorithm,
                strlen( $keyHash ),
                strlen( $initializationVector ),
                $OpenSSLErrors
            );
            $this->log( $logLevel, $message );
            $this->log( $logLevel, $e->getMessage());
            if( false === $decrypted ) {
                throw new RuntimeException( $message, null, $e );
            }
        }
        finally {
            restore_error_handler();
        }
        if( false === $decrypted ) {
            $message = sprintf(
                $FMTERR,
                LogLevel::ERROR,
                2,
                $cipherAlgorithm,
                strlen( $keyHash ),
                strlen( $initializationVector ),
                self::getOpenSSLErrors()
            );
            $this->log( LogLevel::ERROR, $message );
            throw new RuntimeException( $message );
        }
        return $decrypted;
    }

    /** ***********************************************************************
     *  Getters and setters
     */

    /**
     * Return cipherAlgorithm
     * @return string
     */
    public function getCipherAlgorithm() {
        return $this->cipherAlgorithm;
    }

    /**
     * Set cipherAlgorithm
     *
     * @param string $cipherAlgorithm
     * @return static
     * @throws InvalidArgumentException
     */
    public function setCipherAlgorithm( $cipherAlgorithm ) {
        $this->cipherAlgorithm = self::assertCipherAlgorithm( CommonFactory::assertString( $cipherAlgorithm ));
        $this->log( LogLevel::DEBUG, ltrim( self::$FMTCIPHER ) . $this->cipherAlgorithm );
        $this->initializationVectorNumBytes = $this->DoOpensslCipherIvLength( $this->cipherAlgorithm );
        $this->log( LogLevel::DEBUG,ltrim( self::$FMTIVTXT ) . $this->initializationVectorNumBytes );
        return $this;
    }

    /**
     * Return HashAlgorithm
     *
     * @return string
     */
    public function getHashAlgorithm() {
        return $this->hashAlgorithm;
    }

    /**
     * Set hashAlgorithm
     *
     * @param string $hashAlgorithm
     * @return static
     * @throws InvalidArgumentException
     */
    public function setHashAlgorithm( $hashAlgorithm ) {
        $this->hashAlgorithm = self::assertMdAlgorithm( CommonFactory::assertString( $hashAlgorithm ));
        $this->log( LogLevel::DEBUG, ltrim( self::$FMTHASHALGO ) . $this->hashAlgorithm );
        return $this;
    }

    /**
     * Return format
     *
     * @param bool $asText
     * @return string
     */
    public function getFormat( $asText = false ) {
        if( $asText ) {
            return self::getFormatText( $this->format );
        }
        return $this->format;
    }

    /**
     * Set format
     *
     * @param string $format
     * @return static
     * @throws InvalidArgumentException
     */
    public function setFormat( $format ) {
        self::assertFormat( $format );
        $this->format = $format;
        $this->log( LogLevel::DEBUG, ltrim( self::$FMTENCTXT ) . self::getFormatText( $format ));
        return $this;
    }

    /**
     * @param float $startTime
     * @return float
     */
    private static function getExecTime( $startTime ) {
        return ( microtime( true ) - $startTime );
    }



}