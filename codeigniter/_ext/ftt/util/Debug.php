<?php
class Debug
{
  public function __construct()
  {
    $this->ci = & get_instance();
  }

  public function console($aDebugData) 
  {
    $this->ci->load->config('config');
    $sDebugConsole = $this->ci->config->item('debug_console');

    $this->ci->load->library('ftt/util/server');

    if($sDebugConsole)
    {
      $this->ci->load->library('session');

      $aAllUserData = $this->ci->session->all_userdata();

      $aDiffData = array_diff_key($aAllUserData, $aDebugData);

      $aUnsetTmp = array();

      foreach ($aDiffData as $sDiffKey=>$sDiffVal)
      {
        if(!in_array($sDiffKey, array('ip_address', 'last_activity', 'session_id', 'user_agent')))
          $aUnsetTmp[$sDiffKey] = '';
      }

      $this->ci->session->unset_userdata($aUnsetTmp);
      $this->ci->session->set_userdata($aDebugData);
    }
  }
}
