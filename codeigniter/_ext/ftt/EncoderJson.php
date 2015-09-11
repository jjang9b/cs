<?php
/*
  * Php Serializer 
  * @Author : itraveler@gmail.com
*/
//namespace ftt;

class EncoderJson extends Encoder {  

  function __construct() {
    //
  }
  
  public function encode($mixData)
  {
    $strResult = json_encode($mixData);
    if ($this->nZipType == 1)
      $strResult = gzcompress($strResult, 9);

    return $strResult;
  }

  public function decode($mixData)
  {
    if ($this->nZipType == 1 && !empty($mixData))
      return json_decode(gzuncompress($mixData));

    return json_decode($mixData);
  }
}
