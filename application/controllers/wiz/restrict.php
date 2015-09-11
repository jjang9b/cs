<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'controllers/wiz/wizbase_controller.php';

class Restrict extends WizBase_Controller
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

    $this->layout_view('wiz/restrict', $aViewData, 'wiz');
  }

  public function create()
  {
    $this->load->library('ftt/io/DirectoryUtil');
    $this->load->library('ftt/io/FileUtil');
    $this->load->library('ftt/util/Var2Code');
    $this->load->library('ftt/util/DataInverter');

    $aParam = $this->input->post();

    $aMainInfo = array();
    $aSaveConfig = array();

    foreach ($aParam['columnText'] as $sColTextIdx => $aColTextName)
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

      $aMainInfo[$sCurTableName]['viewType'] = 'table_search';
      $aMainInfo[$sCurTableName]['whereColumn'] = $aParam['whereColumn'][$sColTextIdx];
      $aMainInfo[$sCurTableName]['tableText'] = '유저 제재 및 해제';
    }

    $aSaveConfig['menuName'] = 'restrict';
    $aSaveConfig['accessLog'] = true;
    $aSaveConfig['maxPostCount'] = 1000;
    $aSaveConfig['postTimeOutSecond'] = 60;
    $aSaveConfig['main'] = $aMainInfo;

    $this->makeConfig($aSaveConfig, $aParam);
  }
}
