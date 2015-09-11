<?php if( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

require_once APPPATH . 'controllers/base/csbase_controller.php';

class Stats extends CsBase_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->sDefaultView = 'default';

    $this->config->load($this->url[ 0 ].'/stats', false, false);
    $this->load->model($this->ssn.'/stats_dao');
  }

  public function dau()
  {
    $this->layout_view($this->ssn.'/stats/dau_index.php', $this->aViewData, $this->sDefaultView);
  }

  public function ajaxGetDau()
  {
    /* 통계 데이터 추출 구현 */
    $aResult = array('data'=>1);

    echo json_encode($aResult);
  }
}
