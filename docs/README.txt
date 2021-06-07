/**
 * DsigSdk   the PHP XML Digital Signature recomendation SDK,
 *           source http://www.w3.org/2000/09/xmldsig#
 *
 * This file is a part of DsigSdk.
 *
 * Copyright 2019-21 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * author    Kjell-Inge Gustafsson, kigkonsult
 * Link      https://kigkonsult.se
 * Package   DsigSdk
 * Version   0.976
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
 */

## DsigSdk

* PHP SDK of XML Digital Signature recomendation
* based on the [XSD] schema

and provide

* dto's for all element(type)s in [XSD]
  * [src/Dto](src/Dto)
  * with getters and setters, no other logic

* parse of XML into dto(s)
  * [src/XMLParse/DsigParser::parse](src/XMLParse/DsigParser.php)

* write of dto(s) to XML string / DomNode
  * [src/XMLWrite/DsigWriter::write](src/XMLWrite/DsigWriter.php)

* logic aid support
  * [src/Impl](src/Impl)
    * [common](src/Impl/Common.md) : convenient salt, base64, hex, pack etc unility methods
    * [Hash](src/Impl/Hash.md) : message digest support
    * [HmacHash](src/Impl/HmacHash.md) : message hmac digest support
    * [OpenSSL](src/Impl/OpenSSL.md) : encryption/decryption support
    * [Misc](src/Impl/Misc.md)

For help finding a good PHP cryptography library, please review
* [Choosing the Right Cryptography Library for your PHP Project: A Guide ](https://paragonie.com/blog/2015/11/choosing-right-cryptography-library-for-your-php-project-guide)


#### Usage, parse XML
To parse an Dsig (Signature root) XML file (using XMLReader) :

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
The XML parser save the XMLreader node properties (baseURI, localName, name, namespaceURI, prefix)
for each XML (Dto) element as 'XMLattributes' as well as XML attributes (xmlns, xmlns:*, schemaLocation),
if set (more info below).

'any' [XSD] elements are accepted as 'Anytype' object instances (more info below, 'AnyType').

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
                [                 // one set of elements
                    [             // element
                        SignatureType::X509DATA =>
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

Anytype object instances are used for 'any' [XSD] elements.
The element name are stored and fetched with
```php
$anytype->setElementName( <name> );
```
```php
$anytypeName = $anytype->getElementName();
```
The 'any' [XSD] element attributes may include XML attributes.

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

For class structure and architecture, please review
* the [XSD]
* [docs/Dsig.png](docs/Dsig.png) class design
* the [src/DsigLoader](src/DtoLoader) directory

You may find convenient constants in
- [src/DsigInterface](src/DsigInterface.php)
- [src/XMLAttributesInterface](src/XMLAttributesInterface.php)

For base64Encode/base64Decode/hash support, please review [src/Impl/Impl.md](src/Impl/Impl.md)

#### Installation

###### [Composer]
From the Command Line:

``` php
composer require kigkonsult/dsigsdk
```

In your `composer.json`:

``` json
{
    "require": {
        "kigkonsult/dsigsdk": "dev-master"
    }
}
```

Acquire access
``` php
namespace Kigkonsult\DsigSdk;
...
include 'vendor/autoload.php';
```

Run tests
```
cd pathToSource/DsigSdk
vendor/bin/phpunit
```

###### Or
Download and acquire..

``` php
namepace Kigkonsult\DsigSdk;
...
include 'pathToSource/DsigSdk/autoload.php';
```


#### Support

For support, please use [Github]/issues.


#### License

This project is licensed under the LGPLv3 License

[Composer]:https://getcomposer.org/
[Github]:https://github.com/iCalcreator/dsigsdk/issues
[http://www.w3.org/2000/09/xmldsig#]:http://www.w3.org/2000/09/xmldsig#
[XSD]:https://www.w3.org/TR/2002/REC-xmldsig-core-20020212/xmldsig-core-schema.xsd


