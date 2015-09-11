<?php
/*
  * Php Serializer 
  * @Author : itraveler@gmail.com
*/
//namespace ftt;

class EncoderPhp extends Encoder {  

  function __construct() {
    //
  }
  
  public function encode($mixData)
  {
    $strResult = serialize($mixData);
    if ($this->nZipType == 1)
      $strResult = gzcompress($strResult, 9);

    return $strResult;
  }

  public function decode($mixData)
  {
    if ($this->nZipType == 1 && !empty($mixData))
      return unserialize(gzuncompress($mixData));

    return unserialize($mixData);
  }
}
