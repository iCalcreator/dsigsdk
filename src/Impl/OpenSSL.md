## DsigSdk OpenSSL support

#### Kigkonsult\DsigSdk\Impl\OpenSSLFactory 

Inspiration and based on 
[php-openssl-cryptor](https://github.com/ioncube/php-openssl-cryptor) (Copyright 2016 ionCube Ltd, licence [MIT](https://opensource.org/licenses/MIT))

###### Usage

```php
namespace Kigkonsult\DsigSdk

use Kigkonsult\DsigSdk\Impl\CommonFactory;
use Kigkonsult\DsigSdk\Impl\OpenSSLFactory;

$data = 'some data'
$key  = CommonFactory::getSalt();

$enCrypted = OpenSSLFactory::factory()->encryptString( $data, $key );

$deCrypted = OpenSSLFactory::factory()->decryptString( $enCrypted, $key );

```
###### class static methods

* __assertCipherAlgorithm__( (string) algorithm )
  * Assert *openssl_get_cipher_methods* algorithm
    * Two-step search : strict + anycase
  * Return found
  * Throws InvalidArgumentException on not found 

* __assertMdAlgorithm__( (string) algorithm )
  * Assert *openssl_get_md_methods* algorithm
    * Two-step search : strict + anycase
  * Return found
  * Throws InvalidArgumentException on not found 

###### object instance methods

* __construct__( \[cipherAlgorithm, \[hashAlgorithm, (int) \[encryptedEncoding\]]] )
  * cipherAlgorithm, below, 'aes-256-ctr' default
  * hashAlgorithm, below, 'sha256' default
  * encryptedEncoding
    * OpenSSLFactory::FORMAT_RAW
    * OpenSSLFactory::FORMAT_B64,default
    * OpenSSLFactory::FORMAT_HEX
  * Throws InvalidArgumentException, RuntimeException

* __factory__( \[cipherAlgorithm, \[hashAlgorithm, (int) \[encryptedEncoding\]]] )
  * static
  * Return static

* __encryptString__( (string) data, (string) encryptKey, (int) \[outputEncoding\] )
  * Return Encrypted string
  * outputEncoding, optional override for the output encoding (encryptedEncoding, above)
  * Throws InvalidArgumentException, RuntimeException

* __decryptString__( (string) data, (string) decryptKey, \[dataEncoding\] )
  * can NOT decrypt using AEAD cipher mode (GCM or CCM) etc (throws RuntimeException), below
  * Return decrypted string
  * dataEncoding, optional override for the input encoding
    * OpenSSLFactory::FORMAT_RAW
    * OpenSSLFactory::FORMAT_B64,default
    * OpenSSLFactory::FORMAT_HEX
  * Throws InvalidArgumentException, RuntimeException

* __getCipherAlgorithm__()
  * Return cipherAlgorithm
  
* __setCipherAlgorithm__( (string) cipherAlgorithm )    
  * Set cipherAlgorithm, below
  * Return static
  * Throws InvalidArgumentException

* __getHashAlgorithm__()
  * Return hashAlgorithm
  
* __setHashAlgorithm__( (string) hashAlgorithm )  
  * Set hashAlgorithm, below
  * Return static
  * Throws InvalidArgumentException
  
* __getFormat__()  
  * Return (int) format

* __setFormat__( (int) format )
  * Set format
    * OpenSSLFactory::FORMAT_RAW
    * OpenSSLFactory::FORMAT_B64
    * OpenSSLFactory::FORMAT_HEX
  * Return static
  * Throws InvalidArgumentException


#### openssl_get_cipher_methods

As of PHP 7.0.25, OpenSSL 1.0.2k-fips  26 Jan 2017

ciphers, encrypt/decrypt-tested ok with all md (digest+alias) below :
```
AES-128-CBC,AES-128-CFB,AES-128-CFB1,AES-128-CFB8,AES-128-CTR,AES-128-ECB,AES-128-OFB,AES-128-XTS,
AES-192-CBC,AES-192-CFB,AES-192-CFB1,AES-192-CFB8,AES-192-CTR,AES-192-ECB,AES-192-OFB,
AES-256-CBC,AES-256-CFB,AES-256-CFB1,AES-256-CFB8,AES-256-CTR,AES-256-ECB,AES-256-OFB,AES-256-XTS,
BF-CBC,BF-CFB,BF-ECB,BF-OFB,
CAMELLIA-128-CBC,CAMELLIA-128-CFB,CAMELLIA-128-CFB1,CAMELLIA-128-CFB8,CAMELLIA-128-ECB,CAMELLIA-128-OFB,
CAMELLIA-192-CBC,CAMELLIA-192-CFB,CAMELLIA-192-CFB1,CAMELLIA-192-CFB8,CAMELLIA-192-ECB,CAMELLIA-192-OFB,
CAMELLIA-256-CBC,CAMELLIA-256-CFB,CAMELLIA-256-CFB1,CAMELLIA-256-CFB8,CAMELLIA-256-ECB,CAMELLIA-256-OFB,
CAST5-CBC,CAST5-CFB,CAST5-ECB,CAST5-OFB,
DES-CBC,DES-CFB,DES-CFB1,DES-CFB8,DES-ECB,
DES-EDE,DES-EDE-CBC,DES-EDE-CFB,DES-EDE-OFB,
DES-EDE3,DES-EDE3-CBC,DES-EDE3-CFB,DES-EDE3-CFB1,DES-EDE3-CFB8,DES-EDE3-OFB,
DES-OFB,DESX-CBC,
IDEA-CBC,IDEA-CFB,IDEA-ECB,IDEA-OFB,
RC2-40-CBC,RC2-64-CBC,RC2-CBC,RC2-CFB,RC2-ECB,RC2-OFB,
RC4,RC4-40,RC4-HMAC-MD5,
RC5-CBC,RC5-CFB,RC5-ECB,RC5-OFB,
SEED-CBC,SEED-CFB,SEED-ECB,SEED-OFB,
aes-128-cbc,aes-128-cfb,aes-128-cfb1,aes-128-cfb8,aes-128-ctr,aes-128-ecb,aes-128-ofb,aes-128-xts,
aes-192-cbc,aes-192-cfb,aes-192-cfb1,aes-192-cfb8,aes-192-ctr,aes-192-ecb,aes-192-ofb,
aes-256-cbc,aes-256-cfb,aes-256-cfb1,aes-256-cfb8,aes-256-ctr,aes-256-ecb,aes-256-ofb,aes-256-xts,
bf-cbc,bf-cfb,bf-ecb,bf-ofb,
camellia-128-cbc,camellia-128-cfb,camellia-128-cfb1,camellia-128-cfb8,camellia-128-ecb,camellia-128-ofb,
camellia-192-cbc,camellia-192-cfb,camellia-192-cfb1,camellia-192-cfb8,camellia-192-ecb,camellia-192-ofb,
camellia-256-cbc,camellia-256-cfb,camellia-256-cfb1,camellia-256-cfb8,camellia-256-ecb,camellia-256-ofb,
cast5-cbc,cast5-cfb,cast5-ecb,cast5-ofb,
des-cbc,des-cfb,
idea-cbc,idea-cfb,idea-ecb,idea-ofb,
rc2-40-cbc,rc2-64-cbc,rc2-cbc,rc2-cfb,rc2-ecb,rc2-ofb,
rc4,rc4-40,rc4-hmac-md5,
rc5-cbc,rc5-cfb,rc5-ecb,rc5-ofb,
seed-cbc,seed-cfb,seed-ecb,seed-ofb,
```
aliases
```
AES128, AES192, AES256,AES256,
BF, 
CAMELLIA128, CAMELLIA192, CAMELLIA256,
CAST, CAST-cbc,
IDEA, RC5, SEED,
aes128, aes192, aes256,
bf, blowfish,
camellia128, camellia192, camellia256,
cast, cast-cbc,idea,
rc5, seed 
```

ciphers, tested encrypt ok, decrypt *NOT OK*
```
aes-128-ccm,aes-128-gcm,aes-192-ccm,,aes-192-gcm,aes-256-ccm,aes-256-gcm
des-cfb1,des-cfb8,
des-ecb
des-ede,des-ede-cbc,des-ede-cfb,des-ede-ofb
des-ede3,des-ede3-cbc,des-ede3-cfb,des-ede3-cfb1,des-ede3-cfb8,des-ede3-ofb
des-ofb
desx-cbc
id-aes128-CCM,id-aes128-GCM,id-aes128-wrap,id-aes128-wrap-pad
id-aes192-CCM,id-aes192-GCM,id-aes192-wrap,id-aes192-wrap-pad
id-aes256-CCM,id-aes256-GCM,id-aes256-wrap,id-aes256-wrap-pad
id-smime-alg-CMS3DESwrap
```

#### PHP openssl_get_md_methods algorithms

As of PHP 7.0.25, OpenSSL 1.0.2k-fips  26 Jan 2017

digests : 
```
DSA, DSA-SHA
MD4, MD5, RIPEMD160
SHA, SHA1, SHA224, SHA256, SHA384, SHA512
dsaEncryption, dsaWithSHA
ecdsa-with-SHA1
md4, md5, ripemd160
sha, sha1, sha224, sha256, sha384, sha512
whirlpool
```
aliases : 
```
DSA-SHA1, DSA-SHA1-old, DSS1 
RSA-MD4, RSA-MD5, RSA-RIPEMD160 
RSA-SHA, RSA-SHA1, RSA-SHA1-2, RSA-SHA224, RSA-SHA256, RSA-SHA384, RSA-SHA512 
dsaWithSHA1, dss1 
md4WithRSAEncryption, md5WithRSAEncryption 
ripemd, ripemd160WithRSA, rmd160, 
sha1WithRSAEncryption, sha224WithRSAEncryption, sha256WithRSAEncryption 
sha384WithRSAEncryption, sha512WithRSAEncryption, shaWithRSAEncryption 
ssl2-md5, ssl3-md5, ssl3-sha1 
```


[Return](../../README.md)
