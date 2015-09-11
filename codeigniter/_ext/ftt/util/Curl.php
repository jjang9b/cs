<?php
class Curl 
{
  public function __construct()
  {
    $this->ci = & get_instance();
  }

  public function post($sUrl, $aParam) 
  {
    $aUrl = explode('://', $sUrl);
    $sParamPost = http_build_query($aParam);

    $ch = curl_init();

    if($aUrl[0] == 'https')
    {
      curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt ($ch, CURLOPT_SSLVERSION,3);
    }

    curl_setopt($ch, CURLOPT_URL, $sUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $sParamPost);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    $error = curl_error($ch);

    curl_close($ch);

    return array('result'=>$result, 'error'=>$error);
  }

  public function get($sUrl, $aParam) 
  {
    $aUrl = explode('://', $sUrl);
    $sParam = http_build_query($aParam);

    $ch = curl_init();

    if($aUrl[0] == 'https')
    {
      curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt ($ch, CURLOPT_SSLVERSION,3);
    }

    curl_setopt($ch, CURLOPT_URL, $sUrl.'?'.$sParam);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    $error = curl_error($ch);

    curl_close($ch);

    return array('result'=>$result, 'error'=>$error);
  }
}

