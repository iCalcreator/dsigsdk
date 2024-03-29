<?php
/**
 * DsigSdk    the PHP XML Digital Signature recommendation SDK,
 *            source http://www.w3.org/2000/09/xmldsig#
 *
 * This file is a part of DsigSdk.
 *
 * @author    Kjell-Inge Gustafsson, kigkonsult <ical@kigkonsult.se>
 * @copyright 2019-2022 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
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
namespace Kigkonsult\DsigSdk\XMLWrite;

use Kigkonsult\DsigSdk\DsigBase;
use Kigkonsult\DsigSdk\Dto\DsigBase as DtoBase;
use XMLWriter;

use function sprintf;

/**
 * Class DsigWriterBase
 */
abstract class DsigWriterBase extends DsigBase
{
    /**
     * @var XMLWriter|null
     */
    protected ?XMLWriter $writer = null;

    /**
     * Constructor
     *
     * @param XMLWriter|null $writer
     */
    public function __construct( XMLWriter $writer = null )
    {
        parent::__construct();
        if( null !== $writer ) {
            $this->writer = $writer;
        }
    }

    /**
     * Factory method
     *
     * @param null|XMLWriter $writer
     * @return static
     */
    public static function factory( ? XMLWriter $writer = null ) : static
    {
        return new static( $writer );
    }

    /**
     * Set writer start element, incl opt XML-attributes
     *
     * @param string      $elementName
     * @param array       $XMLattributes
     */
    protected function setWriterStartElement( string $elementName, array $XMLattributes ) : void
    {
        $FMTNAME = '%s:%s';
        if( empty( $elementName )) {
            $elementName = $XMLattributes[self::LOCALNAME];
        }
        if( isset( $XMLattributes[self::PREFIX] ) && ! empty( $XMLattributes[self::PREFIX] )) {
            $elementName = sprintf( $FMTNAME, $XMLattributes[self::PREFIX], $elementName );
        }
        $this->writer->startElement( $elementName );
        foreach( $XMLattributes as $key => $value ) {
            if( DtoBase::isXmlAttrKey( $key )) {
                $this->writeAttribute( $key, $value );
            }
        }
    }

    /**
     * Set writer start element, incl opt XML-attributes
     *
     * @param string    $elementName
     * @param array     $XMLattributes
     * @param mixed     $value
     */
    protected function writeTextElement( string $elementName, array $XMLattributes, mixed $value ) : void
    {
        $this->setWriterStartElement( $elementName, $XMLattributes );
        $this->writer->text( $value );
        $this->writer->endElement();
    }

    /**
     * Write attribute
     *
     * @param string      $elementName
     * @param null|string $value
     */
    protected function writeAttribute( string $elementName, ? string $value = null ) : void
    {
        if( null !==  $value ) {
            $this->writer->startAttribute($elementName );
            $this->writer->text( $value );
            $this->writer->endAttribute();
        }
    }

    /**
     * Return DtoSubject XMLattributes OR (const) DSIGXMLAttributes
     *
     * @param DtoBase $subject
     * @return array
     */
    protected static function obtainXMLattributes( DtoBase $subject ) : array
    {
        return $subject->isXMLattributesSet() ? $subject->getXMLattributes() : [];
    }
}
