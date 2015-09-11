<?php

function ftt_unary_attr($bCond, $sAttr)
{
  if ($bCond)
    return $sAttr;
  return '';
}

function ftt_attr($bCond, $sName, $sValue)
{
  if ($bCond)
    return "{$Name}=\"\{$sValue}\"";  
  return '';
}

function ftt_style($bCond, $sName, $sValue)
{
  if ($bCond)
    return "{$sName}:{$sValue};";  
  return '';
}

function ftt_url_param($sName, $sValue, $bFirst=false)
{
  if ($sValue == '') return '';

  if ($bFirst)
    return sprintf("%s=%s", $sName, urlencode($sValue));
  return sprintf("&%s=%s", $sName, urlencode($sValue));
}

function ftt_select($bCond, $sValue1, $sValue2)
{
  if ($bCond)
    return $sValue1;
  return $sValue2;
}

function ftt_html_text($str)
{
  return htmlspecialchars($str);
}
