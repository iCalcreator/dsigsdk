## DsigSdk

* PHP SDK of XML Digital Signature recommendation 
* based on the [XSD] schema 

and provide

* class dto's for all element(type)s in [XSD]
* parse of XML into a dto structure
* write of a dto structure to XML string / DomNode
* logic support

For usage, please reiew [docs/Usage.md].

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

Version 1.4.5 supports PHP 8.0, 1.2 7.4, 1.0 7.0.

Acquire access
``` php
namespace Kigkonsult\DsigSdk;
...
include 'vendor/autoload.php';
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
[docs/Usage.md]:docs/Usage.md
[Github]:https://github.com/iCalcreator/dsigsdk/issues
[XSD]:https://www.w3.org/TR/2002/REC-xmldsig-core-20020212/xmldsig-core-schema.xsd
