## DsigSdk hash aid support

###### Kigkonsult\DsigSdk\Impl\HashFactory static methods

* __assertAlgorithm__( (string) algorithm )
  * Return matching algorithm found using *hash_algos*
  * Throws InvalidArgumentException on not found 

* __generate__( algorithm, (string) data, \[(bool) rawOutput\] )
  * algorithm as above 
  * rawOutput default false
  * Return string hash based on given data
  * Throws InvalidArgumentException on invalid algorithm 
  
* __generateFile__( (string) algorithm, (string) fileName, \[(bool) rawOutput\] )
  * algorithm as above 
  * Supports fopen wrappers as filename
  * rawOutput default false
  * Return string hash based on contents of a given file
  * Throws InvalidArgumentException on invalid algorithm 
  
* __hashEquals__( (string) expected, (string) actual )
  * Return bool true if hashes match

[Return](../../README.md)


