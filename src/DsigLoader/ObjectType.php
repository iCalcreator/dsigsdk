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
 * Package   DsigSdk
 * Version   0.971
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
namespace Kigkonsult\DsigSdk\DsigLoader;

use Faker;
use Kigkonsult\DsigSdk\DsigInterface;
use Kigkonsult\DsigSdk\Dto\ObjectType as Dto;
use Kigkonsult\DsigSdk\Impl\CommonFactory;

/**
 * Class ObjectType
 */
class ObjectType implements DsigInterface
{

    /**
     * @return Dto
     * @access static
     */
    public static function loadFromFaker() {
        $faker = Faker\Factory::create();

        $max         = $faker->numberBetween( 4, 6 );
        $objectTypes = [];
        for( $x = 0; $x < $max; $x++ ) {
            switch( $faker->numberBetween( 1, 3 )) {
                case 1 :
                    $objectTypes[] = [ self::MANIFEST => ManifestType::loadFromFaker() ];
                    break;
                case 2 :
                    $objectTypes[] = [ self::SIGNATUREPROPERTIES => SignaturePropertiesType::loadFromFaker() ];
                    break;
                case 3 :
                    $objectTypes[] = [ self::ANYTYPE => AnyType::loadFromFaker() ];
                    break;
            } // end switch
        } // end foreach
        return Dto::factory()
                  ->setObjectTypes( $objectTypes )
                  ->setId( CommonFactory::getSalt())
                  ->setMimeType( $faker->mimeType )
                  ->setEncoding( 'UTF-8' );

    }

}