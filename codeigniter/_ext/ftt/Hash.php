<?php
//namespace ftt
/** 
  * Hash Algorithm
  *
  * @package ftt
  * @version 1.0  
  * @author itraveler@gmail.com
  * @ref https://github.com/dustin/java-memcached-client/blob/7b4b62e1b41c8beaf1bf54ca8d06f08ffb686b58/src/main/java/net/spy/memcached/DefaultHashAlgorithm.java
*/
class Hash
{
  const NATIVE_HASH   = 1;
  const CRC_HASH      = 2; 
  const FNV1_64_HASH  = 3;
  const FNV1A_64_HASH = 4;
  const FNV1_32_HASH  = 5;
  const FNV1A_32_HASH = 6;
  const KETAMA_HASH   = 7;
  const JENKINS_HASH  = 8;

  public function getHash($strKey, $nHashType=8)
  {
    $nHashVal = 0;
    $nSize = strlen($strKey);

    switch ($nHashType)
    {
      case self::JENKINS_HASH :  // Jenkins's one-at-a-time hash
      default :
              for ($i=0; $i<$nSize; $i++)
              {
                //echo '==='.$strKey[$i].':'. ord($strKey[$i]).'===';
                $nHashVal += (ord($strKey[$i]) & 0xFF);
                $nHashVal += ($nHashVal << 10);
                $nHashVal ^= (($nHashVal >> 6) & (PHP_INT_MAX >> 5));
              }
              $nHashVal += ($nHashVal << 3);
              $nHashVal ^= (($nHashVal >> 11) & (PHP_INT_MAX >> 10)); 
              $nHashVal += ($nHashVal << 15);
    }

    return $nHashVal & 0xffffffff;
  }

  /*
  function _logical_right_shift( $int , $shft ) {
    return ( $int >> $shft )   //Arithmetic right shift
             & ( PHP_INT_MAX >> ( $shft - 1 ) );   //Deleting unnecessary bits
  }
  */
}
