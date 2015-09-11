<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth  
{
  function __construct()/*{{{*/
  {
    /* Call the Model constructor */
    $this->ci = & get_instance();

    $this->ci->load->config('auth');
    $this->ci->load->helper('cookie');
    $this->ci->load->helper('url');
    $this->ci->load->library('ftt/util/Server');

    $this->CommonLoginURL = $this->ci->config->item('domain').$this->ci->config->item('login_path');
    $this->cookieName = $this->ci->config->item('cookie_name');
  }/*}}}*/

  public function login($redirectURL='')/*{{{*/
  {
    if(!$redirectURL)
    {
      echo "no redirectURL";
      die;
    }
    if( $this->isLogin() )
    {
      redirect($redirectURL, 'location'); 
    }
    else
    {
      redirect($this->CommonLoginURL.'?redirect='.urlencode($redirectURL), 'location'); 
    }
   
  }/*}}}*/
  
  public function isLogin()/*{{{*/
  {
    $cookie = get_cookie($this->cookieName);

    if($cookie) 
      return true;
    else
      return false;
  }/*}}}*/
  
  public function checkAuth($sPath)/*{{{*/
  {
    //DB에서 권한 확인 후 진행
    
    return true;
  }/*}}}*/
  
  public function getUserInfoCookie()/*{{{*/
  {
    $cookie = get_cookie($this->cookieName);
    $aCookie = explode("&", $cookie);
    foreach($aCookie as $key=>$val)
    {
      $aTemp = explode("=",$val);
      if(in_array( $aTemp[0] ,array("id", "usn" )))
        $aResult[$aTemp[0]] = $aTemp[1];
    }

    return $aResult;
  }/*}}}*/
}
