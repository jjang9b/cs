<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'controllers/wiz/wizbase_controller.php';

class Custome extends WizBase_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->model('dbkit');
  }

  public function index()
  {
    include (APPPATH . 'config/'.ENVIRONMENT.'/database.php');

    $aViewData = array('aDatabase' => $db);

    $this->layout_view('wiz/custome', $aViewData, 'wiz');
  }

  public function create()
  {
    $this->load->library('ftt/io/DirectoryUtil');
    $this->load->library('ftt/io/FileUtil');
    $this->load->library('ftt/util/Var2Code');
    $this->load->library('ftt/util/DataInverter');

    $aParam = $this->input->post();

    $aMainInfo = array();
    $aTabInfo = array();

    $aSaveConfig = array();

    foreach ($aParam['columnText'] as $sColTextIdx => $aColTextName)
    {
      if(substr($sColTextIdx, 0, 5) == 'main_')
      {
        $sCurTableName = substr($sColTextIdx, 5);
        $aMainInfo[$sCurTableName]['table'] = $sCurTableName; 

        if(substr($aParam['database'], -6) == '_slave')
          $aParam['database'] = substr($aParam['database'], 0, (count($aParam['database'])-7));
        if(substr($aParam['database'], -7) == '_master')
          $aParam['database'] = substr($aParam['database'], 0, (count($aParam['database'])-8));

        $aMainInfo[$sCurTableName]['dsn'] = $aParam['database'];
        $aMainInfo[$sCurTableName]['column'] = $aParam['column'][$sColTextIdx];
        $aMainInfo[$sCurTableName]['columnText'] = $this->datainverter->getArrayValKeyMap($aParam['column'][$sColTextIdx], $aParam['columnText'][$sColTextIdx]);

        if ($aParam['editColumn'][$sColTextIdx])
          $aMainInfo[$sCurTableName]['editColumn'] = $this->datainverter->getArrayValKeyMap($aParam['editColumn'][$sColTextIdx], $aParam['editColumn'][$sColTextIdx]);

        $aMainInfo[$sCurTableName]['viewType'] = 'list_account';
        $aMainInfo[$sCurTableName]['whereColumn'] = $aParam['whereColumn'][$sColTextIdx];
        $aMainInfo[$sCurTableName]['tableText'] = 'Custome 정보';
      }
      else
      {
        $sCurTableName = substr($sColTextIdx, 4);

        if(substr($aParam['database'], -6) == '_slave')
          $aParam['database'] = substr($aParam['database'], 0, (count($aParam['database'])-7));
        if(substr($aParam['database'], -7) == '_master')
          $aParam['database'] = substr($aParam['database'], 0, (count($aParam['database'])-8));

        $aTabInfo[$sCurTableName]['table'] = $sCurTableName;
        $aTabInfo[$sCurTableName]['dsn'] = $aParam['database'];
        $aTabInfo[$sCurTableName]['column'] = $aParam['column'][$sColTextIdx];
        $aTabInfo[$sCurTableName]['columnText'] = $this->datainverter->getArrayValKeyMap($aParam['column'][$sColTextIdx], $aParam['columnText'][$sColTextIdx]);

        if ($aParam['editColumn'][$sColTextIdx])
          $aTabInfo[$sCurTableName]['editColumn'] = $this->datainverter->getArrayValKeyMap($aParam['editColumn'][$sColTextIdx], $aParam['editColumn'][$sColTextIdx]);

        $aTabInfo[$sCurTableName]['viewType'] = $aParam['r_viewtype'][$sColTextIdx];
        $aTabInfo[$sCurTableName]['whereColumn'] = $aParam['whereColumn'][$sColTextIdx];
        $aTabInfo[$sCurTableName]['tableText'] = $aParam['tab_disp_name'][$sColTextIdx];
      }
    }

    $aSaveConfig['menuName'] = strtolower($aParam['pCustomeKey']);
    $aSaveConfig['accessLog'] = true;
    $aSaveConfig['main'] = $aMainInfo;
    $aSaveConfig['tab'] = $aTabInfo;

    switch(strtolower($aParam['pCustomeViewTemplate']))
    {
      case "order" : 
        $aSaveConfig['order_os'] = array('Android'=>2, 'IOS'=>1, '구분불가'=>99);
        $aSaveConfig['order_store'] = array('안드로이드 마켓'=>12, 'APP스토어'=>11, '티스토어'=>13, '올레U+'=>14, '오즈'=>15);
        $aSaveConfig['order_itempercent'] = array(
          '0포인트'=>0, 
          '100포인트'=>100, 
          '500포인트'=>500, 
          '1000포인트'=>1000, 
          '2000포인트'=>2000, 
          '5000포인트'=>5000, 
          '10000포인트'=>10000);
        $aSaveConfig['order_itemlist'] = array('item_id1'=>'item_name1');
        break;

      case "post" : 
      case "restrict" : 
        $aSaveConfig['maxPostCount'] = 1000;
        $aSaveConfig['postTimeOutSecond'] = 60;
        break;
    }

    $this->makeCustomeConfig($aSaveConfig, $aParam);
  }
}
