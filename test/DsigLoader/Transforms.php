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
use Faker;
use Kigkonsult\DsigSdk\Dto\Transform  as TransformDto;
use Kigkonsult\DsigSdk\Dto\Transforms as TransformsDto;

class Transforms implements DsigLoaderInterface
{
    /**
     * @return TransformsDto
     * @throws Exception
     */
    public static function loadFromFaker() : TransformsDto
    {
        $faker = Faker\Factory::create();

        $max        = random_int( 0, 2 );
        $transforms = [];
        for( $x = 0; $x <= $max; $x++ ) {
            $transforms[] = $faker->boolean()
            ? Transform::loadFromFaker()
            : TransformDto::factoryAlgorithm( self::ALGORITHMS[random_int( 0, count( self::ALGORITHMS ) - 1 )] );
        }
        $dto = $faker->boolean()
            ? TransformsDto::factoryTransform( Transform::loadFromFaker())
            : TransformsDto::factoryTransformAlgorithm( self::ALGORITHMS[random_int( 0, count( self::ALGORITHMS ) - 1 )] );
        if( ! empty( $transforms )) {
            $dto->setTransform( $transforms );
        }
        return $dto;
    }
}
