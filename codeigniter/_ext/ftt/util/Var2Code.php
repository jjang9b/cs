<?php
class Var2Code
{
  public function make($sVarName, $mVarValue)
  {
    $aPhpCode = array();

    if (is_object($mVarValue))
    {
      foreach ($mVarValue as $key => $mCurVar)
      {
        //$aPhpCode[] = $sVarName.' = new \stdClass;'; 
        $aPhpCode[] = $this->make($sVarName.'->{\''.$key.'\'}', $mCurVar);
      }
    }
    else if (is_array($mVarValue))
    {
      foreach ($mVarValue as $key => $mCurVar)
      {
        //$aPhpCode[] = $sVarName.' = array();';
        $aPhpCode[] = $this->make($sVarName.'[\''.$key.'\']', $mCurVar);
      }
    }
    else
    {
      if (is_string($mVarValue))
        $aPhpCode[] = $sVarName.'=\''.str_replace('\'', '\\\'', $mVarValue).'\';';
      else
        $aPhpCode[] = $sVarName.'='.$mVarValue.';';
    }

    return implode("\n", $aPhpCode);
  }
}
/*
$o->{'db'}='db.attendence';
$o->{'user'}['info']['0']='usn';
$o->{'user'}['info']['name']='name';
$o->{'user'}['info']['address']=array('home', 'office');

$oV2C = new Var2Code();
echo $oV2C->make('$myvar', $o);
*/
