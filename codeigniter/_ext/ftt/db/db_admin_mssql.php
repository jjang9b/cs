<?php

class Db_Admin_Mssql extends Db_Admin
{
  /*
  public function __construct()
  {
    parent::__construct();
  }
  */

  public function getListObjectNowhere($sDSN, $aColumn, $sTableName)
  { 
    (strpos($sDSN, '_slave') || strpos($sDSN, '_master')) ? 
      $this->load->database($sDSN) : $this->load->database($sDSN.'_slave');

    $sQueryColumn = implode(', ', $aColumn);
    $sQueryWhere = '';
    $aRows = array();

    $query = 'SELECT TOP '.$this->nLimit.' '.$sQueryColumn.'
              FROM '.$this->db->database.'.'.$sTableName;

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

    foreach ($aParam as $mCurVal)
    {
      if( gettype( $mCurVal ) == 'string' )
        $aTypeTmp[] = 's';
      else
        $aTypeTmp[] = 'i';
    }

    $sParamType = implode('', $aTypeTmp);

    $query = 'SELECT TOP '.$this->nLimit.' '.$sQueryColumn.'
              FROM '.$this->db->database.'.'.$sTableName.'
              WHERE '.$sQueryWhere.'';

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

    if($this->db->query(sprintf($query, $sTableName, $sQueryColumn, $sQueryVal), $aParam, true, $sParamType))
      $sAffectRows = $this->db->affected_rows();
    else
      $this->_setError(__METHOD__. ' : '.$query);

    $this->db->close();

    return $sAffectRows;
  }

  public function callProcedure($sDSN, $sProcedureName, $aParam)
  {
    $this->load->database($sDSN);

    $aValTmp = array();

    foreach($aParam as $sParamVal)
      $aValTmp[] = '?';

    $sBindVal = implode(', ', $aValTmp);

    $query = "EXEC %s %s";

    if ($cur = $this->db->query(sprintf($query, $sProcedureName, $sBindVal), $aParam))
    {
      $aRows = $cur->result('array');

      if(!empty($aRows))
      {
        foreach ($aRows as $aCurRow)
          $aResult[] = $aCurRow;
      }
    } 
    else
      $this->_setError(__METHOD__. ' : '.$query);

    $cur->free_result();
    $this->db->close();

    return $aResult;
  }

  public function getTableList($sDSN)
  {
    $this->load->database( $sDSN, false, true );
    $query = "SELECT table_name FROM [INFORMATION_SCHEMA].[TABLES] WHERE TABLE_TYPE = 'BASE TABLE'"; 

    $aResult = array();
    if ($cursor = $this->db->query($query, array(), true, ''))
    {
      $aRows = $cursor->result('array'); // 
      if (!empty($aRows))
      {
        foreach ($aRows as $aCurRow)
          $aResult[] = $aCurRow['table_name'];
      }
      return $aResult;
    }

    $this->_setError(__METHOD__);
    return array();
  }

  public function getColumnList($sDSN, $sTableName)
  {
    $this->load->database( $sDSN, false, true );

    $aResult = array();
    $query = "SELECT column_name
              FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
              WHERE OBJECTPROPERTY(OBJECT_ID(constraint_name), 'IsPrimaryKey') = 1
                    AND table_name = ?";
    $aParam = array($sTableName);
    $sPrimaryColumn = '';

    if ($cursor = $this->db->query($query, $aParam, true, ''))
    {
      $aRows = $cursor->result('array');
      if (!is_null($aRows[0]))
        $sPrimaryColumn = $aRows[0]['column_name'];
    }
    else
    {
      $this->_setError(__METHOD__);
      return $aResult;
    }

    $query = "SELECT column_name, column_default, is_nullable, data_type, CHARACTER_MAXIMUM_LENGTH as max_len 
              FROM [".$this->db->database."].[INFORMATION_SCHEMA].[COLUMNS] 
              WHERE TABLE_NAME = ?";

    if ($cursor = $this->db->query($query, $aParam, true, ''))
    {
      $aRows = $cursor->result('object'); // 

      foreach ($aRows as $oCurRow)
      {
        if (strtoupper($oCurRow->is_nullable) == 'NO')
          $oCurRow->is_nullable = 'N';
        else
          $oCurRow->is_nullable = 'Y';

        if ($oCurRow->column_name == $sPrimaryColumn)
          $oCurRow->is_primary = 'Y';
        else
          $oCurRow->is_primary = 'N';

        $aResult[] = $oCurRow;
      }
    }
    else
    {
      $this->_setError(__METHOD__);
    }

    return $aResult;
  }

  public function getPrimaryList($sDSN, $sTableName)
  {
    (strpos($sDSN, '_slave') || strpos($sDSN, '_master')) ? 
      $this->load->database($sDSN) : $this->load->database($sDSN.'_slave');

    $aRows = array();

    $query = "SELECT column_name 
              FROM information_schema.key_column_usage
              WHERE OBJECTPROPERTY(OBJECT_ID(CONSTRAINT_NAME), 'ISPRIMARYKEY') = 1
                AND TABLE_NAME = %s AND CONSTRAINT_CATALOG = %s";

    if($cur = $this->db->query(sprintf($query, $sTableName, $this->db->database)))
      $aRows = $cur->result('array');
    else 
      $this->_setError(__METHOD__. ' : '.sprintf($query, $sTableName));

    $cur->free_result();
    $this->db->close();

    return $aRows;
  }
}
