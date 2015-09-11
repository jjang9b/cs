<?php
class MY_Config extends CI_Config
{
  function item($item, $index = '')
  {
    $nDotPos = strpos($item, '.');
    $arrKey = array();
    if ($nDotPos > 0)
    {
      $arrKey = explode('.', $item);
      $item = $arrKey[0];
      array_shift($arrKey); // remove first key name (config filename)
    }

    if ($index == '')
    {
      if ( ! isset($this->config[$item]))
      {
        return FALSE;
      }

      $pref = $this->config[$item];
    }
    else
    {
      if ( ! isset($this->config[$index]))
      {
        return FALSE;
      }

      if ( ! isset($this->config[$index][$item]))
      {
        return FALSE;
      }

      $pref = $this->config[$index][$item];
    }

    if ($nDotPos > 0)
    {
      $arrPos = &$pref;
      foreach ($arrKey as $strCurKey)
      {
        $arrPos = &$arrPos[$strCurKey];
      }
      $pref = $arrPos;
    }

    return $pref;
  }

}
