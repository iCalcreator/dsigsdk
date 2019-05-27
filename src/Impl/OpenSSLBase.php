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

use InvalidArgumentException;
use Psr\Log\LoggerInterface;

use function implode;
use function openssl_error_string;
use function openssl_get_cipher_methods;
use function openssl_get_md_methods;

/**
 * Class OpenSSLBase
 */
abstract class OpenSSLBase extends ImplBase implements OpenSSLInterface
{

    /**
     * Assert PEM string
     *
     * @param string $pem
     * @throws InvalidArgumentException
     */
    public static function assertPemString( $pem ) {
        static $FMTERR  = 'Invalid PEM format encountered.';
        if( ! self::isPemString( $pem )) {
            throw new InvalidArgumentException( $FMTERR );
        }
    }

    /**
     * Return bool true if pem is a PEM string
     *
     * A standard PEM has a begin line, an end line
     * and inbetween is a base64 encoding of the DER representation of the certificate.
     * PEM requires that linefeeds be present every 64 characters.
     *
     * @param string $pem
     * @return bool
     */
    public static function isPemString( $pem ) {
        static $PATTERN = '~^-----BEGIN ([A-Z ]+)-----\s*?([A-Za-z0-9+=/\r\n]+)\s*?-----END \1-----\s*$~D';
        return( is_string( $pem )) &&
            ( 1 == @preg_match( $PATTERN, $pem ));
    }

    /**
     * @var string
     */
    static $FMTERRX509RSCTYPE = 'No OpenSSL X.509 resource';
    static $X509RESOURCETYPE  = 'OpenSSL X.509';

    /**
     * Assert openssl_get_cipher_methods algorithm - return matched
     *
     * Two-step search : strict + anyCase
     *
     * @param string $algorithm
     * @throws InvalidArgumentException
     * @return string  - found algorithm
     * @static
     */
    public static function assertCipherAlgorithm( $algorithm ) {
        return parent::baseAssertAlgorithm( openssl_get_cipher_methods( true ), $algorithm );
    }

    /**
     * Assert openssl_get_md_methods algorithm
     *
     * Two-step search : strict + anyCase
     *
     * @param string $algorithm
     * @throws InvalidArgumentException
     * @return string  - found algorithm
     * @static
     */
    public static function assertMdAlgorithm( $algorithm ) {
        return parent::baseAssertAlgorithm( openssl_get_md_methods( true ), $algorithm );
    }

    /**
     * Return (string) OpenSSL errors
     *
     * @return string
     * @access protected
     * @static
     */
    protected static function getOpenSSLErrors() {
        $errors = [];
        while( $msg = openssl_error_string()) {
            $errors[] = $msg;
        }
        return implode( PHP_EOL, $errors );
    }

    /**
     * clear OpenSSL errors
     *
     * @access protected
     * @static
     */
    protected static function clearOpenSSLErrors() {
        while( false !== openssl_error_string()) {
            continue;
        };
    }

    /**
     * The logger instance.
     *
     * @var LoggerInterface
     * @access protected
     */
    protected $logger;

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     * @access protected
     */
    protected function log( $level, $message, array $context = array()) {
        if( ! empty( $this->logger )) {
            $this->logger->log( $level, $message, $context );
        }
    }

}