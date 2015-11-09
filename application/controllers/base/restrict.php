<?php if( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

require_once APPPATH . 'controllers/base/csbase_controller.php';

class Restrict extends CsBase_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->config->load($this->url[ 0 ].'/restrict', false, false);
    $this->sMenuName = $this->config->item('menuName');
    $this->aWhereType = array(' = ? ', ' BETWEEN ? AND ? ');
    $this->sListAllType = 'where';
    $this->sDefaultView = 'default';

    $sMaxPostCount = $this->config->item('maxPostCount');
    $sPostTimeOutSecond = $this->config->item('postTimeOutSecond');

    $this->aViewData[ 'sMaxPostCount' ] = $sMaxPostCount;
    $this->aViewData[ 'sPostTimeOutSecond' ] = $sPostTimeOutSecond;

    $this->load->model($this->ssn.'/restrict_dao');
  }

  public function index()
  {
    $this->layout_view($this->ssn.'/restrict_index.php', $this->aViewData, $this->sDefaultView);
  }

  public function search()
  {
    $aParam = $this->input->post();

    if(!is_null($aParam['pSearchValue']) || !is_null($aParam['pSearchDate']))
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

      $aMainInfo = $this->config->item('main');
      $aMainTaleInfo = current($aMainInfo);;
      $aWhereValParam = array($aParam['pSearchValue'], trim($sDateStartTime), trim($sDateEndTime));

      $aMainResultData = $this->restrict_dao->getListArray($aMainTaleInfo, $aWhereValParam, $this->aWhereType);
      $aMainResultView = $this->getViewData($aMainResultData, 'main', $aMainTaleInfo);

      $this->aViewData['nMainDataCount'] = count($aMainResultData);
      $this->aViewData['aMainResultView'] = $aMainResultView;
      $this->aViewData['sCurrentTable'] = $aMainTaleInfo['table'];
      $this->aViewData['aWhereValParam'] = implode('|', $aWhereValParam);
      $this->aViewData['sSearchValue'] = $aParam['pSearchValue'];
      $this->aViewData['sSearchType'] = $aParam['pSearchType'];
      $this->aViewData['sSearchDate'] = $aParam['pSearchDate'];
    }

    $this->layout_view($this->ssn.'/restrict_index.php', $this->aViewData, $this->sDefaultView);
  }

  public function postRestrict()
  {
    $aParam = $this->input->post();

    /* 유저제재 처리 구현 */
    $aJsonResult = array('code'=>0, 'message'=>'success'); 

    echo json_encode($aJsonResult);
  }
}
