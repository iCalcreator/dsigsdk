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

use DOMNode;
use Exception;
use Kigkonsult\DsigSdk\Dto\Signature;
use Kigkonsult\DsigSdk\XMLParse\DsigParser;
use Kigkonsult\DsigSdk\XMLWrite\DsigWriter;
use Kigkonsult\DsigSdk\DsigLoader\Signature2 as SignatureLoader;

/**
 * Class SignatureTest
 */
class SignatureTest extends BaseTest
{

    /**
     * Create minimal sie-instance loaded with Faker-data, write xml1 and parse again, write xml2 and compare
     *
     * @test
     * @throws Exception
     */
    public function signatureTest2() : void
    {

        echo PHP_EOL . ' START  (min) ' . __FUNCTION__ . PHP_EOL;
        $startTime  = microtime( true );               // ---- load
        $signature1 = SignatureLoader::loadFromFaker();
        echo sprintf( '%s load time    : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        $startTime = microtime( true );               // ---- write to XML
        $xml1      = DsigWriter::factoryWrite( $signature1 );
        echo sprintf( '%s write time 1 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            $fileName1 = self::getBasePath() . SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '1.xml';
            touch( $fileName1 );
            file_put_contents( $fileName1, $xml1 );
        }

        $startTime  = microtime( true );               // ---- parse XML
        $signature2 = DsigParser::factory()->parseXmlFromString( $xml1 );
        echo sprintf( '%s parse time   : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;
        //echo 'XML attr then ' . var_export( $signature1->getXMLattributes(), true ) . PHP_EOL; // test ###

        $startTime = microtime( true );               // ---- write XML again
        $xml2      = DsigWriter::factoryWrite( $signature2 );
        echo sprintf( '%s write time 2 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            $fileName2 = self::getBasePath() . SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '2.xml';
            touch( $fileName2 );
            file_put_contents( $fileName2, $xml2 );
        }
        echo 'xml1 : ' . substr( $xml1, 0, 200 ) . PHP_EOL; // test ###
        echo 'xml2 : ' . substr( $xml2, 0, 200 ) . PHP_EOL; // test ###

        $this->assertSame(
            $xml1,
            $xml2,
            'Failed (#1) asserting that two Dsig (' . __FUNCTION__ . ') documents are equal.'
        );
        /* will not work... TypeError...
        try {
//            $this->assertXmlStringEqualsXmlString(
            self::assertXmlStringEqualsXmlString(
                $xml1,
                $xml2,
                'Failed asserting that two Dsig (signatureTest2) documents are equal.'
            );
        }
        catch( \ValueError $te ) {
            echo $te->getMessage() . PHP_EOL . $te->getTraceAsString() . PHP_EOL; // test ###
            $this->fail();
        }
        */
    }

    /**
     * Same as signatureTest2 but with prefix set
     *
     * @test
     * @throws Exception
     */
    public function signatureTest3() : void
    {

        // echo PHP_EOL . ' START (min+prefix) ' . __FUNCTION__ . PHP_EOL;
        // ---- load
        $startTime  = microtime( true );
        $signature1 = SignatureLoader::loadFromFaker();
        echo sprintf( '%s load time    : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        // ---- write XML
        $startTime = microtime( true );
        $xml1      = DsigWriter::factoryWrite( $signature1 );
        echo sprintf( '%s write time 1 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            $fileName1 = self::getBasePath() . SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '1.xml';
            touch( $fileName1 );
            file_put_contents( $fileName1, $xml1 );
        }
        // ---- parse XML
        $startTime  = microtime( true );
        $signature2 = DsigParser::factoryParse( $xml1 );
        echo sprintf( '%s parse time   : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        // $XMLattributes = $signature2->getXMLattributes();
        // echo 'XML attr before ' . var_export( $XMLattributes, true ) . PHP_EOL; // test ###

        // ---- set XML schema attrs
        $signature2->unsetXMLattribute( Signature::XMLNS, true );
        $XMLnsDenom = Signature::XMLNS . ':dsig';
        $signature2->setXMLattribute( Signature::PREFIX, 'dsig', true );
        $signature2->setXMLattribute( $XMLnsDenom, Signature::DSIGURI, false );

        $XMLattributes = $signature2->getXMLattributes();
        $this->assertFalse( isset( $XMLattributes[Signature::XMLNS] ));
        $this->assertTrue( isset( $XMLattributes[$XMLnsDenom] ));
        // echo 'XML attr after ' . var_export( $XMLattributes, true ) . PHP_EOL; // test ###

        // real test ends here

        // ---- write XML again
        $startTime = microtime( true );
        $xml2      = DsigWriter::factoryWrite( $signature2 );
        echo sprintf( '%s write time 2 : %01.6f', __FUNCTION__, ( microtime( true ) - $startTime )) . PHP_EOL;

        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            $fileName2 = self::getBasePath() . SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '2.xml';
            touch( $fileName2 );
            file_put_contents( $fileName2, $xml2 );
        }
        $this->assertTrue(
            2 < substr_count( $xml2, 'dsig:' ),
            'Missing XMLNS denom propagated down.'

        );
    }

    /**
     * Same as signatureTest2 but output as DomNode
     *
     * @test
     * @throws Exception
     */
    public function signatureTest4() : void
    {
        // echo PHP_EOL . ' START  (domNode) ' . __FUNCTION__ . PHP_EOL;
        $signature = SignatureLoader::loadFromFaker();

        $xml       = DsigWriter::factoryWrite( $signature );
        if( defined( 'SAVEXML' ) && ( false !== SAVEXML )) {
            $fileName = self::getBasePath() . SAVEXML . DIRECTORY_SEPARATOR . __FUNCTION__ . '1.xml';
            touch( $fileName );
            file_put_contents( $fileName, $xml );
        }

        $domNode   = DsigParser::factory()->parse( $xml, true );

        $this->assertInstanceOf( DOMNode::class, $domNode );
    }

    /**
     * Read XML from file
     *
     * @test
     * @throws Exception
     */
    public function signatureTest8() : void
    {
        // echo PHP_EOL . ' START file write/read test in ' . __FUNCTION__ . PHP_EOL;
        $signature = SignatureLoader::loadFromFaker();
        $xml1      = DsigWriter::factoryWrite( $signature );

        $tmpFile   = tempnam( sys_get_temp_dir(), __FUNCTION__ );
        $handle    = fopen( $tmpFile, "wb" );
        fwrite( $handle,$xml1 );
        fclose( $handle );

        $signature2 = DsigParser::factory()->parseXmlFromFile( $tmpFile );
        $xml2      = DsigWriter::factoryWrite( $signature2 );

        $this->assertSame(
            $xml1,
            $xml2,
            'Failed asserting that two Dsig (' . __FUNCTION__ . ') documents are equal.'
        );

        unlink( $tmpFile );
    }

    /**
     * Parse XML from string, write and compare
     *
     * @test
     * @throws Exception
     */
    public function signatureTest9() : void
    {
        echo PHP_EOL . ' START file write/read test in ' . __FUNCTION__ . PHP_EOL;
        $xml1      =
'<?xml version="1.0" encoding="UTF-8"?>
<Signature xmlns="http://www.w3.org/2000/09/xmldsig#">
 <SignedInfo Id="06597a7bb3ae77d390dd26bcc63740be2e348592a0b450f763ecd46536e2ef93">
  <CanonicalizationMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha384">
   <ProgressiveSolutionorientedInfomediaries xmlns="http://brekke.com/abc" Id="UAMUTTK4">1dc76ea426a69cbdbd0874a57f811288</ProgressiveSolutionorientedInfomediaries>
  </CanonicalizationMethod>
  <SignatureMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#">
   <VirtualExplicitPortal xmlns="http://thiel.biz/ea-non-sint-dolor-nulla-occaecati-nisi">
    <ConfigurableTangibleStructure xmlns="http://kovacek.com/porro-quia-et-ipsam-cupiditate-consectetur-animi-sapiente" Algorithm="http://www.w3.org/2001/04/xmldsig-more#kw-camellia128">5975ba80cd13271ff9bc1a532f399d1f</ConfigurableTangibleStructure>
    <DistributedIntermediateChallenge xmlns="https://www.zieme.net/tempore-quo-quia-quo-iusto-quia-dolore-dolor">60b12913885deab9c5089905a2c43e87</DistributedIntermediateChallenge>
   </VirtualExplicitPortal>
   <HMACOutputLength>96</HMACOutputLength>
   <FutureproofedZerodefectGraphicinterface xmlns="http://www.marquardt.net/perspiciatis-id-quod-non-laborum" Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha256">195ad099740681534589d4025259ed88</FutureproofedZerodefectGraphicinterface>
   <CentralizedAssymetricMatrix xmlns="http://www.gibson.biz/dolor-quae-deserunt-quasi-non">
    <DistributedCompositeSuperstructure xmlns="http://www.gerhold.biz/consequatur-voluptates-nobis-inventore§" Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha512">1ac6c3d215dbbce14ce935c1ad0a5015</DistributedCompositeSuperstructure>
    <ExclusiveHeuristicArchitecture xmlns="http://www.lowe.biz/abc§" Algorithm="http://www.w3.org/2001/04/xmldsig-more#rawSPKISexp" Id="HTLSCYGHM1W">df4f9bdd31a8a044845e9bbb42a85a1d</ExclusiveHeuristicArchitecture>
   </CentralizedAssymetricMatrix>
  </SignatureMethod>
  <Reference URI="http://ernser.net/libero-omnis-laudantium-alias-sunt.html" Type="http://fay.com/tempora-doloremque-doloribus-et-repellat-est-autem-reprehenderit">
   <Transforms>
    <Transform Algorithm="http://www.w3.org/2001/04/xmldsig-more#esign-sha1">
     <OpenarchitectedImpactfulBudgetarymanagement xmlns="http://mccullough.com/voluptatem-et-perferendis-explicabo§" Algorithm="http://www.w3.org/2001/04/xmldsig-more#PKCS7signedData">fa3ec0020ec41143c2f46f7f09b3221d</OpenarchitectedImpactfulBudgetarymanagement>
     <XPath>nam</XPath>
     <Universal4thgenerationContingency xmlns="http://www.oberbrunner.org/ducimus-molestiae-pariatur-temporibus-reprehenderit">
      <UniversalMethodicalDatawarehouse xmlns="http://jerde.net/abc§" Id="GYAFTRXTC6O">d7d146b4ad58c916c8a6a7e37a1dd311</UniversalMethodicalDatawarehouse>
      <MonitoredNeedsbasedFramework xmlns="http://skiles.org/occaecati-quas-deserunt-quod-perferendis-numquam§" Id="GVVDAM2Q">e0c689741e99486c0851d36fa66e3d74</MonitoredNeedsbasedFramework>
     </Universal4thgenerationContingency>
    </Transform>
    <Transform Algorithm="http://www.w3.org/2001/04/xmldsig-more#arcfour"/>
   </Transforms>
   <DigestMethod Algorithm="http://www.w3.org/2006/12/xml-c14n11#WithComments">
    <CrossplatformLocalCircuit xmlns="http://www.conn.info/consequatur-mollitia-voluptas-est-necessitatibus-voluptas-harum-dolorum-eligendi" Id="GLGGAU039XG">a455ad429cede93de66aab01a179663c</CrossplatformLocalCircuit>
    <MandatoryHumanresourceMonitoring xmlns="https://www.jerde.com/et-quis-natus-itaque-voluptatem-quia">87faefdc42a4d1cdcb3a39af62890a86</MandatoryHumanresourceMonitoring>
    <MultitieredGlobalWorkforce xmlns="https://www.christiansen.com/molestias-nemo-omnis-soluta">4840ffd16180f73dfe501424e5d4b77b</MultitieredGlobalWorkforce>
   </DigestMethod>
   <DigestValue>YjY4ZGYwYjA2NDdiZGFkODcxZTk0Mzk3NjA3MGJmYThkNjI4YjZkOTAzZThhYzVkNDVlZTY2NDE0MjRjYTlkYQ==</DigestValue>
  </Reference>
 </SignedInfo>
 <SignatureValue Id="956dd562d15798648248a6b38feac529c26c5e75dba6c75ecb034126bd8fe0b6">MDdlOTdkMzU4Y2ZhOTc2ZjdmMzE1YzM0NTA5ZmM4OGFkZjQ0NDJmZmJlN2Q2YWRlZWQ3MTc3NGFkMGFhNmEzNA==</SignatureValue>
</Signature>
';
        $signature2 = DsigParser::factory()->parseXmlFromString( $xml1 );
        $xml2       = DsigWriter::factoryWrite( $signature2 );

        $this->assertSame(
            $xml1,
            $xml2,
            'Failed asserting that two Dsig (' . __FUNCTION__ . ') documents are equal.'
        );
    }
}
