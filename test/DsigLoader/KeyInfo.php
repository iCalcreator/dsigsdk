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
use Kigkonsult\DsigSdk\Dto\KeyInfo as Dto;
use Kigkonsult\DsigSdk\DsigInterface;
use Kigkonsult\DsigSdk\Dto\Util;

class KeyInfo implements DsigInterface
{
    /**
     * @return Dto
     * @throws Exception
     */
    public static function loadFromFaker() : Dto
    {
        $faker = Faker\Factory::create();

        $keyInfoTypes   = [];
        $keyInfoTypes[0] =
            [ self::KEYNAME => $faker->sha256 ];
        $keyInfoTypes[1] =
            [ self::KEYVALUE => KeyValue::loadFromFaker() ];
        $keyInfoTypes[2] =
            [ self::KEYVALUE => KeyValue::loadFromFaker() ];
        $keyInfoTypes[3] =
            [ self::KEYVALUE => KeyValue::loadFromFaker() ];
        $keyInfoTypes[4] =
            [ self::RETRIEVALMETHOD => RetrievalMethod::loadFromFaker() ];
        $keyInfoTypes[5] =
            [ self::X509DATA => X509Data::loadFromFaker() ];
        $keyInfoTypes[6] =
            [ self::PGPDATA => PGPData::loadFromFaker() ];
        $keyInfoTypes[7] =
            [ self::SPKIDATA => SPKIData::loadFromFaker() ];
        $keyInfoTypes[8] =
            [ self::MGMTDATA => $faker->sha256 ];
        $keyInfoTypes[9] =
            [ self::ANYTYPE => Any::loadFromFaker() ];
        for( $x = 10; $x < 20; $x++ ) {   // number of elements
            $keyInfoTypes[$x] = match ( random_int( 1, 8 ) ) {
                1 => [ self::KEYNAME         => $faker->sha256 ],
                2 => [ self::KEYVALUE        => KeyValue::loadFromFaker() ],
                3 => [ self::RETRIEVALMETHOD => RetrievalMethod::loadFromFaker() ],
                4 => [ self::X509DATA        => X509Data::loadFromFaker() ],
                5 => [ self::PGPDATA         => PGPData::loadFromFaker() ],
                6 => [ self::SPKIDATA        => SPKIData::loadFromFaker() ],
                7 => [ self::MGMTDATA        => $faker->sha256 ],
                default
                  => [ self::ANYTYPE         => Any::loadFromFaker() ],
            }; // end match
        } // end for

        $x = $faker->randomElement( range( 0, 19 ));
        $type        = key( $keyInfoTypes[$x] );
        $keyInfoType = current( $keyInfoTypes[$x] );

        return Dto::factoryKeyInfo( $type, $keyInfoType )
            ->setId( Util::getSalt())
            ->setKeyInfoType( $keyInfoTypes );
    }
}
