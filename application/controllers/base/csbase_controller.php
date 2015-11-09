<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CsBase_Controller extends Base_Controller // CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->sCookieId = 'cstool_session_qwerty_123_id';
    $this->load->helper('url');
    $sUrl = uri_string();
    $this->url = explode('/', $sUrl);

    $this->load->model('base/csbase_dao');
    $this->load->config('config');

    $this->aViewData = array(
      'url'=>$this->url,
      'isDev'=>(ENVIRONMENT == 'development') ? true : false,
      'sViewMaxCount'=>1000
    );

    if($this->url[0] && $this->url[0] != 'main')
    {
      $this->load->helper('cookie');

      $this->_setSSN();
      $this->load->library('ftt/util/debug');
      $this->sDebugConsole = true;
      $this->aViewData['aMenuList'] = ftt_get_config('menu', $this->url[ 0 ].'/menu');
      $this->aViewData['sDebugConsole'] = $this->sDebugConsole;

      self::checkSetAuth();
    }
  }

  protected function _setSSN()
  {
    $aPathInfo = explode('/', trim($_SERVER['PATH_INFO'], '/'));
    $this->ssn = $aPathInfo[0];
  }

  public function getDebug()
  {
    if($this->sDebugConsole)
    {
      $this->load->library('session');
      $aResultData = $this->session->all_userdata();

      unset($aResultData['ip_address']);
      unset($aResultData['last_activity']);
      unset($aResultData['session_id']);
      unset($aResultData['user_agent']);
      unset($aResultData['user_data']);

      echo json_encode($aResultData);
    }
  }

  public function submitViewOneTable()
  {
    $aParam = $this->input->post();

    if($aParam[ 'pTableName' ])
    {
      $aInfoAll = $this->config->item($aParam[ 'pTableType' ]); 
      $aTableInfo = $aInfoAll[ $aParam[ 'pTableName' ] ];
      $aWhereValParam = explode('|', $aParam[ 'pWhereValParam' ]);

      $aResultData = $this->csbase_dao->getListAll($aTableInfo, $aWhereValParam, $this->aWhereType, $this->sListAllType);

      self::viewOneTableView($aResultData, $aParam, $aWhereValParam, $aTableInfo);
    }
  }

  protected function viewOneTableView($aResultData, $aParam, $aWhereValParam, $aTableInfo)
  {
    $aResultView = $this->getViewData($aResultData, $aParam[ 'pTableType' ], $aTableInfo); 

    $this->aViewData[ 'aResultView' ] = $aResultView;
    $this->aViewData[ 'sCurrentTable' ] = $aTableInfo[ 'table' ];
    $this->aViewData[ 'aWhereValParam' ] = implode('|', $aWhereValParam);
    $this->aViewData[ 'sTableType' ] = $aParam[ 'pTableType' ];
    $this->aViewData[ 'sSearchType' ] = $aParam[ 'pSearchType' ];

    $this->layout_view('/common/template/one_table.php', $this->aViewData, $this->sDefaultView);
  }

  public function submitSaveExcel()
  {
    $aParam = $this->input->post();

    if($aParam[ 'pTableName' ])
    {
      $aInfoAll = $this->config->item($aParam[ 'pTableType' ]); 
      $aTableInfo = $aInfoAll[ $aParam[ 'pTableName' ] ];
      $aWhereValParam = explode('|', $aParam[ 'pWhereValParam' ]);

      $aResultData = $this->csbase_dao->getListAll($aTableInfo, $aWhereValParam, $this->aWhereType, $this->sListAllType);

      self::saveExcelMake($aResultData, $aTableInfo);
    }
  }

  protected function saveExcelMake($aResultData, $aTableInfo)
  {
    $fileName = 'cs_'.$this->url[ 1 ].'_'.date( 'Ymd' ).'.xls';

    $aExcelTable = '<table><tr style="background-color:#000">'; 

    foreach ($aTableInfo[ 'columnText' ] as $sColumnText)
    {
      $aExcelTable .= '<td style="color:#fff">'.$sColumnText.'</td>';
    }

    $aExcelTable .= '</tr>';

    foreach ($aResultData as $aValue)
    {
      $aExcelTable .= '<tr>';
      foreach ($aValue as $sValue)
      {
        $aExcelTable .= '<td style="text-align:center">'.$sValue.'</td>';
      }
      $aExcelTable .= '</tr>';
    }

    $aExcelTable .= '</tr></table>';

    header("Content-type: application/vnd.ms-excel; charset=utf-8"); 
    header("Content-Disposition: attachment; filename=".$fileName);
    print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">");

    print_r($aExcelTable);
  }

  public function submitShowEditColumn()
  {
    $aParam = $this->input->post();

    if($aParam[ 'pTableName' ])
    {
      $aInfoAll = $this->config->item($aParam[ 'pTableType' ]); 

      $aTableInfo = $aInfoAll[ $aParam[ 'pTableName' ] ];

      $aPrimaryStr = explode(',', $aParam[ 'pPrimaryString' ]);
      $aPrimaryColumn = array();
      $aPrimaryValue = array();

      foreach ($aPrimaryStr as $sPriStr)
      {
        list($sCol, $sVal) = explode('|', $sPriStr);

        array_push($aPrimaryColumn, $sCol);
        array_push($aPrimaryValue, $sVal);
      }

      $aTableInfo[ 'whereColumn' ] = $aPrimaryColumn;
      $aSearchValue = $aPrimaryValue;

      $aColumnList = $this->csbase_dao->getColumnList($aParam[ 'pDsn' ], $aParam[ 'pTableName' ]);
      $aResultData = $this->csbase_dao->getListOne($aTableInfo, $aSearchValue, $this->aWhereType);
    }

    $this->aViewData[ 'aTableInfo' ] = $aTableInfo;
    $this->aViewData[ 'aResultData' ] = $aResultData;
    $this->aViewData[ 'aColumnList' ] = $aColumnList;
    $this->aViewData[ 'aPrimaryColumn' ] = $aPrimaryColumn;
    $this->aViewData[ 'aPrimaryValue' ] = $aPrimaryValue;
    $this->aViewData[ 'sMenuName' ] = $aParam[ 'pMenuName' ];
    $this->aViewData[ 'sTableType' ] = $aParam[ 'pTableType' ];
    $this->aViewData[ 'sTableName' ] = $aParam[ 'pTableName' ];
    $this->aViewData[ 'sColumnName' ] = $aParam[ 'pColumnName' ];
    $this->aViewData[ 'sColumnText' ] = $aTableInfo[ 'columnText' ][ $aParam[ 'pColumnName' ] ];

    $this->layout_view('/common/template/window_edit.php', $this->aViewData, 'window');
  }

  public function submitEditValue()
  {
    $aParam = $this->input->post();

    $aInfoAll = $this->config->item($aParam[ 'pTableType' ]); 
    $aTableInfo = $aInfoAll[ $aParam[ 'pTableName' ] ];

    $sAffectedRows = 0;

    if($aParam[ 'pPrimaryColumn' ] && $aParam[ 'pPrimaryValue' ] && !is_null($aParam[ 'pEditValue' ]))
    {
      $sAffectedRows = $this->csbase_dao->setUpdate($aTableInfo, $aParam[ 'pColumnType' ], $aParam[ 'pColumnName' ], $aParam[ 'pEditValue' ], 
        $this->aWhereType, $aParam[ 'pPrimaryColumn' ], $aParam[ 'pPrimaryValue' ]);
    }

    if($sAffectedRows > 0)
		{
      $sConfigWhereColumn = $aTableInfo[ 'whereColumn' ][0];
      $aTableInfo[ 'whereColumn' ] = $aParam[ 'pPrimaryColumn' ];
			$aSearchValue = $aParam[ 'pPrimaryValue' ];

			$aResultData = $this->csbase_dao->getListOne($aTableInfo, $aSearchValue, $this->aWhereType);

      self::writeAccessLog($aResultData[ $sConfigWhereColumn ], $aParam[ 'pMenuName' ], $aParam[ 'pTableName' ], $aParam[ 'pColumnName' ], 
        $aParam[ 'pBeforeValue' ], $aResultData[ $aParam[ 'pColumnName' ] ], $aParam[ 'pEditValue' ], 0, $aParam[ 'pEditReason' ]);
    }

    $this->aViewData[ 'sAffectedRows' ] = $sAffectedRows;

    $this->layout_view('/common/template/window_edit.php', $this->aViewData, 'window');
  }

  public function writeAccessLog($sAccountIdx, $sMenuName, $sTableName, $sColumn, $sBeforeVal, $sAfterVal, $sInputVal, $sGmUsn, $sEditReason)
  {
    $sIsAccessLog = $this->config->item('accessLog');
    $aTableInfo = ftt_get_config('t_cs_access_log', 'auth');

    if($sIsAccessLog)
    {
      $mInsertColumn = array('game_ssn', 'account_idx', 'menu', 'tab_name', 'col_str', 'bval_str', 'aval_str', 'ival_str', 'reg_date', 'reg_usn', 'reason');
      $mInsertVal = array($this->ssn, $sAccountIdx, $sMenuName, $sTableName, $sColumn, $sBeforeVal, $sAfterVal, $sInputVal, date('Y-m-d H:i:s'), 
        $this->nAdminUsn, $sEditReason); 

      $this->csbase_dao->setInsert($aTableInfo, $mInsertColumn, $mInsertVal);
    }
  }

  public function ajaxPrimaryList()
  {
    $aParam = $this->input->get();
    $aPrimaryList = $this->csbase_dao->getPrimaryList($aParam[ 'pDsn' ], $aParam[ 'pTableName' ]);

    echo json_encode($aPrimaryList);
  }

  public function getViewData($aData, $sTableType, $aTableInfo)
  {
    $this->aViewData[ 'aData' ] = $aData;
    $this->aViewData[ 'sMenuName' ] = $this->sMenuName;
    $this->aViewData[ 'sTableType' ] = $sTableType;
    $this->aViewData[ 'aTableInfo' ] = $aTableInfo;

    $sViewPath = 'common/template/'.$aTableInfo[ 'viewType' ];

    return $this->load->view($sViewPath, $this->aViewData, true);
  }

  /* Simple Auth 함수 */
  //{{{
  public function checkSetAuth()
  {
    $this->oGmInfo = json_decode(get_cookie($this->sCookieId));
    $aAuthMaster = ftt_get_config('auth_master', 'auth');

    $this->nAdminUsn = $this->oGmInfo->idx;

    if(!$this->oGmInfo) self::goWarning(1);
    if($aAuthMaster[$this->oGmInfo->auth_id] == $this->oGmInfo->auth_password) return true;
    if($this->oGmInfo->auth_priv == 'A' || $this->oGmInfo->auth_priv == 'W') $this->aViewData['sIsWrite'] = true;
    if($this->oGmInfo->auth_priv == 'A') return true;
    if($this->oGmInfo->auth_status == 'D') self::goWarning(3);

    $this->aGmMenu = explode('|', $this->oGmInfo->access_menu);
    $sIsAccess = false;

    foreach($this->aGmMenu as $sAccessMenu)
    {
      if($this->url[1] == $sAccessMenu)
        $sIsAccess = true;
    }

    if(!$sIsAccess) self::goWarning(2);
  }

  public function goLogin()
  {
    $aParam = $this->input->post();

    $aMainTable = current(ftt_get_config('main', 'auth'));
    $aAuthMaster = ftt_get_config('auth_master', 'auth');

    if($aAuthMaster[$aParam['pGmId']] == $aParam['pGmPassword'])
    {
      echo $this->echoJson(
          array(
            'auth_id'=>$aParam['pGmId'], 
            'auth_password'=>$aParam['pGmPassword'],
            'auth_priv'=>'A'));
    }

    $aSearchValue = array($aParam['pGmId'], md5($aParam['pGmPassword']));

    $aResultData = $this->csbase_dao->getListOne($aMainTable, $aSearchValue, array(' = ? ', ' = ? '));

    echo $this->echoJson($aResultData);
  }

  public function goWarning($nMsgType)
  {
    $this->aViewData['nMsgType'] = $nMsgType;
    $this->layout_view('system/warning', $this->aViewData);
    $this->output->_display();
    die;
  }
  //}}}
}
