<?php
/**
 * DsigSdk   the PHP XML Digital Signature recomendation SDK, 
 *           source http://www.w3.org/2000/09/xmldsig#
 *
 * copyright (c) 2019 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * Link      https://kigkonsult.se
 * Package   DsigSdk
 * Version   0.95
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
 * This file is a part of DsigSdk.
 */
namespace Kigkonsult\DsigSdk\XMLParse;

use Kigkonsult\DsigSdk\DsigBase;
use XMLReader;

use function get_called_class;

/**
 * Class DsigParserBase
 */
abstract class DsigParserBase extends DsigBase
{

    /**
     * @var string
     * @access protected
     * @static
     */
    protected static $FMTnodeFound = '%s Found (%s) %s';
    protected static $FMTattrFound = '%s Found attribute %s = %s';
    protected static $FMTreadNode  = '%s reading (%s) %s';

    /**
     * @var array $nodeTypes
     * @access protected
     * @static
     */
    protected static $nodeTypes = [
        0  => 'NONE',
        1  => 'ELEMENT',
        2  => 'ATTRIBUTE',
        3  => 'TEXT',
        4  => 'CDATA',
        5  => 'ENTITY_REF',
        6  => 'ENTITY',
        7  => 'PI',
        8  => 'COMMENT',
        9  => 'DOC',
        10 => 'DOC_TYPE',
        11 => 'DOC_FRAGMENT',
        12 => 'NOTATION',
        13 => 'WHITESPACE',
        14 => 'SIGNIFICANT_WHITESPACE',
        15 => 'END_ELEMENT',
        16 => 'END_ENTITY',
        17 => 'XML_DECLARATION',
    ];

    /**
     * @var XMLReader
     * @access protected
     */
    protected $reader = null;

    /**
     * Constructor
     *
     * @param XMLReader $reader
     */
    public function __construct( $reader = null  ) {
        parent::__construct();
        if( ! empty( $reader )) {
            $this->reader = $reader;
        }
    }

    /**
     * Factory
     *
     * @param XMLReader $reader
     * @return static
     * @static
     */
    public static function factory( $reader = null  ) {
        $class = get_called_class();
        return new $class( $reader );
    }

}