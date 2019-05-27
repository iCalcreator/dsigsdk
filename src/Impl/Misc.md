## DsigSdk Misc. aid support

#### Password

###### Kigkonsult\DsigSdk\Impl\HmacHashFactory static method
* __oauth_totp__( (string) key, \[(int) time, \[(int) digits, \[(string) algorithm\]\]\])
  * time default PHP time()
  * digits default 8
  * algorithm as above,  default 'sha256' 
  * Return HMAC-based One-Time Password (HOTP) (rfc6238)  
  * Throws InvalidArgumentException on invalid algorithm 

###### Kigkonsult\DsigSdk\Impl\PKCSFactory static method

* __pbkdf2__( 
    (string) algorithm, 
    (string) password, 
    (string) salt, 
    (int) iterations, 
    [(int) keyLength, 
    [(bool) rawOutput]]]
  )
  * Algorithm ( [*hash_algos*](Hash.md)) 
  * iterations  default 1024
  * keyLength default 0
  * rawOutput default false 
  * Return a (PKCS #5) PBKDF2 key derivation of a supplied password
  * Throws InvalidArgumentException on invalid algorithm 

[Return](../../README.md)

