<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'controllers/wiz/wizbase_controller.php';

class Define extends WizBase_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->model('dbkit');
  }

  public function index()
  {
    include (APPPATH . 'config/'.ENVIRONMENT.'/database.php');

    $aViewData = array( 'aDatabase' => $db );

    $this->layout_view('wiz/define', $aViewData, 'wiz');
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

    foreach($aParam['columnText'] as $sColTextIdx => $aColTextName)
    {
      if(substr($aParam['database'], -6) == '_slave')
        $aParam['database'] = substr($aParam['database'], 0, (count($aParam['database'])-7));
      if(substr($aParam['database'], -7) == '_master')
        $aParam['database'] = substr($aParam['database'], 0, (count($aParam['database'])-8));

      $sCurTableName = substr($sColTextIdx, 4);
      $aTabInfo[$sCurTableName]['table'] = $sCurTableName;
      $aTabInfo[$sCurTableName]['dsn'] = $aParam['database'];
      $aTabInfo[$sCurTableName]['column'] = $aParam['column'][$sColTextIdx];
      $aTabInfo[$sCurTableName]['columnText'] = $aParam['columnText'][$sColTextIdx];
      $aTabInfo[$sCurTableName]['columnText'] = $this->datainverter->getArrayValKeyMap($aParam['column'][$sColTextIdx], $aParam['columnText'][$sColTextIdx]);

      if ($aParam['editColumn'][$sColTextIdx])
        $aTabInfo[$sCurTableName]['editColumn'] = $this->datainverter->getArrayValKeyMap($aParam['editColumn'][$sColTextIdx], $aParam['editColumn'][$sColTextIdx]);

      $aTabInfo[$sCurTableName]['viewType'] = $aParam['r_viewtype'][$sColTextIdx];
      $aTabInfo[$sCurTableName]['tableText'] = $aParam['tab_disp_name'][$sColTextIdx];
    }

    $aSaveConfig['menuName'] = 'define';
    $aSaveConfig['tab'] = $aTabInfo;

    $this->makeConfig( $aSaveConfig, $aParam );
  }
}
