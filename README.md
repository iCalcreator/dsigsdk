## DsigSdk

* PHP SDK of XML Digital Signature recommendation 
* based on the [XSD] schema 

and provide

* dto's for all element(type)s in [XSD]
  * with getters and setters, no other logic
  
* parse of XML into dto(s)
  
* write of dto(s) to XML string / DomNode
  
* logic support
  

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
use Kigkonsult\DsigSdk\Dto\X509DataType;

$dsig = SignatureType::factory()
    ->setSignedInfo( 
        SignedInfoType::factory()
            ->setCanonicalizationMethod(
                CanonicalizationMethodType::factory()
                    ->setAlgorithm( 'algorithm' )
                    ->setAny( [
                        AnyType::factory()
                            ->setElementName( 'nonSchemaElement1')
                            ->setAttributes( [
                                'id' => '12345' 
                                ] )
                             ->setContent( 'Lr1mKGxP7VAgMB...' ),
                        AnyType::factory()
                            ->setElementName( 'nonSchemaElement2')
                            ->setAny( [
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
                        X509DataType::X509DATA => 
                            X509DataType::factory()
                                ->setX509DataTypes( ... )
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
  * AnyType::setAny()
  * AnyType::getAny()

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
* [docs/Dsig.png] class design
* the [test/DsigLoader] directory

You may find convenient constants in 
- [src/DsigInterface]
- [src/XMLAttributesInterface]

For base64Encode/base64Decode/hash etc support, please review [OpenSSLToolbox]

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
        "kigkonsult/dsigsdk": "*"
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
[docs/Dsig.png]:docs/Dsig.png
[Github]:https://github.com/iCalcreator/dsigsdk/issues
[http://www.w3.org/2000/09/xmldsig#]:http://www.w3.org/2000/09/xmldsig#
[OpenSSLToolbox]:https://github.com/iCalcreator/OpenSSLToolbox
[src/DsigInterface]:src/DsigInterface.php
[src/XMLAttributesInterface]:src/XMLAttributesInterface.php
[test/DsigLoader]:test/DsigLoader
[XSD]:https://www.w3.org/TR/2002/REC-xmldsig-core-20020212/xmldsig-core-schema.xsd
