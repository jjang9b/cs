<?php if( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

require_once APPPATH . 'controllers/base/csbase_controller.php';

class Define extends CsBase_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->config->load($this->url[ 0 ].'/define', false, false);
    $this->sMenuName = $this->config->item('menuName');
    $this->aWhereType = array(' = ? ');
    $this->sListAllType = 'all';
    $this->nLimit = 500;
    $this->sDefaultView = 'default';

    $this->load->model($this->ssn.'/define_dao');
  }

  public function index()
  {
    $aTabInfo = $this->config->item('tab');
    $aTabTable = current($aTabInfo);

    $aTabResultData = $this->define_dao->getListAll($aTabTable, '', $this->aWhereValParam, $this->sListAllType, $this->nLimit);
    $aTabResultView = $this->getViewData($aTabResultData, 'tab', $aTabTable);

    $this->aViewData['nTabDataCount'] = count($aTabResultData);
    $this->aViewData['aTabResultView'] = $aTabResultView;
    $this->aViewData['aTabInfo'] = $aTabInfo;

    $this->layout_view($this->ssn.'/define_index.php', $this->aViewData, $this->sDefaultView);
  }

  public function tabSelect()
  {
    $aTabInfo = $this->config->item('tab');
    $aParam = $this->input->post();

    $aTabTable = $aTabInfo[$aParam['pTableName']];
    
    $aTabResultData = $this->define_dao->getListAll($aTabTable, '', $this->aWhereValParam, $this->sListAllType, $this->nLimit);
    $aTabResultView = $this->getViewData($aTabResultData, 'tab', $aTabTable);

    print_r( $aTabResultView );
  } 
}
