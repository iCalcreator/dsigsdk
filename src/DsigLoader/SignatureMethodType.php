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
namespace Kigkonsult\DsigSdk\DsigLoader;

use Kigkonsult\DsigSdk\DsigInterface;
use Kigkonsult\DsigSdk\Dto\SignatureMethodType as Dto;
use Faker;

class SignatureMethodType implements DsigInterface, DsigLoaderInterface
{

    /**
     * @return Dto
     * @access static
     */
    public static function loadFromFaker() {
        $faker = Faker\Factory::create();

        $max = $faker->numberBetween( 1, 3 );
        $signatureMethodTypes = [];
        for( $x = 0; $x <= $max; $x++ ) {
            $elementSet = [];
            if( 1 == $faker->numberBetween( 1, 2 ) ) {
                $elementSet[] = [ self::HMACOUTPUTLENGTH => ( 8 * $faker->numberBetween( 11, 12 )) ];
            }
            $max2 = $faker->numberBetween( 0, 2 );
            for( $x2 = 0; $x2 < $max2; $x2++ ) {
                $elementSet[] = [ self::ANYTYPE => AnyType::loadFromFaker() ];
            }
            if( ! empty( $elementSet ) ) {
                $signatureMethodTypes[] = $elementSet;
            }
        } // end for
        return Dto::factory()
                  ->setSignatureMethodTypes( $signatureMethodTypes )
                  ->setAlgorithm( self::ALGORITHMS[mt_rand( 0, count( self::ALGORITHMS ) - 1 )] );
    }

}