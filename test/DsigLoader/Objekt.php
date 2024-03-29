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
use Kigkonsult\DsigSdk\DsigInterface;
use Kigkonsult\DsigSdk\Dto\Objekt as Dto;
use Kigkonsult\DsigSdk\Dto\Util;

/**
 * Class Objekt
 */
class Objekt implements DsigInterface
{
    /**
     * @return Dto
     * @throws Exception
     */
    public static function loadFromFaker() : Dto
    {
        $faker = Faker\Factory::create();

        $objectTypes = [ // assure at least one of each
            [ self::MANIFEST => Manifest::loadFromFaker() ],
            [ self::SIGNATUREPROPERTIES => SignatureProperties::loadFromFaker() ],
            [ self::ANYTYPE => Any::loadFromFaker() ]
        ];
        $max = random_int( 2, 3 );
        for( $x = 0; $x < $max; $x++ ) {
            $objectTypes[] = match ( random_int( 1, 3 ) ) {
                1 => [ self::MANIFEST => Manifest::loadFromFaker() ],
                2 => [ self::SIGNATUREPROPERTIES => SignatureProperties::loadFromFaker() ],
                3 => [ self::ANYTYPE => Any::loadFromFaker() ],
            }; // end switch
        } // end foreach
        return Dto::factory()
            ->setObjectTypes( $objectTypes )
            ->setId( Util::getSalt())
            ->setMimeType( $faker->mimeType )
            ->setEncoding( 'UTF-8' );
    }
}
