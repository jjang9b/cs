<?php if( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

require_once APPPATH . 'controllers/base/csbase_controller.php';// if you need service base controller

class AccessLog extends CsBase_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->config->load($this->url[ 0 ].'/accesslog', false, false);
    $this->sMenuName = $this->config->item('menuName');
    $this->aWhereType = array(' = ? ', ' = ? ', ' BETWEEN ? AND ? ');
    $this->sListAllType = 'where';
    $this->sDefaultView = 'default';

    $this->load->model($this->ssn.'/accessLog_dao');
  }

  public function index()
  {
    $this->layout_view($this->ssn.'/accessLog_index.php', $this->aViewData, $this->sDefaultView);
  }

  public function search()
  {
    $aParam = $this->input->post();

    if(!is_null($aParam[ 'pSearchValue' ]))
    {
      $aMainInfo = $this->config->item('main');
      $aMainTableInfo = current($aMainInfo);

      list($sDateStart, $sDateEnd) = explode('-', $aParam['pSearchDate']);
      $sDateStartTime = date( 'YmdHis', strtotime( $sDateStart) );
      $sDateEndTime = date( 'YmdHis', strtotime( $sDateEnd) );

      $aWhereValParam = array($this->ssn, $aParam['pSearchValue'], trim($sDateStartTime), trim($sDateEndTime));

      $aMainResultData = $this->accessLog_dao->getListArray($aMainTableInfo, $aWhereValParam, $this->aWhereType);
      $aMainResultView = $this->getViewData($aMainResultData, 'main', $aMainTableInfo);

      $this->aViewData['nMainDataCount'] = count($aMainResultData);
      $this->aViewData['aMainResultView'] = $aMainResultView;
      $this->aViewData['sCurrentTable'] = $aMainTableInfo['table'];
      $this->aViewData['aWhereValParam'] = implode('|', $aWhereValParam);
      $this->aViewData['sSearchValue'] = $aParam['pSearchValue'];
      $this->aViewData['sSearchDate'] = $aParam['pSearchDate'];
    }

    $this->layout_view($this->ssn.'/accessLog_index.php', $this->aViewData, $this->sDefaultView);
  }
}
