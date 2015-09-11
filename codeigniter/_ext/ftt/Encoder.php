<?php
/*
  * Data Encoder
  * @Author : itraveler@gmail.com
*/
//namespace ftt;

class Encoder {  

  public $nZipType = 0;

  function __construct() {
    //
  }
  
  public static function getClient($strType = 'php')
  {
    $CI =& get_instance();
    $strVarName = strtolower('_FTT_ENCODER_'.$strType);

    switch ($strType)
    {
      case 'json' :
          $CI->load->library('ftt/EncoderJson', NULL, $strVarName);
          break;
      case 'php' :
      default :
          $CI->load->library('ftt/EncoderPhp', NULL, $strVarName);
          break;
    }

    return $CI->{$strVarName};
  }

  ///////////////////////////////////////////////////////////////////////////////

  //abstract 
  function encode($mixData){}
  //abstract 
  function decode($mixData){}

  ///////////////////////////////////////////////////////////////////////////////

  public function setZipType($nType)
  {
    if ($nType == 1)
    {
      if (function_exists("gzcompress"))
        $this->nZipType = $nType;
    }
  }
}
