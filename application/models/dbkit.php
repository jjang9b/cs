<?php
class DbKit extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getInstance($sDSN)
  {
    include (APPPATH . 'config/'.ENVIRONMENT.'/database.php');

    if(is_null($db[$sDSN]))
    {
      if(is_null($db[$sDSN.'_slave']) && is_null($db[$sDSN.'_master']))
      {
        echo 'not found database '.$sDSN;
        return NULL;
      }
      else
      {
        $sDbAccessType = (is_null($db[$sDSN.'_slave'])) ? '_master' : '_slave'; 
        $sDSN = $sDSN.$sDbAccessType;
      }
    }

    $sDbType = $db[$sDSN]['dbdriver'];

    if ($sDbType == 'mysqli')
      $sDbType = 'mysql';

    $sClassName = strtolower(__CLASS__).'_'.$sDbType;

    $this->load->model($sClassName);

    return $this->{$sClassName};
  }

  protected function _setError($sSubMessage='')
  {
    $CI =& get_instance();
    $CI->load->library('ftt/SimpleError');
    $oError = $CI->simpleerror->setError('SYS_DB_ERROR', ($sSubMessage? $sSubMessage : 'query fail'));
  }

  /* abstract methods */

  public function getListObject($sDSN, $aColumn, $sTableName, $aWhereType, $mWhereColumn, $mWhereVal, $nLimit=1000)
  {}

  public function getListArray($sDSN, $aColumn, $sTableName, $aWhereType, $mWhereColumn, $mWhereVal, $nLimit=1000)
  { 
    $oResult = $this->getListObject($sDSN, $aColumn, $sTableName, $aWhereType, $mWhereColumn, $mWhereVal, $nLimit);

    if(!is_null($oResult) && !empty($oResult))
    {
      $aResult = array();

      foreach ($oResult as $sResultvalue)
        array_push($aResult, get_object_vars($sResultvalue));

      return $aResult;
    }
   
    return $oResult;
  }

  public function getListObjectNowhere($sDSN, $aColumn, $sTableName, $nLimit=1000)
  {}

  public function getListArrayNowhere($sDSN, $aColumn, $sTableName, $nLimit=1000)
  {
    $oResult = $this->getListObjectNowhere($sDSN, $aColumn, $sTableName, $nLimit);

    if(!is_null($oResult) && !empty($oResult))
    {
      $aResult = array();

      foreach ($oResult as $sResultvalue)
        array_push($aResult, get_object_vars($sResultvalue));

      return $aResult;
    }
   
    return $oResult;
  }

  public function getOneRowObject($sDSN, $aColumn, $sTableName, $aWhereType, $mPrimaryKey, $mPrimaryVal)
  { 
    $aResult = $this->getListObject($sDSN, $aColumn, $sTableName, $aWhereType, $mPrimaryKey, $mPrimaryVal, 1);

    if (!empty($aResult))
      return current($aResult);

    return $aResult;
  }

  public function getOneRowArray($sDSN, $aColumn, $sTableName, $aWhereType, $mPrimaryKey, $mPrimaryVal)
  {
    $oResult = $this->getOneRowObject($sDSN, $aColumn, $sTableName, $aWhereType, $mPrimaryKey, $mPrimaryVal);

    if (!is_null($oResult) && !empty($oResult))
    {
      $aResult = get_object_vars($oResult);
      return $aResult;
    }
   
    return $oResult;
  }

  public function setUpdate($sDSN, $sTableName, $sEditColumnName, $sEditColumnValue, $aWhereType, $mWhereColumn, $mWhereVal)
  {}

  public function setInsert($sDSN, $sTableName, $mInsertColumn, $mInsertVal)
  {}

  public function getTableList($sDSN)
  {}

  public function getColumnList($sDSN, $sTableName)
  {}

  public function getPrimaryList($sDSN, $sTableName)
  {}

  public function callProcedure($sDSN, $sProcedureName, $aParam)
  {}
}
