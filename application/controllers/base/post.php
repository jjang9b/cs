<?php if( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

require_once APPPATH . 'controllers/base/csbase_controller.php';

class Post extends CsBase_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->config->load($this->url[ 0 ].'/post', false, false);
    $this->sMenuName = $this->config->item('menuName');
    $this->aWhereType = array(' = ? ', ' BETWEEN ? AND ? ');
    $this->sListAllType = 'where';
    $this->sDefaultView = 'default';

    $sMaxPostCount = $this->config->item('maxPostCount');
    $sPostTimeOutSecond = $this->config->item('postTimeOutSecond');

    $this->aViewData[ 'sMaxPostCount' ] = $sMaxPostCount;
    $this->aViewData[ 'sPostTimeOutSecond' ] = $sPostTimeOutSecond;

    $this->load->model($this->ssn.'/post_dao');
  }

  public function index()
  {
    $this->layout_view($this->ssn.'/post_index.php', $this->aViewData, $this->sDefaultView);
  }

  public function search()
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

      $aMainInfo = $this->config->item('main');
      $aMainTableInfo = current($aMainInfo);;
      $aWhereValParam = array($aParam['pSearchValue'], trim($sDateStartTime), trim($sDateEndTime));

      $aMainResultData = $this->post_dao->getListArray($aMainTableInfo, $aWhereValParam, $this->aWhereType);
      $aMainResultView = $this->getViewData($aMainResultData, 'main', $aMainTableInfo);

      $this->aViewData['nMainDataCount'] = count($aMainResultData);
      $this->aViewData['aMainResultView'] = $aMainResultView;
      $this->aViewData['sCurrentTable'] = $aMainTableInfo['table'];
      $this->aViewData['aWhereValParam'] = implode('|', $aWhereValParam);
      $this->aViewData['sSearchValue'] = $aParam['pSearchValue'];
      $this->aViewData['sSearchType'] = $aParam['pSearchType'];
      $this->aViewData['sSearchDate'] = $aParam['pSearchDate'];
    }

    $this->layout_view($this->ssn.'/post_index.php', $this->aViewData, $this->sDefaultView);
  }

  public function submitPost()
  {
    $aParam = $this->input->post();

    /* 우편함 지급 처리 구현 */
    $aJsonResult = array('code'=>0, 'message'=>'success');

    echo json_encode($aJsonResult);
  }
}
