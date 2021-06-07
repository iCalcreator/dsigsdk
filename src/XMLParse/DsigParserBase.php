<?php
/**
 * DsigSdk    the PHP XML Digital Signature recommendation SDK,
 *            source http://www.w3.org/2000/09/xmldsig#
 *
 * This file is a part of DsigSdk.
 *
 * @author    Kjell-Inge Gustafsson, kigkonsult <ical@kigkonsult.se>
 * @copyright 2019-21 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
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
     */
    protected static $FMTnodeFound = '%s Found (%s) %s';
    protected static $FMTattrFound = '%s Found attribute %s = %s';
    protected static $FMTreadNode  = '%s reading (%s) %s';

    /**
     * @var array $nodeTypes
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
     */
    protected $reader = null;

    /**
     * Constructor
     *
     * @param null|XMLReader $reader
     */
    public function __construct( $reader = null  )
    {
        parent::__construct();
        if( ! empty( $reader )) {
            $this->reader = $reader;
        }
    }

    /**
     * Factory method
     *
     * @param null|XMLReader $reader
     * @return static
     */
    public static function factory( $reader = null  ) : self
    {
        $class = get_called_class();
        return new $class( $reader );
    }
}
