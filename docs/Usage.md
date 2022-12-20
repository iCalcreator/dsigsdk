## Usage, parse XML
To parse an Dsig (Signature root) XML file (using XMLReader) :

```php
<?php
namespace Kigkonsult\DsigSdk;
use Kigkonsult\DsigSdk\XMLParse\DsigParser;

$signature = DsigParser::factoryParse( file_get_contents( 'DsigFile.xml' ));

$signedInfo = $signature->getsignedInfo();
...
```

The XML parser save the XMLreader node properties (baseURI, localName, name, namespaceURI, prefix)
for each XML (Dto) element as 'XMLattributes' as well as XML attributes (xmlns, xmlns:*, schemaLocation),
if set (more info below).

The 'any' [XSD] elements are accepted as 'Anytype' object instances (more info below, 'AnyType').

__DsigParser__ methods
* _factory_
  * static 
  * return _DsigParser_ class instance
* _factoryParse_( string xml )
  * static
  * return Signature class instance
* parse( string xml, bool asDomNode (=false) )
  * return 
    * Signature class instance
    * DomNode

You may use [Loggerdepot] set up a (Psr/Log) logger for the parse. 

## Usage, build up structure

To build up dsig structure:

```php
<?php
namespace Kigkonsult\DsigSdk;
use Kigkonsult\DsigSdk\Dto\Any;
use Kigkonsult\DsigSdk\Dto\CanonicalizationMethod;
use Kigkonsult\DsigSdk\Dto\KeyInfo;
use Kigkonsult\DsigSdk\Dto\SignedInfo;
use Kigkonsult\DsigSdk\Dto\Signature;
use Kigkonsult\DsigSdk\Dto\SignatureValue;
use Kigkonsult\DsigSdk\Dto\X509Data;

$signature = Signature::factory()
    ->setSignedInfo( 
        SignedInfo::factory()
            ->setCanonicalizationMethod(
                CanonicalizationMethod::factoryAlgorithm( 'algorithm' )
                    ->setAny( 
                        [
                            Any::factoryElementName( 'nonSchemaElement1')
                                ->setAttributes( [ 'id' => '12345' ] )
                                ->setContent( 'Lr1mKGxP7VAgMB...' ),
                            Any::factoryElementName( 'nonSchemaElement2')
                                ->setAny( 
                                    [
                                        Any::factoryElement( 'nonSchemaElement3')
                                            ->setContent( 'Lr1mKGxP7VAgMB...' ),
                                    ]
                                )
                        ]
                    )
            )
    )
    ->setSignatureValue( SignatureValue::factorySignatureValueType( 'vgGZnRlm8...' ))
    ->setKeyInfo(
        KeyInfo::factory()
            ->setKeyInfoType( [
                [                 // one set of elements
                    [             // element
                        X509Data::X509DATA => 
                            X509Data::factory()
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


## Usage, output as XML
DsigSdk uses XMLWriter creating output.

If XML schema (Signaure) attributes not set, the [src/XMLAttributesInterface] _DSIGXMLAttributes_ are used<br>
otherwise for each element (if set)
* element localName, name, name prefix, baseURI, namespaceURI
* XMLattribute xmlns, xmlns:* and schemaLocation.

```php
$XMLstring = DsigWriter::factoryWrite( $signature );
```

__DsigWriter__ methods
* _factory_()
  * static
  * return _DsigWriter_ class instance
* _factoryWrite_( Signature signature )
  * static
  * return string
* write( Signature $signature ) 
  * return string

## Dto class structure

Here describes class __name__, _properties_ and, opt, spec. (static) _factory_ methods.<br>
All classes has an 'empty' _factory_ method and a property, _XMLattributes_ (array), for local (element) attributes.<br>
All properties has getter, is\<Prop>Set and setter methods,
for array properties also an add\<prop> method.


__Any__ (more info below)
- _elementName_, string<br>
- _attributes_, string[]<br>
- _content_, string<br>
- _any_, Any[]<br>
  _factoryElementName_( string elementName )

 
__CanonicalizationMethod__
- _any_, type Any[]<br>
- _algorithm_, string<br>
  _factoryAlgorithm_( string _algorithm_ )


__DigestMethodType__
- _any_, type Any[]<br>
- _algorithm_, string<br>
  _factoryAlgorithm_( string _algorithm_ )


__DSAKeyValue__
- _p_, string<br>
- _q_, string<br>
- _g_, string<br>
- _y_, string<br>
- _j_, string<br>
- _seed_, string<br>
- _pgenCounter_, string


__KeyInfo__
- _keyInfoType_, array<br>
- _id_, string<br>
  _factoryKeyInfo_( string type, mixed keyInfoType ) 


__KeyValue__
- _DSAKeyValue_, DSAKeyValue<br>
- _RSAKeyValue_, RSAKeyValue<br>
- _any_, Any<br>
  _factoryDSAKeyValue_( DSAKeyValue _DSAKeyValue_ )<br>
  _factoryRSAKeyValue_( RSAKeyValue _RSAKeyValue_ )


__Manifest__
- _reference_, Reference[]<br>
  _factoryReference_( Reference _Reference_ )


__Objekt__ (note class name, XML elementname is 'Object')
- _objectTypes_, array<br>
- _id_, string<br>
- _mimeType_, string<br>
- _encoding_, string


__PGPData__
- _PGPKeyID_, string<br>
- _PGPKeyPacket_, string<br>
- _any_, Any[]<br>
  _factoryPGPKeyID_( string _PGPKeyID_ )<br>
  _factoryPGPKeyPacket_( string _PGPKeyPacket_ )


__Reference__
- _transforms_, Transforms<br>
- _digestMethod_, DigestMethod<br>
- _digestValue_, string<br>
- _id_, string<br>
- _URI_, string<br>
- _type_, string<br>
  _factoryDigest_( DigestMethod _digestMethod_, string _digestValue_ )


__RetrievalMethod__
- _transforms_, Transforms<br>
- _URI_, string<br>
- _type_, string


__RSAKeyValue__
- _modulus_, string<br>
- _exponent_, string<br>
  _factoryModulusExponent_( string _modulus_, string _exponent_ )


__Signature__
- _signedInfo_, SignedInfo<br>
- _signatureValue_, SignatureValue<br>
- _keyInfo_ KeyInfo<br>
- _object_, Object[]<br>
- _id_, string<br>


__SignatureMethod__
- _signatureMethodTypes_, array<br>
- _algorithm_, string<br>
  _factoryAlgorithm_( string _algorithm_ )


__SignatureProperties__
- _signatureProperty_, SignatureProperty[]<br>
- _id, string_<br>
  _factorySignatureProperty_( SignatureProperty _signatureProperty_ )


__SignatureProperty__
- _any_, Any[]<br>
- _target_, string<br>
- _id_, string<br>
  _factoryTarget_( string _target_ )


__SignatureValue__
- _signatureValueType_, string<br>
- _id_, string<br>
  _factorySignatureValueType_( string _signatureValueType_ )


__SignedInfo__
- _canonicalizationMethod_, CanonicalizationMethod<br>
- _signatureMethod_, SignatureMethod<br>
- _reference_, Reference[]


__SPKIData__
- _SPKIDataType_, array<br>
 _factorySPKIDataType_( string type, mixed keyInfoType ) 


__Transforms__
- _transform_, Transform[]<br>
  _factoryTransform_( Transform _transform_ )<br>
  _factoryTransformAlgorithm_( string algorithm ) 


__Transform__
- _transformTypes_, array<br>
- _algorithm_, string<br>
  factoryAlgorithm( string $algorithm )


__X509Data__
- _X509DataTypes_, array<br>
  _factoryX509DataType_( string _type_, mixed _X509DataType_ )


__X509IssuerSerial__
- _X509IssuerName_, string<br>
- _getX509IssuerName_, int|string<br>
  factoryX509NameNumber( string _X509IssuerName_, int|string _X509SerialNumber_ )


##### Details

For extended class structure and architecture, please review
* the [XSD]
* [Dsig.png] class design
* the [test/DsigLoader] directory

You may find convenient constants in
- [src/DsigInterface]
- [src/XMLAttributesInterface]
- [src/DsigIdentifiersInterface]

For base64Encode/base64Decode/hash etc support, please review [OpenSSLToolbox]



#### Any

The Any (i.e. Anytype) object instances are used for 'any' [XSD] elements.

The 'any' [XSD] element attributes may include XML attributes, some (keys) may be found in [src/XMLAttributesInterface].

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
* _content_
  * type string
  * AnyType::setContent()
  * AnyType::getContent()

or
* _any_ (sub-elements)
  * type array [*AnyType]
  * AnyType::setAny()
  * AnyType::getAny()

but not both.

#### XML attributes

If XML schema (_Signaure_) attributes not set, the [src/XMLAttributesInterface] _DSIGXMLAttributes_ are used.

You can **set** (single 'element', below on a _Signature_ instance) XMLattribute using
```php
$signature->setXMLAttribut( <key>, <value> );
```
To set (ex. _prefix_) and 'propagate' down in hierarchy:
```php
$signature->setXMLAttribut( SignatureType::PREFIX, <value>, true );
```
You can **remove** (single 'element') XMLattribute using
```php
$signature->unsetXMLAttribut( <key> );
```
To unset (ex. _prefix_) and 'propagate' down in hierarchy:
```php
$signature->unsetXMLAttribut( SignatureType::PREFIX, true );
```
To fetch and iterate over XMLAttributes
```php
foreach( $signature->getXMLAttributes() as $key => $value {
    ...
}
```

[Dsig.png]:Dsig.png
[Loggerdepot]:https://github.com/iCalcreator/loggerdepot
[OpenSSLToolbox]:https://github.com/iCalcreator/OpenSSLToolbox
[src/DsigInterface]:../src/DsigInterface.php
[src/DsigIdentifiersInterface]:../src/DsigIdentifiersInterface.php
[src/XMLAttributesInterface]:../src/XMLAttributesInterface.php
[test/DsigLoader]:../test/DsigLoader
[XSD]:https://www.w3.org/TR/2002/REC-xmldsig-core-20020212/xmldsig-core-schema.xsd
