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

use Kigkonsult\DsigSdk\Dto\KeyInfoType as Dto;
use Kigkonsult\DsigSdk\DsigInterface;
use Faker;

class KeyInfoType implements DsigInterface
{

    /**
     * @return Dto
     * @access static
     */
    public static function loadFromFaker() {
        $faker = Faker\Factory::create();

        $keyInfoTypes = [];
        $max = $faker->numberBetween( 1, 8 );
        for( $x = 0; $x <= $max; $x++ ) {   // number of elements
            switch( $faker->numberBetween( 1, 8 )) {
                case 1 :
                    $keyInfoTypes[] =
                        [ self::KEYNAME         => $faker->sha256 ];
                    break;
                case 2 :
                    $keyInfoTypes[] =
                        [ self::KEYVALUE        => KeyValueType::loadFromFaker() ];
                    break;
                case 3 :
                    $keyInfoTypes[] =
                        [ self::RETRIEVALMETHOD => RetrievalMethodType::loadFromFaker() ];
                    break;
                case 4 :
                    $keyInfoTypes[] =
                        [ self::X509DATA        => X509DataType::loadFromFaker() ];
                    break;
                case 5 :
                    $keyInfoTypes[] =
                        [ self::PGPDATA         => PGPDataType::loadFromFaker() ];
                    break;
                case 6 :
                    $keyInfoTypes[] =
                        [ self::SPKIDATA        => SPKIDataType::loadFromFaker() ];
                    break;
                case 7 :
                    $keyInfoTypes[] =
                        [ self::MGMTDATA        => $faker->sha256 ];
                    break;
                case 8 :
                    $keyInfoTypes[] =
                        [ self::ANYTYPE         => AnyType::loadFromFaker() ];
                    break;
            }
        }

        return Dto::factory()
                  ->setKeyInfoType( $keyInfoTypes )
                  ->setId( $faker->sha256 );
    }

}