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
namespace Kigkonsult\DsigSdk\DsigLoader;

use Kigkonsult\DsigSdk\DsigInterface;
use Kigkonsult\DsigSdk\Dto\TransformType as Dto;
use Faker;

class TransformType implements DsigInterface, DsigLoaderInterface
{
    /**
     * @return Dto
     * @access static
     */
    public static function loadFromFaker() : Dto
    {
        $faker = Faker\Factory::create();

        $max = $faker->numberBetween( 2, 3 );
        $transformTypes = [];
        for( $x = 0; $x <= $max; $x++ ) {
            if( 1 == $faker->numberBetween( 1, 2 )) {
                $transformTypes[] = [ self::XPATH => $faker->word ];
            }
            else {
                $transformTypes[] = [ self::ANYTYPE => AnyType::loadFromFaker() ];
            }
        } // end for
        return Dto::factory()
            ->setAlgorithm( self::ALGORITHMS[mt_rand( 0, count( self::ALGORITHMS ) - 1 )] )
            ->setTransformTypes( $transformTypes );
    }
}
