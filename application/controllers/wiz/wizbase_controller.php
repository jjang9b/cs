<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class WizBase_Controller extends Base_Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function makeConfig( $aSaveConfig, $aParam )
  {
    $sCfgFilePath = APPPATH.'logs/_system/wiz/config/'.$aParam[ 'ssn' ].'/'.$aParam[ 'htype' ].'.php';

    $this->fileutil->setFile($sCfgFilePath);
    $aCode = $this->var2code->make('$config',$aSaveConfig);
    $aCodeAll = "<?php\n".$aCode;

    $this->fileutil->write(print_r( $aCodeAll, true ), 0, 0002, $this->directoryutil);
    $this->fileutil->chmod(0777);

    $aViewData['ssn'] = $aParam[ 'ssn' ];
    $aViewData['cfg'] = $aParam[ 'htype' ];
    $aViewData['appPath'] = APPPATH;
    $aViewData['shPath'] = APPPATH.'tools/wiz/';
    $aViewData['cfgPath'] = $sCfgFilePath;

    self::makeConfigMenu($aParam);

    $this->layout_view('wiz/guide', $aViewData, 'wiz');
  }

  public function makeCustomeConfig( $aSaveConfig, $aParam )
  {
    $aParam['pCustomeKey'] = strtolower($aParam['pCustomeKey']);

    $sCfgFilePath = APPPATH.'logs/_system/wiz/config/'.$aParam[ 'ssn' ].'/'.$aParam[ 'pCustomeKey' ].'.php';

    $this->fileutil->setFile($sCfgFilePath);
    $aCode = $this->var2code->make('$config',$aSaveConfig);
    $aCodeAll = "<?php\n".$aCode;

    $this->fileutil->write(print_r( $aCodeAll, true ), 0, 0002, $this->directoryutil);
    $this->fileutil->chmod(0777);

    $aParam['htype'] = $aParam['pCustomeKey'];

    $aViewData['ssn'] = $aParam['ssn'];
    $aViewData['cfg'] = $aParam['pCustomeViewTemplate'];
    $aViewData['sCustomeKey'] = $aParam['pCustomeKey'];
    $aViewData['appPath'] = APPPATH;
    $aViewData['shPath'] = APPPATH.'tools/wiz/';
    $aViewData['cfgPath'] = $sCfgFilePath;

    self::makeConfigMenu($aParam);

    $this->layout_view('wiz/guide_custome', $aViewData, 'wiz');
  }

  public function getTableList()
  {
    $sDSN = $this->input->get('database');

    $this->load->model('dbkit');
    $oDao = $this->dbkit->getInstance($sDSN);

    $aResult = $oDao->getTableList($sDSN);
    $this->echoJson($aResult);
  }

  public function getColumnList()
  {
    $sDSN = $this->input->get('database');
    $sTableName = $this->input->get('table');

    $this->load->model('dbkit');
    $oDao = $this->dbkit->getInstance($sDSN);
    $aResult = $oDao->getColumnList($sDSN, $sTableName);
    $this->echoJson($aResult);
  }

  private function makeConfigMenu($aParam)
  {
    $sCfgFilePath = APPPATH.'logs/_system/wiz/config/'.$aParam[ 'ssn' ].'/menu.php';
    $sGameCfgFilePath = APPPATH.'/config/development/'.$aParam[ 'ssn' ].'/menu.php';

    $this->fileutil->setFile($sGameCfgFilePath);
    $this->fileutil->chmod(0777);

    if(!$this->fileutil->exist())
    {
      $aSaveConfig['gameName'] = 'GameName';
      $aSaveConfig['ssn'] = $aParam['ssn'];
      $aSaveConfig['menu'] = array($aParam['htype']=>$aParam['htype']);

      $this->fileutil->setFile($sCfgFilePath);
      $aCode = $this->var2code->make('$config', $aSaveConfig);
      $aCodeAll = "<?php\n".$aCode;

      $this->fileutil->write(print_r($aCodeAll, true), 0, 0002, $this->directoryutil);
      $this->fileutil->chmod(0777);
    }
    else
    {
      $aNowConfig= $this->fileutil->readAll();
      $aSaveConfig['menu'] = array($aParam['htype']=>$aParam['htype']);
      $aCode = $this->var2code->make('$config', $aSaveConfig);

      if(strpos($aNowConfig, '\[\'menu\'\]\[\''.$aParam['htype'].'\'\]') > 0)
        $aCodeAll = $aNowConfig;
      else
        $aCodeAll = $aNowConfig."\n".$aCode;

      $this->fileutil->setFile($sCfgFilePath);
      $this->fileutil->write(print_r($aCodeAll, true), 0, 0002, $this->directoryutil);
      $this->fileutil->chmod(0777);
    }
  }
}
