<?php

class DbKit_Mysql extends Dbkit 
{
  public function __construct()
  {
    parent::__construct();

    $this->sLimit = 1001;

    $this->load->library('ftt/util/debug');
  }

  public function getListObjectNowhere($sDSN, $aColumn, $sTableName)
  { 
    (strpos($sDSN, '_slave') || strpos($sDSN, '_master')) ? 
      $this->load->database($sDSN) : $this->load->database($sDSN.'_slave');

    $sQueryColumn = implode(', ', $aColumn);
    $sQueryWhere = '';
    $aRows = array();

    $query = 'SELECT '.$sQueryColumn.'
              FROM '.$this->db->database.'.'.$sTableName.'
              LIMIT 0, '.$this->sLimit;

    $this->debug->console(array('select_'.$sTableName.'_query'=>$query, 'select_'.$sTableName.'param'=>$aParam));

    if ($cursor = $this->db->query($query, '', true, ''))
    {
      $aRows = $cursor->result('object');

    }
    else
      $this->_setError(__METHOD__. ' : ' . $query);

    $cursor->free_result();
    $this->db->close();

    return $aRows;
  }

  public function getListObject($sDSN, $aColumn, $sTableName, $aWhereType, $mWhereColumn, $mWhereVal)
  { 
    (strpos($sDSN, '_slave') || strpos($sDSN, '_master')) ? 
      $this->load->database($sDSN) : $this->load->database($sDSN.'_slave');

    $sQueryColumn = implode(', ', $aColumn);
    $sQueryWhere = '';
    $aTmp = array();
    $aTypeTmp = array();
    $aRows = array();

    if (!is_array($mWhereColumn))
      $mWhereColumn = array($mWhereColumn);


    for ($i=0, $j=count($mWhereColumn); $i<$j; $i++)
    {
      $aTmp[] = $mWhereColumn[ $i ].$aWhereType[ $i ];
    }

    $sQueryWhere = implode(' AND ', $aTmp);

    if (is_array($mWhereVal))
      $aParam = array_values($mWhereVal);
    else
      $aParam = array($mWhereVal);

    $aParam[] = $this->sLimit;

    foreach ($aParam as $mCurVal)
    {
      if( gettype( $mCurVal ) == 'string' )
        $aTypeTmp[] = 's';
      else
        $aTypeTmp[] = 'i';
    }

    $sParamType = implode('', $aTypeTmp);

    $query = 'SELECT '.$sQueryColumn.'
              FROM '.$this->db->database.'.'.$sTableName.'
              WHERE '.$sQueryWhere.' 
              LIMIT 0, ?';

    $this->debug->console(array('select_'.$sTableName.'_query'=>$query, 'select_'.$sTableName.'param'=>$aParam));

    if ($cursor = $this->db->query($query, $aParam, true, $sParamType))
      $aRows = $cursor->result('object');
    else
      $this->_setError(__METHOD__. ' : '.$query);

    $cursor->free_result();
    $this->db->close();

    return $aRows;
  }

  public function setUpdate($sDSN, $sTableName, $sEditColumnType, $sEditColumnName, $sEditColumnValue, $aWhereType, $mWhereColumn, $mWhereVal)
  {
    (strpos($sDSN, '_slave') || strpos($sDSN, '_master')) ? 
      $this->load->database($sDSN) : $this->load->database($sDSN.'_master');

    $sQueryWhere = '';
    $aTmp = array();
    $aTypeTmp = array();
    $sAffectRows = 0;

    if (!is_array($mWhereColumn))
      $mWhereColumn = array($mWhereColumn);

    for ($i=0, $j=count($mWhereColumn); $i<$j; $i++)
    {
      $aTmp[] = $mWhereColumn[ $i ].$aWhereType[ $i ];
    }

    $sQueryWhere = implode(' AND ', $aTmp);

    if (is_array($mWhereVal))
      $aParam = array_values($mWhereVal);
    else
      $aParam = array($mWhereVal);

    foreach($aParam as $sVal)
      $sVal = trim($sVal);

    foreach ($aParam as $mCurVal)
    {
      if( gettype( $mCurVal ) == 'string' )
        $aTypeTmp[] = 's';
      else
        $aTypeTmp[] = 'i';
    }

    $sParamType = implode('', $aTypeTmp);

    if($sEditColumnType == 1)
    {
      $query = 'UPDATE %s SET %s = %s + %s WHERE '.$sQueryWhere;
      $sSprintQuery = sprintf($query, $sTableName, $sEditColumnName, $sEditColumnName, $sEditColumnValue);
    }
    else
    {
      $query = 'UPDATE %s SET %s = "%s" WHERE '.$sQueryWhere;
      $sSprintQuery = sprintf($query, $sTableName, $sEditColumnName, $sEditColumnValue);
    }

    $this->debug->console(array('update_query'=>$sSprintQuery, 'update_param'=>$aParam));

    if($this->db->query($sSprintQuery, $aParam, true, $sParamType))
      $sAffectRows = $this->db->affected_rows();
    else
      $this->_setError(__METHOD__. ' : '.$query);

    $this->db->close();

    return $sAffectRows;
  }

