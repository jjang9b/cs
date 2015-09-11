<?php 
if($aData)
{
?>
<form name="f_edit">
  <div class="box box-solid">
    <div class="box-header">
      <h3 class="box-title">
        <small><b>유저 조회 List</b></small>
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
          <span name="tdSelect" data-primary_string="<?=$sColumn?>|<?=$sValue?>">
<?php
  if($aTableInfo[ 'editColumn' ][ $sColumn ])
  {
?>
            <a name="btn_edit" class="btn bg-navy" data-column_name="<?= $sColumn ?>"><i class="fa fa-edit"></i></a>
<?php
  }
?>
          </span>
<?php } ?>
        </div>
      </div>
    </div>
  <input type="text" style="display:none" name="pMenuName" value="<?= $sMenuName ?>" />
  <input type="text" style="display:none" name="pDsn" value="<?= $aTableInfo[ 'dsn' ] ?>" />
  <input type="text" style="display:none" name="pTableName" value="<?= $aTableInfo[ 'table' ] ?>" />
  <input type="text" style="display:none" name="pTableType" value="<?= $sTableType ?>" />
</form>
<?php }} ?>
