<?php
/**
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

/**
 * Class PhpErrorException
 *
 */
class PhpErrorException extends Exception
{
    /**
     * @var int
     * @access protected
     */
    protected $severity;

    /**
     * @var array
     * @access private
     */
    private static $errorTexts = [
        E_ERROR             => 'ErrorException',
        E_WARNING           => 'Warning',
        E_PARSE             => 'Parse',
        E_NOTICE            => 'Notice',
        E_CORE_ERROR        => 'CoreError',
        E_CORE_WARNING      => 'CoreWarning',
        E_COMPILE_ERROR     => 'CompileError',
        E_COMPILE_WARNING   => 'CoreWarning',
        E_USER_ERROR        => 'UserError',
        E_USER_WARNING      => 'UserWarning',
        E_USER_NOTICE       => 'UserNotice',
        E_STRICT            => 'Strict',
        E_RECOVERABLE_ERROR => 'RecoverableError',
        E_DEPRECATED        => 'Deprecated',
        E_USER_DEPRECATED   => 'UserDeprecated',
    ];

    /**
     * Class constructor
     *
     * @param string $message
     * @param int    $code
     * @param int    $severity
     * @param string $filename
     * @param int    $lineno
     */
    public function __construct(
        $message,
        $code,
        $severity,
        $filename,
        $lineno
    ) {
        $this->message  = $message;
        $this->code     = $code;
        $this->severity = $severity;
        $this->file     = $filename;
        $this->line     = $lineno;
    }

    /**
     * Return severity
     *
     * @return int
     */
    public function getSeverity() {
        return $this->severity;
    }

    /**
     * Return severity text
     *
     * @param int $errorNo
     * @return string
     * @static
     */
    public static function getSeverityText(
        $errorNo
    ) {
        static $unknown = 'Unknown error';
        return ( isset( self::$errorTexts[$errorNo] )) ? self::$errorTexts[$errorNo] : $unknown;
    }
}