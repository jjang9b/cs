<?php if( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

require_once APPPATH . 'controllers/base/csbase_controller.php';

class Auth extends CsBase_Controller
{
  public function __construct()
  {
    parent::__construct();

    if($this->oGmInfo->auth_priv != 'A') $this->goWarning(2);  

    $this->config->load($this->url[ 0 ].'/auth', false, false);
    $this->sMenuName = $this->config->item('menuName');
    $this->sListAllType = 'all';
    $this->aWhereType = array(' = ? ');
    $this->nLimit = 1000;
    $this->sDefaultView = 'default';

    $this->load->model($this->ssn.'/auth_dao');

    $this->aMainInfo = $this->config->item('main');
    $this->aMainTable = current($this->aMainInfo);
  }

  public function index()
  {
    $aMainResultData = $this->auth_dao->getListAll($this->aMainTable, '', $this->aWhereValParam, $this->sListAllType, $this->nLimit);
    $aMainResultView = $this->getViewData($aMainResultData, 'main', $this->aMainTable);

    $this->aViewData['nMainDataCount'] = count($aMainResultData);
    $this->aViewData['aMainResultView'] = $aMainResultView;
    $this->aViewData['aMainInfo'] = $this->aMainInfo;
    $this->aViewData['aAuthMenu'] = ftt_get_config('auth_menu', '/auth');

    $this->layout_view($this->ssn.'/auth_index.php', $this->aViewData, $this->sDefaultView);
  }

  public function postAuthCreate()
  {
    $aParam = $this->input->post();

    $mInsertColumn = array('auth_name', 'auth_id', 'auth_password', 'auth_priv', 'auth_status', 'access_menu', 'modify_date', 'reg_date');
    $mInsertVal = array(
        $aParam['pGmName'], 
        $aParam['pGmId'], 
        md5($aParam['pGmPassword']), 
        $aParam['pGmPrivilege'], 
        $aParam['pGmStatus'], 
        ($aParam['pGmMenu']) ? implode('|', $aParam['pGmMenu']) : '',
        date('Y-m-d H:i:s'),
        date('Y-m-d H:i:s'));

    /* GM 계정 생성 구현 */
    $sAffectedRows = $this->auth_dao->setInsert($this->aMainTable, $mInsertColumn, $mInsertVal);

    if((int)$sAffectedRows >= 1)
      $aJsonResult = array('code'=>0, 'message'=>'success');

    echo json_encode($aJsonResult);
  }

  public function postAuthGetAccount()
  {
    $aParam = $this->input->get();

    /* GM 계정 정보 가져오기 구현 */
    $oResult = $this->auth_dao->getListOne($this->aMainTable, $aParam['pGmIdx'], $this->aWhereType);

    echo json_encode(array($oResult));
  }

  public function postAuthChange()
  {
    $aParam = $this->input->post();
    $oResult = $this->auth_dao->getListOne($this->aMainTable, $aParam['pGmModalIdx'], $this->aWhereType);

    if($oResult['auth_password'] == $aParam['pGmModalPassword'])
      $sPassword = $oResult['auth_password'];
    else
      $sPassword = md5($aParam['pGmModalPassword']);

    $aUpdateArray = array(
        'auth_password'=>$sPassword,
        'auth_priv'=>$aParam['pGmModalPrivilege'],
        'auth_status'=>$aParam['pGmModalStatus'],
        'access_menu'=>($aParam['pGmModalMenu']) ? implode('|', $aParam['pGmModalMenu']) : '',
        'modify_date'=>date('Y-m-d H:i:s'),
        'reg_date'=>date('Y-m-d H:i:s'));

    /* GM 계정 업데이트 구현 */
    $sAffectedRows = $this->auth_dao->setUpdateArray($this->aMainTable, $aUpdateArray, $this->aWhereType, 'auth_id', $aParam['pGmModalId']);

    if((int)$sAffectedRows >= 1)
      $aJsonResult = array('code'=>0, 'message'=>'success');
    else
      $aJsonResult = array('code'=>200, 'message'=>'auth create fail');

    echo json_encode($aJsonResult);
  }
}
