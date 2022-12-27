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
namespace Kigkonsult\DsigSdk;

use Exception;
use InvalidArgumentException;
use Kigkonsult\DsigSdk\DsigLoader\Signature as SignatureLoader;
use Kigkonsult\DsigSdk\Dto\KeyInfo;
use Kigkonsult\DsigSdk\Dto\Objekt;
use Kigkonsult\DsigSdk\Dto\SignatureMethod;
use Kigkonsult\DsigSdk\Dto\SPKIData;
use Kigkonsult\DsigSdk\Dto\Transform;
use Kigkonsult\DsigSdk\Dto\Util;
use Kigkonsult\DsigSdk\Dto\X509Data;
use PHPUnit\Framework\TestCase;

class ExcTest extends TestCase
{
    /**
     * @test
     */
    public function algorithmTest() : void
    {
        foreach( SignatureLoader::ALGORITHMS as $algorithmIdentifier ) {
            $algorithm = Util::extractAlgorithmFromUriIdentifier( $algorithmIdentifier );
            $offset    = 0 - strlen( $algorithm ) - 2;
            $searchStr = substr( $algorithmIdentifier, $offset );
            $this->assertNotFalse(
                @strpos( $searchStr, $algorithm ),
                $algorithm . ' NOT found in ' . $algorithmIdentifier . ' (' . __METHOD__ . ')'
            );
        } // end foreach

        $notFound = false;
        try {
            $algorithm = Util::extractAlgorithmFromUriIdentifier( 'grodan boll' );
        }
        catch( InvalidArgumentException $e ) {
            $notFound = true;
        }
        $this->assertTrue( $notFound );
    }

    /**
     * @test
     */
    public function ExceptionTest1_KeyInfo() : void
    {
        $ok = false;
        try {
            $x = KeyInfo::factory()->addKeyInfoType( 'error', 'error' );
        }
        catch ( Exception $e ) {
            $ok = true;
        }
        $this->assertTrue( $ok, 'error in ' . __METHOD__ );
    }

    /**
     * @test
     */
    public function ExceptionTest2_Object() : void
    {
        $ok = false;
        try {
            $x = Objekt::factory()->addObjectType( 'error', 'error' );
        }
        catch ( Exception $e ) {
            $ok = true;
        }
        $this->assertTrue( $ok, 'error in ' . __METHOD__ );
    }

    /**
     * @test
     */
    public function ExceptionTest3_SPKIData() : void
    {
        $ok = false;
        try {
            $x = SPKIData::factory()->addSPKIDataType( 'error', 'error' );
        }
        catch ( Exception $e ) {
            $ok = true;
        }
        $this->assertTrue( $ok, 'error in ' . __METHOD__ );
    }

    /**
     * @test
     */
    public function ExceptionTest4_SignatureMethod() : void
    {
        $ok = false;
        try {
            $x = SignatureMethod::factory()->addSignatureMethodType( 'error', 'error' );
        }
        catch ( Exception $e ) {
            $ok = true;
        }
        $this->assertTrue( $ok, 'error in ' . __METHOD__ );
    }

    /**
     * @test
     */
    public function ExceptionTest5_Transform() : void
    {
        $ok = false;
        try {
            $x = Transform::factory()->addTransformType( 'error', 'error' );
        }
        catch ( Exception $e ) {
            $ok = true;
        }
        $this->assertTrue( $ok, 'error in ' . __METHOD__ );
    }

    /**
     * @test
     */
    public function ExceptionTest6_X509Data() : void
    {
        $ok = false;
        try {
            $x = X509Data::factory()->addX509DataType( 'error', 'error' );
        }
        catch ( Exception $e ) {
            $ok = true;
        }
        $this->assertTrue( $ok, 'error in ' . __METHOD__ );
    }
}
