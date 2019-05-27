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
 * Version   0.965
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
namespace Kigkonsult\DsigSdk\Impl;

use Exception;
use Kigkonsult\DsigSdk\BaseTest;

/**
 * Class OpenSSLBaseTest
 *
 * @todo
 */
class OpenSSLBaseTest extends BaseTest
{

    /**
     * testassertPemString dataProvider
     *
     * @return array
     */
    public function assertPemStringProvider() {
        $dataArr = [];

        $dataArr[] =
            [
                1,
                '-----BEGIN PRIVATE KEY-----
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
PvcEFpVXVHj0vJP7S3ZW/G7ddvxJR6fs
-----END PRIVATE KEY-----
',
                true
            ];

        $dataArr[] =
            [
                2,
                '-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEA/UXvqRNOGEj/ZqQIuwBy
7FM/y2kwSTHNa5BvIAqlEmwI7FyrOSgS4gRF4fkOJvol7RV7BWhnKUVJ7cbyQhLL
f97jNkjntZoGBTSyDT77ZDpFAKWxxQ3VGj4eF7fd2TLl6eotUKqmVor5/f90wEDD
vpxAzWaDJJnHGPg41z5p852L/bPTQbd+izYb7qlheuWkguQxyHaBkHwfgNBgGNTr
761/Agqo9Vmkug2MC+FLcNxo3az/vQ+e2neksmlbL0B4wRwACQtExAN1/XNeEclL
VbBDXYMmwP0ukzQ43WpKCPm0d34AbikGj5xEYaAUixt2LZ9zoB4mE4lP4LFThE0h
ETSU1tNPAGgI7A5Yiz1ijgRFO1RmZIXqey0agb89IT0Th7W/aAbAlUI10UMJtm2c
xzb0OnZjJdHpcWLbZDjx04SgiPYbZx8+IM3KoEJU6qTv852dBb7TUM+dV3HoAuMv
s0fQheNQeIjbdHxhD2mXqlHEmHsu82otQ7RcLj8BJfbnlSutivqikspztheK7fv8
CgjRIgIhPxMomz47uGmnhaL0w+94+MRAEmJVga5Janvg5G4+4tCzkJ89/aR9B7uA
4NetvFvU6umGjdMAsNh8Y3k3IBte7dxrRcJD/pJhDSPghRxHqS7b6u9flziBV4QX
aHkMuIX9qc1FvFEx/K9hSncCAwEAAQ==
-----END PUBLIC KEY-----
',
                true
            ];

        $dataArr[] =
            [
                3,
                '',
                false
            ];

        $dataArr[] =
            [
                4,
                's0fQheNQeIjbdHxhD2mXqlHEmHsu82otQ7RcLj8BJfbnlSutivqikspztheK7fv8',
                false
            ];

        return $dataArr;
    }

    /**
     * Testing OpenSSLBase::isPemString
     *
     * @test
     * @dataProvider assertPemStringProvider
     * @param int    $case
     * @param string $algorithm
     * @param string $expected
     */
    public function testisPemString( $case, $string, $expected ) {
        static $FMT = '%s Error in case #%d';

        $this->assertEquals(
            $expected,
            OpenSSLFactory::isPemString( $string ),
            sprintf( $FMT, self::getCm( self::getCm( __METHOD__ ) ), 1 . $case )
        );

    }

    /**
     * Testing OpenSSLBase::assertPemString
     *
     * @test
     * @dataProvider assertPemStringProvider
     * @param int    $case
     * @param string $algorithm
     * @param string $expected
     */
    public function testassertPemString( $case, $string, $expected ) {
        static $FMT = '%s Error in case #%d';


        $outcome = null;
        try {
            OpenSSLFactory::assertPemString( $string );
            $outcome = true;
        }
        catch( Exception $e ) {
            $outcome = false;
        }

        $this->assertEquals(
            $expected,
            $outcome,
            sprintf( $FMT, self::getCm( __METHOD__ ), 2 . $case )
        );

    }

}