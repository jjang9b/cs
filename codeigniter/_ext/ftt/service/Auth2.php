<?php

class Auth2
{
  private $nSvcCode;
  private $sHashKey;
  private $sToken;

  public function __construct($nSvcCode, $sHashKey, $sToken)
  {
    $this->nSvcCode = $nSvcCode;
    $this->sHashKey = $sHashKey;
    $this->sToken   = $sToken;
  }

  public function existsToken()
  {
    if ($this->sToken)
      return true;
    return false;
  }

  public function verifyToken()
  {
    $oFingerprint = ftt_get_instance('ftt/Fingerprint');
    $sFingerprint = $oFingerprint->generate($this->sHashKey, $this->sToken);

    $aQueryData = array(
      'svccode' => $this->nSvcCode,
      'token'   => $this->sToken,
      'fingerprint' => $sFingerprint,
    );

    $oResp = $this->invoke('/user/api/verify_token', $aQueryData);
    if ($oResp && $oResp->result == 'OK')
      return true;
    return false;
  }

  public function getAllowType($sUrl, $nSsn=0)
  {
    $oFingerprint = ftt_get_instance('ftt/Fingerprint');
    $sFingerprint = $oFingerprint->generate($this->sHashKey, $this->sToken);

    $aQueryData = array(
      'svccode' => $this->nSvcCode,
      'token'   => $this->sToken,
      'fingerprint' => $sFingerprint,
      'url'     => $sUrl,
      'ssn'     => $nSsn,
    );

    $oResp = $this->invoke('/user/api/check_auth', $aQueryData);
    if ($oResp && $oResp->result == 'OK')
      return $oResp->allow_type;
    else if ($oResp && $oResp->code == -200)
      return 'login';

    return 'none';
  }

  public function getAllowTypeList($aUrl, $nSsn=0) {
    if (!is_array($aUrl) || count($aUrl) == 0) return array('none');

    $oFingerprint = ftt_get_instance('ftt/Fingerprint');
    $sFingerprint = $oFingerprint->generate($this->sHashKey, $this->sToken);

    $aQueryData = array(
      'svccode' => $this->nSvcCode,
      'token'   => $this->sToken,
      'fingerprint' => $sFingerprint,
      'url'     => implode(';', $aUrl),
      'ssn'     => $nSsn,
    );

    $oResp = $this->invoke('/user/api/check_auth', $aQueryData);
    if ($oResp && $oResp->result == 'OK')
      return explode(';', $oResp->allow_type);
    else if ($oResp && $oResp->code == -200)
      return array_fill(0, count($aUrl), 'login');

    return array_fill(0, count($aUrl), 'none');
  }

  public function getUserInfo()
  {
    $oFingerprint = ftt_get_instance('ftt/Fingerprint');
    $sFingerprint = $oFingerprint->generate($this->sHashKey, $this->sToken);

    $aQueryData = array(
      'svccode' => $this->nSvcCode,
      'token'   => $this->sToken,
      'fingerprint' => $sFingerprint,
    );

    $oResp = $this->invoke('/user/api/user_info', $aQueryData);
    if ($oResp && $oResp->result == 'OK')
      return $oResp->user_info;
    return null;
  }

  public function getMenuList()
  {
    $oFingerprint = ftt_get_instance('ftt/Fingerprint');
    $sFingerprint = $oFingerprint->generate($this->sHashKey, $this->sToken);

    $aQueryData = array(
      'svccode' => $this->nSvcCode,
      'token'   => $this->sToken,
      'fingerprint' => $sFingerprint,
    );

    $oResp = $this->invoke('/user/api/menu_list', $aQueryData);

    if ($oResp && $oResp->result == 'OK')
      return $oResp->list;
    return null;
  }
  
  private function invoke($sPath, $aQueryData)
  {
    $oServer = ftt_get_instance('ftt/util/Server');

    if ($oServer->isDev())
      $sQueryUrl = "http://de-php-api.fttinc.kr/~bbin/auth2/index.php{$sPath}?".http_build_query($aQueryData);
    else if ($oServer->isQA())
      $sQueryUrl = "https://ts-auth2.four33.co.kr{$sPath}?".http_build_query($aQueryData);
    else
      $sQueryUrl = "https://auth2.four33.co.kr{$sPath}?".http_build_query($aQueryData);

    $resCh = curl_init();
      
    curl_setopt($resCh, CURLOPT_URL, $sQueryUrl);
    curl_setopt($resCh, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($resCh, CURLOPT_CONNECTTIMEOUT, 2);  // 2 seconds
    curl_setopt($resCh, CURLOPT_TIMEOUT, 3);         // 3 seconds

    $sRespCont = curl_exec($resCh);

    $oResp = json_decode($sRespCont);

    return $oResp;
  }
}
