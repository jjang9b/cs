<?php
require_once APPPATH . 'models/dbkit.php';

class CsBase_dao extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('dbkit');
  }

  public function getListArray($aTableInfo, $mParamData, $aWhereType)
  {
    $oDao = $this->dbkit->getInstance($aTableInfo['dsn']);

    return $oDao->getListArray($aTableInfo['dsn'], $aTableInfo['column'], $aTableInfo['table'], $aWhereType, $aTableInfo['whereColumn'], $mParamData);
  }

  public function getListObject($aTableInfo, $mParamData, $aWhereType)
  {
    $oDao = $this->dbkit->getInstance($aTableInfo['dsn']);

    return $oDao->getListObject($aTableInfo['dsn'], $aTableInfo['column'], $aTableInfo['table'], $aWhereType, $aTableInfo['whereColumn'], $mParamData);
  }

  public function getListAll($aTableInfo, $mParamData, $aWhereType, $sListAllType, $nLimit=1000)
  {
    $oDao = $this->dbkit->getInstance($aTableInfo['dsn']);

    if($sListAllType == 'all')
      return $oDao->getListObjectNowhere($aTableInfo['dsn'], $aTableInfo['column'], $aTableInfo['table'], $nLimit);
    else
      return $oDao->getListArray($aTableInfo['dsn'], $aTableInfo['column'], $aTableInfo['table'], $aWhereType, $aTableInfo['whereColumn'], $mParamData);
  }

  public function getListOne($aTableInfo, $mParamData, $aWhereType)
  {
    $oDao = $this->dbkit->getInstance($aTableInfo['dsn']);

    return $oDao->getOneRowArray($aTableInfo['dsn'], $aTableInfo['column'], $aTableInfo['table'], $aWhereType, $aTableInfo['whereColumn'], $mParamData);
  }

  public function setUpdate($aTableInfo, $sEditColumnType, $sEditColumnName, $sEditColumnValue, $aWhereType, $aPrimaryColumn, $aPrimaryValue)
  {
    $oDao = $this->dbkit->getInstance($aTableInfo['dsn']);

    return $oDao->setUpdate($aTableInfo['dsn'], $aTableInfo['table'], $sEditColumnType, $sEditColumnName, $sEditColumnValue, $aWhereType, $aPrimaryColumn, $aPrimaryValue);
  }

  public function setUpdateArray($aTableInfo, $aUpdateArray, $aWhereType, $mWhereColumn, $mWhereVal)
  {
    $oDao = $this->dbkit->getInstance($aTableInfo['dsn']);

    return $oDao->setUpdateArray($aTableInfo['dsn'], $aTableInfo['table'], $aUpdateArray, $aWhereType, $mWhereColumn, $mWhereVal);
  }

  public function setInsert($aTableInfo, $mInsertColumn, $mInsertVal)
  {

    $oDao = $this->dbkit->getInstance($aTableInfo['dsn']);

    return $oDao->setInsert($aTableInfo['dsn'], $aTableInfo['table'], $mInsertColumn, $mInsertVal);
  }

  public function getColumnList($sDSN, $sTableName)
  {
    $oDao = $this->dbkit->getInstance($sDSN);

    return $oDao->getColumnList($sDSN, $sTableName);
  }

  public function getPrimaryList($sDSN, $sTableName)
  {
    $oDao = $this->dbkit->getInstance($sDSN);

    return $oDao->getPrimaryList($sDSN, $sTableName);
  }

  public function callProcedure($sDSN, $sProcedureName, $aInputParam, $aOutputParam=null)
  {
    $oDao = $this->dbkit->getInstance($sDSN);

    return $oDao->callProcedure($sDSN, $sProcedureName, $aInputParam, $aOutputParam);
  }
}
