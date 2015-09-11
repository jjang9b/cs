<?php
$strHostName = gethostname();
$strInstallHome = dirname(dirname(dirname(__DIR__))); // CodeIgniter/_ext/tools/install/install.php => CodeIgniter
$arrServer = array(
                    'development' => array('de-php-api'),
                    'testing' => array()
                  );
$strEnviroment = 'production';
if (in_array($strHostName, $arrServer['development']))
  $strEnviroment = 'development';
else if (in_array($strHostName, $arrServer['testing']))
  $strEnviroment = 'testing';

// for development yet.
if ($strEnviroment != 'development')
{
  echo 'This server\'s hostname ('.$strHostName.') is not ready for development. Please insert hostname in install script if you need.';
  die;
}

$strProjectRoot = rtrim(readline("Insert your project root path (ex:/home/[user_id]/project/sampleapi) : "), '/');
$strUserHome = substr($strProjectRoot, 0, strpos($strProjectRoot, '/', 6));

// # check default directories
if (!file_exists($strProjectRoot.DIRECTORY_SEPARATOR.'application'))
{
  echo "Can't find the application directory from ".$strProjectRoot."\n";
  die;
}

if (!file_exists($strProjectRoot.DIRECTORY_SEPARATOR.'webroot'))
{
  echo "Can't find the webroot directory from ".$strProjectRoot."\n";
  die;
}

// # make public_html
$strPublicHtml = $strUserHome.DIRECTORY_SEPARATOR.'public_html';
if (!file_exists($strPublicHtml))
{
  echo "Create ".$strPublicHtml."\n";
  exec('mkdir '.$strPublicHtml);
}

// # make public_html/project_name
$strWebLink = $strPublicHtml.DIRECTORY_SEPARATOR.strtolower(basename($strProjectRoot));
$strLinkDir = $strProjectRoot.DIRECTORY_SEPARATOR.'webroot';
if (!file_exists($strWebLink))
{
  echo "Create the symbolic link (".$strWebLink." --> ".$strLinkDir.")\n";
  echo ('ln -s '.$strLinkDir.' '.$strWebLink."\n");
  exec('ln -s '.$strLinkDir.' '.$strWebLink);
}

// # make system configuration file
$strTemplateFile = __DIR__.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'index.inc.php';
$strApplicationPath = $strProjectRoot.DIRECTORY_SEPARATOR.'application';
$strSysConfig = file_get_contents($strTemplateFile);
$strSysConfig = str_replace('__$INI_ENVIRONMENT__', $strEnviroment, $strSysConfig);
$strSysConfig = str_replace('__$INI_SYSTEM_PATH__', $strInstallHome, $strSysConfig);
$strSysConfig = str_replace('__$INI_APPLICATION_PATH__', $strApplicationPath, $strSysConfig);

$strDefaultTimezone = trim(readline("Insert default timezone (default:Asia/Seoul) : "));
if (empty($strDefaultTimezone))
  $strDefaultTimezone = 'Asia/Seoul';

$strSysConfig = str_replace('__$INI_DEFAULT_TIMEZONE__', $strDefaultTimezone, $strSysConfig);

$strDeveloperId = '';
if ($strEnviroment == 'development')
  $strDeveloperId = basename($strUserHome);

$strSysConfig = str_replace('__$INI_DEVELOPER_ID__', $strDeveloperId, $strSysConfig);


echo "Create the system enviroment file (".$strProjectRoot.DIRECTORY_SEPARATOR.'webroot'.DIRECTORY_SEPARATOR."index.inc.php)\n";
file_put_contents($strProjectRoot.DIRECTORY_SEPARATOR.'webroot'.DIRECTORY_SEPARATOR.'index.inc.php', $strSysConfig);

// create symbolic for extending application/ftt
$strSystemExtFttPath = $strInstallHome.DIRECTORY_SEPARATOR.'_ext'.DIRECTORY_SEPARATOR.'ftt';
$strApplicationFttPath = $strApplicationPath.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'ftt';
if (!file_exists($strApplicationFttPath))
{
  echo "The symbolic link for application ftt is created.\n";
  exec('ln -s '.$strSystemExtFttPath.' '.$strApplicationFttPath);
}

// set permission for log directory
$strLogPath = $strApplicationPath.DIRECTORY_SEPARATOR.'logs';
echo "Log directory permission changed.\n";
exec('chmod 777 '.$strLogPath);


echo "done! \n";

