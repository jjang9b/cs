<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function echoJson($oData)
	{
    ob_clean();
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
	  header('Content-type: application/json');
    echo json_encode($oData, JSON_UNESCAPED_UNICODE);
    flush();
    die;
	}

  public function layout_view($sViewName, $aViewData='', $sLayoutName='')
  {
    if (empty($sLayoutName))
      $sLayoutName = 'default';

    if (is_null($aLayout[$sLayoutName]))
    {
      $aLayout[$sLayoutName] = array(
                                      'layout/'.$sLayoutName.'/header',
                                      'layout/'.$sLayoutName.'/menu',
                                      'layout/'.$sLayoutName.'/body',
                                      '', // for content
                                      'layout/'.$sLayoutName.'/footer',
                                    );
    }

    foreach ($aLayout[$sLayoutName] as $sCurLayoutView)
    {
      if (empty($sCurLayoutView))
        $this->load->view($sViewName, $aViewData);
      else
        $this->load->view($sCurLayoutView, $aViewData);
    }
  }

  public function makeConfig( $aSaveConfig, $aParam )
  {
    $sCfgFilePath = APPPATH.'logs/_system/wiz/config/'.$aParam[ 'ssn' ].'/'.$aParam[ 'htype' ].'.php';

    $this->fileutil->setFile( $sCfgFilePath);
    $aCode = $this->var2code->make('$config',$aSaveConfig);
    $aCodeAll = "<?php\n".$aCode;

    $this->fileutil->write(print_r( $aCodeAll, true ), 0, 0002, $this->directoryutil);
    $this->fileutil->chmod(0777);

    // view
    $aViewData[ 'ssn' ] = $aParam[ 'ssn' ];
    $aViewData[ 'cfg' ] = $aParam[ 'htype' ];
    $aViewData[ 'appPath' ] = APPPATH;
    $aViewData[ 'shPath' ] = APPPATH.'tools/wiz/';
    $aViewData[ 'cfgPath' ] = $sCfgFilePath;

    $this->layout_view('wiz/guide', $aViewData, 'wiz');
  }

  public function getTableList()
  {
    $sDSN = $this->input->get('database');

    $this->load->model('dbkit');
    $oDao = $this->dbkit->getInstance($sDSN);

    $aResult = $oDao->getTableList($sDSN);
    $this->response_json($aResult);
  }

  public function getColumnList()
  {
    $sDSN = $this->input->get('database');
    $sTableName = $this->input->get('table');

    $this->load->model('dbkit');
    $oDao = $this->dbkit->getInstance($sDSN);
    $aResult = $oDao->getColumnList($sDSN, $sTableName);
    $this->response_json($aResult);
  }
}