  public function setInsert($sDSN, $sTableName, $mInsertColumn, $mInsertVal)
  {
    (strpos($sDSN, '_slave') || strpos($sDSN, '_master')) ? 
      $this->load->database($sDSN) : $this->load->database($sDSN.'_master');

    $aTmp = array();
    $aValTmp = array();
    $sAffectRows = 0;

    if (!is_array($mInsertColumn))
      $mInsertColumn = array($mInsertColumn);

    $sQueryColumn = implode(', ', $mInsertColumn);

    if (is_array($mInsertVal))
      $aParam = array_values($mInsertVal);
    else
      $aParam = array($mInsertVal);

    foreach($aParam as $sVal)
      $sVal = trim($sVal);

    foreach ($mInsertVal as $mCurVal)
    {
      if( gettype( $mCurVal ) == 'string' )
        $aTmp[] = 's';
      else
        $aTmp[] = 'i';

      $aValTmp[] = '?';
    }

    $sParamType = implode('', $aTmp);
    $sQueryVal = implode(', ', $aValTmp);

    $query = 'INSERT INTO %s( %s ) VALUES( %s )';

    $this->debug->console(array('insert_query'=>sprintf($query, $sTableName, $sQueryColumn, $sQueryVal), 'insert_param'=>$aParam));

    if($this->db->query(sprintf($query, $sTableName, $sQueryColumn, $sQueryVal), $aParam, true, $sParamType))
      $sAffectRows = $this->db->affected_rows();
    else
      $this->_setError(__METHOD__. ' : '.$query);

    $this->db->close();

    return $sAffectRows;
  }

  public function callProcedure($sDSN, $sProcedureName, $aParam)
  {
    (strpos($sDSN, '_slave') || strpos($sDSN, '_master')) ? 
      $this->load->database($sDSN) : $this->load->database($sDSN.'_master');

    $aRow = null;
    $aTmp = array();
    $aValTmp = array();

    foreach($aParam as $mParamVal)
    {
      if( gettype($mParamVal) == 'string' )
        $aTmp[] = 's';
      else
        $aTmp[] = 'i';

      $aValTmp[] = '?';
    }

    $sParamType = implode('', $aTmp);
    $sBindVal = implode(', ', $aValTmp);

    $query = "CALL %s( %s )";

    $this->debug->console(array('call_query'=>sprintf($query, $sProcedureName, $sBindVal), 'call_param'=>$aParam));

    if ($cur = $this->db->query(sprintf($query, $sProcedureName, $sBindVal), $aParam, true, $sParamType))
      $aRow = $cur->row_array();
    else
      $this->_setError(__METHOD__. ' : '.$query);

    $cur->free_result();
    $this->db->close();

    return $aRow;
  }

  public function getTableList($sDSN)
  {
    (strpos($sDSN, '_slave') || strpos($sDSN, '_master')) ? 
      $this->load->database($sDSN) : $this->load->database($sDSN.'_slave');

    $aResult = array();

    $query = "SELECT table_name FROM information_schema.tables 
              WHERE table_type = 'BASE TABLE' AND table_schema = '%s'";

    $this->debug->console(array('getTableList_query'=>sprintf($query, $this->db->database), 'getTableList_param'=>''));

    if($cur = $this->db->query(sprintf($query, $this->db->database)))
    {
      $aRows = $cur->result('array'); 

      if(!empty($aRows))
      {
        foreach ($aRows as $v)
          $aResult[] = $v[ 'table_name' ];
      }
    } 
    else 
      $this->_setError(__METHOD__. ' : '.sprintf($query, $this->db->database));

    $cur->free_result();
    $this->db->close();

    return $aResult;
  }

  public function getColumnList($sDSN, $sTableName)
  {
    (strpos($sDSN, '_slave') || strpos($sDSN, '_master')) ? 
      $this->load->database($sDSN) : $this->load->database($sDSN.'_slave');

    $aResult = array();

    $query = "SELECT a.column_name, a.column_default, a.is_nullable, a.data_type, a.character_maximum_length AS max_len,
                IF( b.column_name IS NOT NULL, 'Y', 'N' ) AS is_primary, a.column_comment
              FROM information_schema.columns AS a
              LEFT JOIN information_schema.key_column_usage AS b ON a.column_name = b.column_name
              AND a.table_name = b.table_name AND b.CONSTRAINT_SCHEMA = '%s'
              WHERE a.table_name ='%s' and a.table_schema = '%s'";

    $this->debug->console(array('getColumnList_query'=>sprintf($query,$this->db->database, $sTableName, $this->db->database), 'getColumnList_param'=>''));

    if($cur = $this->db->query(sprintf($query,$this->db->database, $sTableName, $this->db->database)))
      $aResult = $cur->result();
    else 
      $this->_setError(__METHOD__. ' : '.sprintf($query, $sTableName));

    $cur->free_result();
    $this->db->close();

    return $aResult;
  }

  public function getPrimaryList($sDSN, $sTableName)
  {
    (strpos($sDSN, '_slave') || strpos($sDSN, '_master')) ? 
      $this->load->database($sDSN) : $this->load->database($sDSN.'_slave');

    $aRows = array();

    $query = "SELECT column_name FROM information_schema.key_column_usage
              WHERE table_name = '%s' AND CONSTRAINT_SCHEMA = '%s' AND
              ( CONSTRAINT_NAME = '%s' OR CONSTRAINT_NAME like '%s' )";

    $this->debug->console(array('primary_query'=>sprintf($query, $sTableName, $this->db->database, 'PRIMARY', 'UNIQUE'), 'column_param'=>''));

    if($cur = $this->db->query(sprintf($query, $sTableName, $this->db->database, 'PRIMARY', 'UNIQUE')))
      $aRows = $cur->result('array');
    else 
      $this->_setError(__METHOD__. ' : '.sprintf($query, $sTableName));

    $cur->free_result();
    $this->db->close();

    return $aRows;
  }
}
