<?php 
if( $aData )
{
?>
<div class="box-body">
  <small><b class="text-danger"><?= $aTableInfo[ 'tableText' ] ?></b></small>
  <p>
    <form name="f_edit">
    <div class="table-responsive">
      <table name="t_listaccount" class="table table-bordered">
        <tbody>
          <tr>
<?php
$sStartNum = 1;

if(count($aData) == 1)
  $aResultData = $aData[0];
else
  $aResultData = $aData;

foreach($aResultData as $sColumn=>$sValue)
{
  if(($i%4 == 0))
  {
    if($sStartNum == 1 || ($sStartNum > $sLastNum))
      $sLastNum = $sStartNum + 3;
?>
<?php 
  }
?>
          <td><?= ($aTableInfo[ 'columnText' ][ $sColumn ] ? $aTableInfo[ 'columnText' ][ $sColumn ] : $sColumn) ?></td>
          <td name="tdSelect" data-primary_string="<?=$sColumn?>|<?=$sValue?>" style="word-wrap:break-word;max-width:150px">
            <b class="text-black"><?= $sValue ?></b>
<?php
  if($aTableInfo[ 'editColumn' ][ $sColumn ] && $sIsWrite)
  {
?>
            <a name="btn_edit" class="btn bg-navy" data-column_name="<?= $sColumn ?>"><i class="fa fa-edit"></i></a>
<?php
  }
?>
          </td>
<?php
  if($sStartNum == $sLastNum)
  {
?>
          </tr>
<?php
  }
  $sStartNum++;
}
?>
        </tbody>
      </table>
      </div>
      <input type="text" style="display:none" name="pMenuName" value="<?= $sMenuName ?>" />
      <input type="text" style="display:none" name="pDsn" value="<?= $aTableInfo[ 'dsn' ] ?>" />
      <input type="text" style="display:none" name="pTableName" value="<?= $aTableInfo[ 'table' ] ?>" />
      <input type="text" style="display:none" name="pTableType" value="<?= $sTableType ?>" />

      <input type="hidden" id="iIsListAccount" value="true" />
    </form>
  </p>
</div>
<?php 
} 
