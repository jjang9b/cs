<?php
/*
  * Memory Cache Factory
  * @Author : itraveler@gmail.com
*/
//namespace ftt;

class Memcache {  

  public $debug = FALSE;
  
  function __construct() {
    //
  }
  
  public static function getClient($strClientType, $strDSN)
  {
    $CI =& get_instance();

    list($strConfigFile, $strConfigKey)= explode('.', $strDSN, 2);
    $CI->config->load($strConfigFile, true);
    $arrHostInfo = $CI->config->item($strConfigKey, $strConfigFile);

    $strVarName = strtolower('_FTT_MEMCACHE_'.$strDSN);

    switch ($strClientType)
    {
      case 'redisp' :
          $CI->load->library('ftt/Redisp', $arrHostInfo, $strVarName);
          break;
      case 'memcachep' :
      default :
          $CI->load->library('ftt/Memcachep', $arrHostInfo, $strVarName);
          //$CI->{$strVarName}->setHostInfo($arrHostInfo);
          break;
    }

    return $CI->{$strVarName};
  }

  public function debug($bool)
  {
    $this->debug = (bool) $bool;
  }

  ///////////////////////////////////////////////////////////////////////////////

  public function connect($strAddr, $nPort=11211, $nTimeout=1)/*{{{*/
  {
    return true;
  }/*}}}*/

  public function close()/*{{{*/
  {
    return true;
  }/*}}}*/

  //abstract 
  function add($strKey, $mixData, $nExpire=0){}
  //abstract 
  function replace($strKey, $mixData, $nExpire=0){}
  //abstract 
  function set($strKey, $mixData, $nExpire=0){}
  //abstract 
  function get($strKey){}
  //abstract 
  function increment($strKey, $nValue=1){}
  //abstract 
  function decrement($strKey, $nValue=1){}
  //abstract 
  function delete($strKey){}

  ///////////////////////////////////////////////////////////////////////////////

  public function addMulti($arrKeyData, $nExpire=0)/*{{{*/
  {
    $bResult = true;
    foreach ($arrKeyData as $strKey => $strData)
    {
      $arrResult[$strKey] = $this->add($strKey, $strData, $nExpire);
      if (!$arrResult[$strKey])
        $bResult = false;
    }

    return $bResult;
  }/*}}}*/

  public function replaceMulti($arrKeyData, $nExpire=0)/*{{{*/
  {
    $bResult = true;
    foreach ($arrKeyData as $strKey => $strData)
    {
      $arrResult[$strKey] = $this->replace($strKey, $strData, $nExpire);
      if (!$arrResult[$strKey])
        $bResult = false;
    }
    return $bResult;
  }/*}}}*/

  public function setMulti($arrKeyData, $nExpire=0)/*{{{*/
  {
    $bResult = true;
    foreach ($arrKeyData as $strKey => $val)
    {
      $arrResult[$strKey] = $this->set($strKey, $val, $nExpire);
      if (!$arrResult[$strKey])
        $bResult = false;
    }
    return $bResult;
  }/*}}}*/

  public function getMulti($arrKey)/*{{{*/
  {
    $arrResult = array();
    foreach ($arrKey as $nIdx => $strKey)
    {
      $arrResult[$strKey] = $this->get($strKey);
    }
    return $arrResult;
  }/*}}}*/

  public function incrementMulti($arrKey, $nValue=1)/*{{{*/
  {
    $arrResult = array();
    foreach ($arrKey as $nIdx => $strKey)
    {
      $arrResult[$strKey] = $this->increment($strKey, $nValue);
    }
    return $arrResult;
  }/*}}}*/

  public function decrementMulti($arrKey, $nValue=1)/*{{{*/
  {
    $arrResult = array();
    foreach ($arrKey as $nIdx => $strKey)
    {
      $arrResult[$strKey] = $this->decrement($strKey, $nValue);
    }
    return $arrResult;
  }/*}}}*/

  public function deleteMulti($arrKey, $nTimeout=0)/*{{{*/
  {
    $bResult = true;
    foreach ($arrKey as $nIdx => $strKey)
    {
      $arrResult[$strKey] = $this->delete($strKey, $nTimeout);
      if (!$arrResult[$strKey])
        $bResult = false;
    }
    return $bResult;
  }/*}}}*/

}
