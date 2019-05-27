## hmac hash aid support

Dsig (rfc4051) SignatureMethod Message Authentication Code Algorithms : 
```
md5, sha224, sha256, sha384, sha512, ripemd160
```

###### Kigkonsult\DsigSdk\Impl\HmacHashFactory static methods

* __assertAlgorithm__( (string) algorithm )
  * Return matching algorithm found using *hash_hmac_algos*, if installed, else [*hash_algos*](Hash.md)
  * Throws InvalidArgumentException on not found 

---

* __generate__( algorithm, (string) data, (string) secret, \[(bool) rawOutput\] )
  * algorithm as above 
  * rawOutput default false
  * Return string hash
  * Throws InvalidArgumentException on invalid algorithm 
  
* __generateMd5__( (string) data, (string) secret, \[(bool) rawOutput\] )
  * Alias for *generate* using algorithm MD5
  * Return string hash based on given data and secret

* __generateSha224__( (string) data, (string) secret, \[(bool) rawOutput\] )
  * Alias for *generate* using algorithm sha224
  * Return string hash based on given data and secret

* __generateSha256__( (string) data, (string) secret, \[(bool) rawOutput\] )
  * Alias for *generate* using algorithm sha256
  * Return string hash based on given data and secret

* __generateSha384__( (string) data, (string) secret, \[(bool) rawOutput\] )
  * Alias for *generate* using algorithm sha384
  * Return string hash based on given data and secret

* __generateSha512__( (string) data, (string) secret, \[(bool) rawOutput\] )
  * Alias for *generate* using algorithm sha512
  * Return string hash based on given data and secret

* __generateRipemd160__( (string) data, (string) secret, \[(bool) rawOutput\] )
  * Alias for *generate* using algorithm ripemd160
  * Return string hash based on given data and secret
  
---

* __generateFile__( algorithm, (string) fileName, (string) secret, \[(bool) rawOutput\] )
  * algorithm as above 
  * Supports fopen wrappers as filename
  * rawOutput default false
  * Return string hash based on contents of a given file and secret
  * Throws InvalidArgumentException on invalid algorithm 
  
* __generateFileMd5__( (string) fileName, (string) secret, \[(bool) rawOutput\] )
  * Alias for *generateFile* using algorithm MD5
  * Supports fopen wrappers as filename
  * Return string hash based on contents of a given file and secret
  
* __generateFileSha224__( (string) fileName, (string) secret, \[(bool) rawOutput\] )
  * Alias for *generateFile* using algorithm sha224
  * Supports fopen wrappers as filename
  * Return string hash based on contents of a given file and secret
  
* __generateFileSha256__( (string) fileName, (string) secret, \[(bool) rawOutput\] )
  * Alias for *generateFile* using algorithm sha256
  * Supports fopen wrappers as filename
  * Return string hash based on contents of a given file and secret
  
* __generateFileSha384__( (string) fileName, (string) secret, \[(bool) rawOutput\] )
  * Alias for *generateFile* using algorithm sha384
  * Supports fopen wrappers as filename
  * Return string hash based on contents of a given file and secret
  
* __generateFileSha512__( (string) fileName, (string) secret, \[(bool) rawOutput\] )
  * Alias for *generateFile* using algorithm sha512
  * Supports fopen wrappers as filename
  * Return string hash based on contents of a given file and secret
  
* __generateFileRipemd160__( (string) fileName, (string) secret, \[(bool) rawOutput\] )
  * Alias for *generateFile* using algorithm ripemd160
  * Supports fopen wrappers as filename
  * Return string hash based on contents of a given file and secret

---
  
* __hashEquals__( (string) expected, (string) actual )
  * Return bool true if hashes match

---
  
* __oauth_totp__( (string) key, \[(int) time, \[(int) digits, \[(string) algorithm\]\]\])
  * time default PHP time()
  * digits default 8
  * algorithm as above,  default 'sha256' 
  * Return HMAC-based One-Time Password (HOTP) (rfc6238)  
  * Throws InvalidArgumentException on invalid algorithm 

[Return](../../README.md)
