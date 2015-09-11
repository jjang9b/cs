<?php
function ftt_get_instance($sClassName, $sType='library')
{
  $CI =& get_instance();

  $nLastPos = strrpos($sClassName, '/');
  if ($nLastPos !== false)
    $sVarName = substr($sClassName, $nLastPos + 1);
  else
    $sVarName = $sClassName;

  if ($sType == 'model')
    $sCiVarName = $sVarName;
  else
    $sCiVarName = strtolower($sVarName);

  if (!isset($CI->{$sCiVarName}))
  {
    //echo 'new instance of '.$sClassName.'<br>';
    $CI->load->{$sType}($sClassName);
  }

  return $CI->{$sCiVarName};
}

function ftt_get_config($sKey, $sFileName, $bUsePart=true)
{
  $CI =& get_instance();
  $CI->config->load($sFileName, $bUsePart);

  if ($bUsePart)
    return $CI->config->item($sKey, $sFileName);
  else
    return $CI->config->item($sKey);
}

function ftt_set_error($sClassName, $sCode, $sSubMessage='')
{
  $oEM = ftt_get_instance($sClassName);
  $oError = $oEM->setError($sCode, $sSubMessage);

  return $oError;
}

function ftt_get_error($sClassName, $bPop=false)
{
  $oEM = ftt_get_instance($sClassName);
  $oError = $oEM->getError($bPop);

  return $oError;
}

function ftt_save_log($sPath, $sLogName, $sMsg)
{
  global $application_folder; // by codeignitor

  if (substr($sPath, 0, 1) == '/')
    $sPath = substr($sPath, 1);

  if (substr($sPath, -1) != '/')
    $sPath .= '/';

  $sLogFile = dirname($application_folder).'/application/logs/'.$sPath.date("Ym").'/'.$sLogName.'_'.date('Ymd').'.txt';

  $oLog = ftt_get_instance('ftt/SimpleLog');
  $oLog->setFile($sLogFile);
  $nSize = $oLog->save($sMsg."\n");

  return $nSize;
}

function ftt_debug($mixVar, $nType=3)
{
  $bHtml= $nType & 1;
  $bPrintR = $nType & 2;
  $bVarDump = $nType & 4;

  $aTrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
  echo ($bHtml ? '<br>' : '')."\n" ;
  echo str_repeat("-=", 40);
  echo ($bHtml ? '<br>' : '')."\n" ;
  echo $aTrace[1]['class'].':'.$aTrace[1]['function'];
  echo ($bHtml ? '<br>' : '')."\n" ;
  echo str_repeat("-=", 40);
  echo ($bHtml ? '<br>' : '')."\n" ;

  if ($bPrintR)
  {
    print_r($mixVar);
    echo ($bHtml ? '<br>' : '')."\n";
  }

  if ($bVarDump);
  {
    var_dump($mixVar);
    echo ($bHtml ? '<br>' : '')."\n";
  }
}

function ftt_run_widget($sWidgetName)
{
  require_once APPPATH.'widgets/'.$sWidgetName.EXT;

  $oWidget = new $sWidgetName;

  $args = array_slice(func_get_args(), 1);
  call_user_func_array(array(&$oWidget, 'run'), $args); 
}

function ftt_render_widget($sWidgetViewName, $aViewData=array())
{
  extract($aViewData);
  require APPPATH.'views/widgets/'.$sWidgetViewName.EXT;
}

function ftt_redirect($url, $msg=null)
{
  if ($url == '') return false;

  if ($msg)
  {
    echo "<script>alert(\"{$msg}\"); location.href=\"{$url}\"</script>";
  }
  else
  {
    if (headers_sent())
    {
      echo "<script>location.href=\"{$url}\"</script>";
    } 
    else
    {
      header("Location: {$url}");
    }
  }

  return true;
}
