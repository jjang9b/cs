<?php if( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

require_once APPPATH . 'controllers/base/csbase_controller.php';

class Main extends CsBase_Controller{

  public function __construct()
  {
    parent::__construct();

    $this->aViewData['aMainSsnList'] = ftt_get_config('menu_ssn_list', 'cstool', false);
  }

  public function index()
  {
    if(!$this->oAuth->existsToken() || $this->getAllowType('', null) == 'login')
      $this->layout_view('system/login', $this->aViewData);
    else 
    {
      if($this->url[0])
      {
        $this->sDebugConsole = false;
        $this->layout_view('/layout/default/game_main', $this->aViewData);
      }
      else
      {
        $this->layout_view('/layout/default/main', $this->aViewData);
      }
    }
  }
}
