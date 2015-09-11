<?php

require_once APPPATH."/libraries/ftt/service/Auth2".EXT;

function get_admin_auth($sToken=null)
{
  global $_COOKIE;

  $cookieName = ftt_get_config('auth.cookie_name', 'auth', false);

  if ($sToken == null)
    $sToken = $_COOKIE[$cookieName];  
  return new Auth2(1, "e+@*YvVB2o-;efvR", $sToken);
}
