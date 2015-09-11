<?php if( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

require_once APPPATH . 'controllers/base/csbase_controller.php';

class Log extends CsBase_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->config->load($this->url[ 0 ].'/log', false, false);
    $this->sMenuName = $this->config->item('menuName');
    $this->aWhereType = array(' = ? ', ' BETWEEN ? AND ? ');
    $this->sListAllType = 'where';
    $this->sDefaultView = 'default';

    $this->load->model($this->ssn.'/log_dao');

    $aTabInfo = $this->config->item('tab');

    foreach ($aTabInfo as $aTabTableInfo)
      $aCategoryList[$aTabTableInfo['tableText']] = $aTabTableInfo['table'];

    $this->aViewData['aCategoryList'] = $aCategoryList;
  }

  public function index()
  {
    $this->layout_view($this->ssn.'/log_index.php', $this->aViewData, $this->sDefaultView);
  }

  public function search($sSearchValue=null, $sSearchType=null)
  {
    $aParam = $this->input->post();

    if(!is_null($aParam['pSearchValue']))
    {
      list($sDateStart, $sDateEnd) = explode('-', $aParam['pSearchDate']);
      $sDateStartTime = date('YmdHis', strtotime($sDateStart));
      $sDateEndTime = date('YmdHis', strtotime($sDateEnd));

      if($sSearchValue && $sSearchType)
      {
        $aParam['pSearchValue'] = $sSearchValue;
        $aParam['pSearchType'] = $sSearchType;
        $sDateStartTime = date('YmdHis', strtotime('-1 week'));
        $sDateEndTime = date('YmdHis');
      }

      $aTabInfo = $this->config->item('tab');
      $aTabTableInfo = $aTabInfo[$aParam['pSearchType']];
      $aWhereValParam = array($aParam['pSearchValue'], trim($sDateStartTime), trim($sDateEndTime));

      $aTabResultData = $this->log_dao->getListArray($aTabTableInfo, $aWhereValParam, $this->aWhereType);
      $aTabResultView = $this->getViewData($aTabResultData, 'tab', $aTabTableInfo);

      foreach ($aTabInfo as $aTabTableOneInfo)
        $aCategoryList[ $aTabTableOneInfo['tableText']] = $aTabTableOneInfo['table'];

      $this->aViewData['aCategoryList'] = $aCategoryList;
      $this->aViewData['nTabDataCount'] = count($aTabResultData);
      $this->aViewData['aTabResultView'] = $aTabResultView;
      $this->aViewData['aTabTableInfo'] = $aTabTableInfo;
      $this->aViewData['aWhereValParam'] = implode('|', $aWhereValParam);
      $this->aViewData['sSearchValue'] = $aParam['pSearchValue'];
      $this->aViewData['sSearchType'] = $aParam['pSearchType'];
      $this->aViewData['sSearchDate'] = $aParam['pSearchDate'];
    }

    $this->layout_view($this->ssn.'/log_index.php', $this->aViewData, $this->sDefaultView);
  }

  public function tabSelect()
  {
    $aTabInfo = $this->config->item('tab');

    $aParam = $this->input->post();

    list($sDateStart, $sDateEnd) = explode('-', $aParam['pSearchDate']);
    $sDateStartTime = date('YmdHis', strtotime($sDateStart));
    $sDateEndTime = date('YmdHis', strtotime($sDateEnd));

    $aWhereValParam = array($aParam['pSearchValue'], trim($sDateStartTime), trim($sDateEndTime));
    $aTabTableInfo = $aTabInfo[$aParam['pTableName']];
    
    $aListData = $this->log_dao->getListArray($aTabTableInfo, $aWhereValParam, $this->aWhereType);

    echo $this->getViewData($aListData, 'tab', $aTabTableInfo);
  }
}
