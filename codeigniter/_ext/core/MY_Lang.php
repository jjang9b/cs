<?php
class MY_Lang extends CI_Lang 
{
  function line($line = '', $arrDynamicMessage=array())
  {
    $value = ($line == '' OR ! isset($this->language[$line])) ? FALSE : $this->language[$line];

    // Because killer robots like unicorns!
    if ($value === FALSE)
    {
      log_message('error', 'Could not find the language line "'.$line.'"');
    }

    if (count($arrDynamicMessage) > 0)
      $value = vprintf($value, $arrDynamicMessage);

    return $value;
  }

}
