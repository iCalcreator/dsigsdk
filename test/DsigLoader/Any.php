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
namespace Kigkonsult\DsigSdk\DsigLoader;

use Exception;
use Kigkonsult\DsigSdk\Dto\Any as Dto;
use Faker;

class Any implements DsigLoaderInterface
{
    /**
     * @param int $iterateCnt
     * @return Dto
     * @throws Exception
     */
    public static function loadFromFaker( ? int $iterateCnt = 3 ) : Dto
    {
        static $search = '/[^A-Za-z0-9]/';
        $faker = Faker\Factory::create();

        $elementNamePart = [];
        foreach( explode( ' ', $faker->catchPhrase ) as $part ) {
            $elementNamePart[] = ucfirst( strtolower( preg_replace( $search, '', $part )));
        }
        $uri = str_replace( '.html', '§', $faker->url );
        if( str_ends_with( $uri, '/' ) ) {
            $uri .= 'abc§';
        }
        $dto = Dto::factoryElementName( implode( '', $elementNamePart ))
                  ->setXMLattribute( Dto::XMLNS, $uri );
        $attributes = [];
        if( 1 === random_int( 1, 3 )) {
            $attributes[self::ALGORITM] = self::ALGORITHMS[random_int( 0, count( self::ALGORITHMS ) - 1 )];
        }
        if( 1 === random_int( 1, 3 )) {
            $attributes[self::ID] = $faker->swiftBicNumber;
        }
        if( ! empty( $attributes )) {
            $dto->setAttributes( $attributes );
        }

        --$iterateCnt;
        if( empty( $iterateCnt ) || ( 1 === random_int( 1, 3 ))) {
            $dto->setContent( $faker->md5 );
        }
        else {
            $dto->setAny( self::getSomeAnys());
        }

        return $dto;
    }

    /**
     * @param int $max
     * @param null|int $iterateCnt
     * @return Dto[]
     */
    public static function getSomeAnys( ? int $iterateCnt = null ) : array
    {
        $max  = random_int( 1, 2 );
        $anys = [];
        for( $x = 0; $x <= $max; $x++ ) {
            $anys[] = self::loadFromFaker( $iterateCnt );
        }
        return $anys;
    }
}
