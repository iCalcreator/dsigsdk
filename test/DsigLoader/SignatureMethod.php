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
use Kigkonsult\DsigSdk\DsigInterface;
use Kigkonsult\DsigSdk\Dto\SignatureMethod as Dto;
use Faker;

class SignatureMethod implements DsigInterface, DsigLoaderInterface
{
    /**
     * @return Dto
     * @throws Exception
     */
    public static function loadFromFaker() : Dto
    {
        $faker = Faker\Factory::create();

        $max = random_int( 1, 5 );
        $signatureMethodTypes = [];
        for( $x = 0; $x <= $max; $x++ ) {
            if( 1 === random_int( 1, 2 )) {
                $signatureMethodTypes[] =
                    [ self::HMACOUTPUTLENGTH => ( 8 * random_int( 11, 14 )) ];
            }
            $max2 = random_int( 0, 2 );
            for( $x2 = 0; $x2 < $max2; $x2++ ) {
                $signatureMethodTypes[] =
                    [ self::ANYTYPE => Any::loadFromFaker() ];
            }
        } // end for
        return Dto::factoryAlgorithm( self::ALGORITHMS[random_int( 0, count( self::ALGORITHMS ) - 1 )] )
            ->setSignatureMethodTypes( $signatureMethodTypes );
    }
}
