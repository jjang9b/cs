<?php 
if($aData)
{
?>
    <div class="box box-solid">
      <div class="box-header">
          <h3 class="box-title">
            <small><b class="text-danger">유저 조회 List</b></small>
          </h3>
      </div>
        <div class="box-body">
          <div class="form-group">
<?php
if(!is_array($aData[0]) || count($aData) == 1)
{
  if(!is_array($aData[0]))
    $aResultData = $aData;
  else
    $aResultData = $aData[0];

  foreach($aResultData as $sColumn=>$sValue)
  {
    if($aTableInfo[ 'whereColumn' ][0] == $sColumn)
      $sThisValue = $sValue;
?>
            <label><?= ($aTableInfo[ 'columnText' ][ $sColumn ] ? $aTableInfo[ 'columnText' ][ $sColumn ] : $sColumn) ?>&nbsp;
            <b class="text-yellow"> <?= $sValue ?> </b></label>&nbsp;
<?php } ?>
            <button name="btn_before_search" data-usn="<?= $sThisValue ?>" class="btn bg-white"><b>조회</b></button>
          </div>
<?php
}
else
{
  $aResultData = $aData;

  foreach($aResultData as $sIdx=>$aList)
  {
?>
          <div class="form-group">
<?php
    foreach($aList as $sColumn=>$sValue)
    {
      if($aTableInfo[ 'whereColumn' ][0] == $sColumn)
        $sThisValue = $sValue;
?>
          <label><?= ($aTableInfo[ 'columnText' ][ $sColumn ] ? $aTableInfo[ 'columnText' ][ $sColumn ] : $sColumn) ?>&nbsp;
          <b class="text-yellow"> <?= $sValue ?> </b></label>&nbsp;
<?php
    }
?>
          <button name="btn_before_search" data-usn="<?= $sThisValue ?>" class="btn bg-white"><b>조회</b></button>
        </div>
<?php
  }
}
?>
      </div>
    </div>
<?php } ?>
