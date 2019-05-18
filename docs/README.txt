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
 *           it under the terms of the GNU Lesser General Public License as
 *           published by the Free Software Foundation, either version 3 of the
 *           License, or (at your option) any later version.
 *
 *           DsigSdk is distributed in the hope that it will be useful,
 *           but WITHOUT ANY WARRANTY; without even the implied warranty of
 *           MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *           GNU Lesser General Public License for more details.
 *
 *           You should have received a copy of the GNU Lesser General Public
 *           License along with DsigSdk.
 *           If not, see <https://www.gnu.org/licenses/>.
 *
 * This file is a part of DsigSdk.
 */

## DsigSdk

* PHP SDK of XML Digital Signature recomendation
** http://www.w3.org/2000/09/xmldsig#
* based on the XSD schema
** https://www.w3.org/TR/2002/REC-xmldsig-core-20020212/xmldsig-core-schema.xsd

and provide

* dto's for all element(type)s in the XSD
  * src/Dto
  * with getters and setters, no other logic
* parse of XML into dto(s)
  * src/XMLParse/DsigParser.php
* write of dto(s) to XML string / DomNode
  * src/XMLWrite/DsigWriter.php

#### Usage, parse XML
DsigSdk uses XMLReader parsing input 
and accepts Signature, SignatureProperties and Manifest root elements. 
To parse an Dsig (Signature) XML file (using XMLReader) :

```php
<?php
namespace Kigkonsult\DsigSdk;
use Kigkonsult\DsigSdk\XMLParse\DsigParser;

$dsig = DsigParser::factory()->parse( 
    file_get_contents( 'DsigFile.xml' )
);

$signedInfo = $dsig->getsignedInfo();
...
```
The XML parser save the XMLreader node properties (baseURI, localName, name,
namespaceURI, prefix) for each XML (Dto) element as 'XMLattributes' as well
as XML attributes (xmlns, xmlns:*, schemaLocation), if set (more info below).

'any' [XSD] elements are accepted as 'Anytype' object instances (more info
below, 'AnyType').

#### Usage, build up structure
 
To build up dsig structure:
```php
<?php
namespace Kigkonsult\DsigSdk;
use Kigkonsult\DsigSdk\Dto\AnyType;
use Kigkonsult\DsigSdk\Dto\CanonicalizationMethodType;
use Kigkonsult\DsigSdk\Dto\KeyInfoType;
use Kigkonsult\DsigSdk\Dto\SignedInfoType;
use Kigkonsult\DsigSdk\Dto\SignatureType;
use Kigkonsult\DsigSdk\Dto\SignatureValueType;

$dsig = SignatureType::factory()
    ->setSignedInfo( 
        SignedInfoType::factory()
            ->setCanonicalizationMethod(
                CanonicalizationMethodType::factory()
                    ->setAlgorithm( SignatureType::MINICANONICAL )
                    ->setAny( [
                        AnyType::factory()
                            ->setElementName( 'nonSchemaElement1')
                            ->setAttributes( [
                                'id' => '12345' 
                                ] )
                             ->setContent( 'Lr1mKGxP7VAgMB...' ),
                        AnyType::factory()
                            ->setElementName( 'nonSchemaElement2')
                            ->setSubElements( [
                                AnyType::factory()
                                    ->setElementName( 'nonSchemaElement3')
                                    ->setContent( 'Lr1mKGxP7VAgMB...' ),
                            ] )
                        ]
                    )
            )
    )
    ->setSignatureValue(
        SignatureValueType::factory()
            ->setSignatureValueType( 'vgGZnRlm8...' )
    )
    ->setKeyInfo(
        KeyInfoType::factory()
            ->setKeyInfoType( [
                [
                    [ 
                        self::X509DATA => 
                            X509DataType::factory()
                                ->setX509Certificate( ... )
                    ],
                ],
        ] )
    )
    ->setObject(
        ...
    )
    ...
```
###### XML attributes

You can set (single 'element') XMLattribute using
```php
$dsig->setXMLAttribut( <key>, <value> );
```
To set (ex. prefix) and 'propagate' down in hierarchy:
```php
$dsig->setXMLAttribut( SignatureType::PREFIX, <value>, true );
```
You can remove (single 'element') XMLattribute using
```php
$dsig->unsetXMLAttribut( <key> );
```
To unset (ex. prefix) and 'propagate' down in hierarchy:
```php
$dsig->unsetXMLAttribut( SignatureType::PREFIX, true );
```
To fetch and iterate over XMLAttributes 
```php
foreach( $dsig->getXMLAttributes() as $key => $value {
    ...
}
```


###### Anytype

Anytype object instances are used for 'any' XSD elements.
The element name are stored and fetched with
```php
$anytype->setElementName( <name> );
```
```php
$anytypeName = $anytype->getElementName();
```
The 'any' XSD element attributes may include XML attributes.

The AnyType attributes are stored and fetched as array.
```php
$anytype->setAttributes( [ <key> => <value> ] );
```
```php
foreach( $anytype->getAttributes() as $key => $value {
    ...
}
```
Note, an AnyType instance may have
* content
  * type string,
  * AnyType::setContent()
  * AnyType::getContent()

or
* sub-elements
  * type array [*AnyType]
  * AnyType::setSubElements()
  * AnyType::getSubElements()

but not both.

#### Usage, output as XML
DsigSdk uses XMLWriter creating output.

```php
$XMLstring = DsigWriter::factory()->write( $dsig );
```
The XMLwriter adds for each element 
  * element name with prefix, if exists
  * XMLattribute xmlns, xmlns:* and schemaLocation, if exists.

#### Usage, output as DomNode
```php
$domNode = DsigWriter::factory()->write( $dsig, true );
```

#### Info

For class structure and architecture, please examine 
* the XSD
* docs/Dsig.png class design
* the src/DtoLoader directory

You may find convenient constants in 
- src/DsigInterface.php
- src/XMLAttributesInterface.php

#### Installation
Composer : https://getcomposer.org/

Composer, from the Command Line:

``` php
composer require kigkonsult/dsigsdk
```

Composer, in your `composer.json`:

``` json
{
    "require": {
        "kigkonsult/dsigsdk": "dev-master"
    }
}
```

Composer, acquire access
``` php
namespace Kigkonsult\DsigSdk;
...
include 'vendor/autoload.php';
```


Otherwise , download and acquire..

``` php
namepace Kigkonsult\DsigSdk;
...
include 'pathToSource/DsigSdk/autoload.php';
```

#### Support

For support, please use Github, https://github.com/iCalcreator/dsigsdk/issues


#### License

This project is licensed under the LGPLv3 License



