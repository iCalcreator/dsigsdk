## DsigSdk common aid support

#### Kigkonsult\DsigSdk\Impl\ImplCommon static methods

###### asserts

* __assertString__( data )
  * Assert data is a string (i.e. is a scalar)
  * Return string
  * Throws InvalidArgumentException
   
* __assertFileName__( (string) fileName )
  * Assert fileName is a readable file   
  * Throws InvalidArgumentException
   
* __assertFileNameWrite__( (string) fileName )
  * Assert fileName is a writable file
  * Throws InvalidArgumentException
   
###### misc
* __getRandomPseudoBytes__( (int) byteCnt, & cStrong )
  * Return cryptographically strong number of bytes


* __getSalt__( \[(int) byteCnt] )
  * Return (hex) cryptographically strong salt, default 64 bytes
  
  
* __getAlgorithmFromIdentifier__( (string) identifier )
  * Return algorithm from (URI) identifier

###### base64

* __base64encode__( (string) data )
  * Return base64 encoded string

* __base64decode__( (string) data )
  * Return base64 decoded string

* __base64UrlEncode__( (string) data )
  * Return base64Url encoded string

* __base64UrlDecode__( (string) data )
  * Return base64Url decoded string

###### hex

* __isHex__( string )
  * Return bool true if string is hex'ed

* __strToHex__( string )
  * Return hex converted from string

* __hexToStr__( string )
  * Return string converted from hex

###### pack

* __Hpach__( string )
  * Return binary string from a 'H*' packed hexadecimally encoded (binary) string

* __HunPach__( string )
  * Return (mixed) data from a 'H*' unpacked binary string

[Return](../../README.md)

