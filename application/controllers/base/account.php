<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'controllers/base/csbase_controller.php';

class Account extends CsBase_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->config->load($this->url[ 0 ].'/account', false, false);
    $this->sMenuName = $this->config->item('menuName');
    $this->aWhereType = array(' = ? ', ' = ? ');
    $this->sListAllType = 'where';
    $this->sDefaultView = 'default';

    $this->load->model($this->ssn.'/account_dao');
  }

  public function index()
  {
    $this->layout_view($this->ssn.'/account_index', $this->aViewData, $this->sDefaultView);
  }

  public function beforeSearch()
  {
    $aParam = $this->input->post();

    if(!is_null($aParam[ 'pSearchValue' ]))
    {
      $aTableInfoAll = $this->config->item('main'); 
      $aAccountTableInfo = current($aTableInfoAll);
      $aAccountTableInfo[ 'viewType' ] = 'list_before';

      $aWhereValParam = array($aParam[ 'pSearchValue' ]);

      $aAccountResultData = $this->account_dao->getAccountIdx($aAccountTableInfo, $aAccountTableInfo[ 'whereColumn' ], $aWhereValParam, $this->aWhereType);
      $aAccountResultView = $this->getViewData($aAccountResultData, 'main', $aAccountTableInfo);
    }

    $this->aViewData['nMainDataCount'] = count($aAccountResultData);
    $this->aViewData['aAccountResultView'] = $aAccountResultView;
    $this->aViewData['sCurrentTable'] = $aAccountTableInfo[ 'table' ];
    $this->aViewData['sSearchValue'] = $aParam[ 'pSearchValue' ];
    $this->aViewData['sSearchType'] = $aParam[ 'pSearchType' ];

    $this->layout_view($this->ssn.'/account_index', $this->aViewData, $this->sDefaultView);
  }

  public function search()
  {
    $aParamGet = $this->input->get();
    $aParamPost = $this->input->post();

    $aParam = ( $aParamPost[ 'pSearchValue' ] ) ? $aParamPost : $aParamGet;

    if(!is_null($aParam[ 'pSearchValue' ]))
    {
      $aMainInfoAll = $this->config->item('main'); 

      $aTabInfoAll = $this->config->item('tab'); 
      $aTabTableInfo = current($aTabInfoAll);

      $aWhereValParam = array($aParam[ 'pSearchValue' ]);

      foreach ($aMainInfoAll as $aMainTableInfo)
      {
        $aMainResultData = $this->account_dao->getListArray($aMainTableInfo, $aWhereValParam, $this->aWhereType);

        if($aMainResultData[ 0 ])
        {
          $aMainResultView = $this->getViewData($aMainResultData[ 0 ], 'main', $aMainTableInfo);
          $aMainResultViewAll .= $aMainResultView;
        }
      }

      $aTabResultData = $this->account_dao->getListArray($aTabTableInfo, $aWhereValParam, $this->aWhereType);
      $aTabResultView = $this->getViewData($aTabResultData, 'tab', $aTabTableInfo);

      $this->aViewData['aMainResultView'] = $aMainResultViewAll;
      $this->aViewData['nMainDataCount'] = count($aMainResultData);
      $this->aViewData['sCurrentTable'] = current($aMainInfoAll)[ 'table' ];

      /* ToDo. setting value */
      $this->aViewData['nAccountIdx'] = 1;
      $this->aViewData['sBlockedFlag'] = 'normal';
      $this->aViewData['sPasswd'] = '$2a$11$c9UNFrjo4xUSO5BsllsXZuJyKJN';
      $this->aViewData['sEmail'] = 'test@test.com';
      $this->aViewData['nPointAmount'] = 100;

      $this->aViewData['nTabDataCount'] = count($aTabResultData);
      $this->aViewData['aTabResultView'] = $aTabResultView;
      $this->aViewData['aTabInfo'] = $aTabInfoAll;

      $this->aViewData['aWhereValParam'] = implode('|', $aWhereValParam);
      $this->aViewData['sSearchValue'] = $aParam[ 'pSearchValue' ];
      $this->aViewData['sSearchType'] = $aParam[ 'pSearchType' ];
    }

    $this->layout_view($this->ssn.'/account_view', $this->aViewData, $this->sDefaultView);
  }

  public function tabSelect()
  {
    $aParam = $this->input->post();

    $aTabInfo = $this->config->item('tab');
    $aQueryInfo = $aTabInfo[ $aParam[ 'pTableName' ] ];

    $aListData = $this->account_dao->getListArray($aQueryInfo, $aParam[ 'pSearchValue' ], $this->aWhereType);

    echo $this->getViewData($aListData, 'tab', $aQueryInfo);
  }

  public function postUserInfo()
  {
    $aParam = $this->input->post();

    /* 유저 정보 수정 구현 */
    $aJsonResult = array('code'=>0, 'message'=>'success');

    echo json_encode($aJsonResult);
  }

  public function postUserState()
  {
    $aParam = $this->input->post();

    /* 유저 정보 수정 구현 */
    $aJsonResult = array('code'=>0, 'message'=>'success');

    echo json_encode($aJsonResult);
  }
}
