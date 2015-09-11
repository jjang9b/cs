<?php
class DataInverter
{
  public function getArrayValKeyMap($aPrimaryData, $aSecondData)
  {
    $aResult = array();
    foreach ($aPrimaryData as $key => $val)
    {
      if($aSecondData[$val])
        $aResult[$val] = $aSecondData[$val];
      else
        $aResult[$val] = $val;
    }

    return $aResult;
  }
}
