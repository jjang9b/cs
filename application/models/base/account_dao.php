<?php
require_once APPPATH . 'models/base/csbase_dao.php';

class Account_dao extends CsBase_dao
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getAccountIdx($aTableInfo, $sWhereColumn, $sSearchValue, $aWhereType)
  {
    $oDao = $this->dbkit->getInstance($aTableInfo['dsn']);

    return $oDao->getListArray($aTableInfo['dsn'], $aTableInfo['column'], $aTableInfo[ 'table' ], $aWhereType, $sWhereColumn, $sSearchValue);
  }
}
