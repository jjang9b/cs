<?php if( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

require_once APPPATH . 'controllers/base/csbase_controller.php';

class Main extends CsBase_Controller{

  public function __construct()
  {
    parent::__construct();

    $this->aViewData['aMainSsnList'] = array(48);
  }

  public function index()
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
