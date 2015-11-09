<?php if( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

require_once APPPATH . 'controllers/base/csbase_controller.php';

class Order extends CsBase_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->config->load($this->url[ 0 ].'/order', false, false);
    $this->sMenuName = $this->config->item('menuName');
    $this->aWhereType = array(' = ? ', ' BETWEEN ? AND ? ');
    $this->sListAllType = 'where';
    $this->sDefaultView = 'default';

    $this->load->model($this->ssn.'/order_dao');

    $aOsList = $this->config->item('order_os');
    $aStoreList = $this->config->item('order_store');
    $aItemPercentList = $this->config->item('order_itempercent');
    $aItemList = $this->config->item('order_itemlist');

    $this->aViewData[ 'aOsList' ] = $aOsList;
    $this->aViewData[ 'aStoreList' ] = $aStoreList;
    $this->aViewData[ 'aItemList' ] = $aItemList;
    $this->aViewData[ 'aItemPercentList' ] = $aItemPercentList;
  }

  public function index()
  {
    $this->layout_view($this->ssn.'/order_index', $this->aViewData, $this->sDefaultView);
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
      $aMainTaleInfo = current($aMainInfo);;
      $aWhereValParam = array($aParam['pSearchValue'], trim($sDateStartTime), trim($sDateEndTime));

      $aMainResultData = $this->order_dao->getListArray($aMainTaleInfo, $aWhereValParam, $this->aWhereType);
      $aMainResultView = $this->getViewData($aMainResultData, 'main', $aMainTaleInfo);

      $this->aViewData['nMainDataCount'] = count($aMainResultData);
      $this->aViewData['aMainResultView'] = $aMainResultView;
      $this->aViewData['sCurrentTable'] = $aMainTaleInfo['table'];
      $this->aViewData['aWhereValParam'] = implode('|', $aWhereValParam);
      $this->aViewData['sSearchValue'] = $aParam['pSearchValue'];
      $this->aViewData['sSearchType'] = $aParam['pSearchType'];
      $this->aViewData['sSearchDate'] = $aParam['pSearchDate'];
    }

    $this->layout_view($this->ssn.'/order_index', $this->aViewData, $this->sDefaultView);
  }

  public function postOrder()
  {
    $aParam = $this->input->post();

    /* 주문등록 처리 구현 */
    $aJsonResult = array('code'=>0, 'message'=>'success'); 

    echo json_encode($aJsonResult);
  }
}
