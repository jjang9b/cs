<?php
//namespace ftt
/** 
  * Key Chooser
  *
  * @package ftt
  * @version 1.0  
  * @author itraveler@gmail.com
*/
class KeyChooser
{
  public $arrKeyAll;
  public $nKeyCount;
  public $oHash;

  public function __construct($arrKeyAll=array())/*{{{*/
  {
    $this->setKeyAll($arrKeyAll);
    $CI =& get_instance();
    $CI->load->library('ftt/Hash', NULL, '_ftt_hash');
    $this->oHash = $CI->_ftt_hash;
  }/*}}}*/

  public function setKeyAll($arrKeyAll)/*{{{*/
  {
    $this->arrKeyAll = $arrKeyAll;
    $this->nKeyCount = count($arrKeyAll);
  }/*}}}*/

  public function getKeyIndex($strCurKey)/*{{{*/
  {
    if ($this->nKeyCount <= 0)
      return false;
    else if ($this->nKeyCount == 1)
      return 0;

    $nHash = $this->oHash->getHash($strCurKey, 8); // Do not change the hash type
    //echo $strCurKey.':'.$nHash.'='.($nHash % $this->nKeyCount).'<br>';

    return $nHash % $this->nKeyCount;
  }/*}}}*/

  public function getKeyData($strCurKey)/*{{{*/
  {
    $nKeyIndex = $this->getKeyIndex($strCurKey);

    return $this->arrKeyAll[$nKeyIndex];
  }/*}}}*/

}
