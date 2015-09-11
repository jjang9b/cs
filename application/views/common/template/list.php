<?php 
if( $aData )
{
?>
<form name="f_edit">
  <div class="box-body">
<?php
if(count($aData) == 1)
  $aResultData = $aData[0];
else
  $aResultData = $aData;

  foreach($aResultData as $sColumn=>$sValue)
  {
?>
    <p name="tdSelect" data-primary_string="<?=$sColumn?>|<?=$sValue?>">
      <b><?= ($aColumnText[ $sColumn ] ? $aColumnText[ $sColumn ] : $sColumn) ?></b>
      <b class="text-danger"> <?= $sValue ?></b>
<?php
  if($aTableInfo[ 'editColumn' ][ $sColumn ])
  {
?>
      <a name="btn_edit" class="btn bg-navy" data-column_name="<?= $sColumn ?>"><i class="fa fa-edit"></i></a>
<?php
  }
?>
    </p>
<?php
  }
?>
  </div>
  <input type="text" style="display:none" name="pMenuName" value="<?= $sMenuName ?>" />
  <input type="text" style="display:none" name="pDsn" value="<?= $aTableInfo[ 'dsn' ] ?>" />
  <input type="text" style="display:none" name="pTableName" value="<?= $aTableInfo[ 'table' ] ?>" />
  <input type="text" style="display:none" name="pTableType" value="<?= $sTableType ?>" />
</form>
<?php 
} 
?>
