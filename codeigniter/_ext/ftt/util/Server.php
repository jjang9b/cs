<?php
class Server 
{
  public function __construct()
  {
    $this->aAllowList = array(
      '10.',
      '172.',
      '58.224.35.',
      '1.235.172.2', 
      '1.235.172.3', 
      '1.235.172.6', 
    );
  }
  public function isftt()
	{
    $remoteip = $this->getRemoteAddr();

    foreach ($this->aAllowList as $ip)
    {
      if (substr($remoteip, 0, strlen($ip)) == $ip)
        return true;
    }

    return false;
  }
  public function isfttServer()
  {
    $sServerIp = $this->getServerAddr();

    foreach ($this->aAllowList as $ip)
    {
      if (substr($sServerIp, 0, strlen($ip)) == $ip)
        return true;
    }

    return false;
  }
  public function getServerPort()
  {
    if($this->isDev())
      return 'dev';
    else
    {
      if($_SERVER['HTTP_X_ORIGINPORT'] == '443' || $_SERVER['SERVER_PORT'] == '443')
        return '443'; 
      else
        return '80';
    }
  }
  public function getRemoteAddr()
  {
    if ($_SERVER['HTTP_X_FORWARDED_FOR'])
      return $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['X-ClientIP'])  
      return $_SERVER['X-ClientIP'];
    elseif($_SERVER['X-CLIENTIP'])  
      return $_SERVER['X-CLIENTIP'];
    ELSe
      return $_SERVER['REMOTE_ADDR'];
  }
  public function getServerAddr()
  {
    return $_SERVER['SERVER_ADDR'];
  }
  public function isSecure()
  {
    if($this->getServerPort() == '443')
      return true;
    else
      return false;
  }
  public function isDev()
  {
    if(strstr ( $_SERVER['HTTP_HOST'] , "de-php-api") )
      return true;
    else
      return false;
  }
  public function isMobile()
  {
    $mobile_agent = array("iPhone","Ipod","Android","Blackberry","SymbianOS|SCH-M\d+","Opera Mini", "Windows ce", "Nokia", "sony" );

    $check_mobile = false;

    foreach($mobile_agent as $key=>$val)
    {
      if(stripos( $_SERVER['HTTP_USER_AGENT'], $val ))
      {
          $check_mobile = true;
          break;
      }
    }
    return $check_mobile;
	}
  public function isQA()
  {
    if(in_array($_SERVER['SERVER_ADDR'], array("172.31.10.12", "172.31.10.23") ))
      return true;
    else
      return false;
  }
}

