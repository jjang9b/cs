<?php
if($aData)
{
  if(!is_array($aData[0]) && gettype($aData[0]) != 'object')
    $aData = array($aData);
?>
<div class="box-body">
  <form name="f_edit">
  <div class="table-responsive">
  <table name="t_datatable" class="table table-bordered">
    <thead>
    <tr>
      <th class="bg-navy"></th>
<?php
  foreach($aData as $aDataResult)
  {
    foreach($aDataResult as $sColumn=>$sValue )
    {

      if($aTableInfo[ 'columnText' ][ $sColumn ])
        $sColumnText = $aTableInfo[ 'columnText' ][ $sColumn ];
      else
        $sColumnText = $sColumn;
?>
    <th class="bg-navy"><h5><?= $sColumnText ?></h5></th>
<?php 
    }
    break;
  } 
?>
    </tr>
    </thead>
    <tbody>

<?php 
  $i = 0;
  foreach($aData as $aDataResult)
  {
    if($i >= $sViewMaxCount){
      $i++;
      break;
    }
    $i++;
?>
    <tr>
      <td><a name="btn_auth_edit" class="btn bg-navy">권한 및 정보수정</a></td>
<?php 
    foreach($aDataResult as $sColumn=>$sValue )
    {
?>
      <td name="tdSelect" data-primary_string="<?=$sColumn?>|<?=$sValue?>">
        <h5><span class="text-black"><?= $sValue ?></span></h5>
<?php
      if($aTableInfo[ 'editColumn' ][ $sColumn ])
      {
?>
        <a name="btn_edit" class="btn bg-navy" data-column_name="<?= $sColumn ?>"><i class="fa fa-edit"></i></a>
<?php
      }
?>
      </td>
<?php 
    }
?>
      </tr>
<?php 
  }
  if($i > $sViewMaxCount)
  {
?>
    <p><small class="text-navy"><b>같은 조건에 <span class="text-red"><?= $sViewMaxCount?></span>개 이상의 데이터가 존재 합니다. 
    조건을 변경해서 추가 조회해 주세요.</b></small></p>
<?php 
  } 
?>
      </tbody>
    </table>
    </div>
    <input type="text" style="display:none" name="pMenuName" value="<?= $sMenuName ?>" />
    <input type="text" style="display:none" name="pDsn" value="<?= $aTableInfo[ 'dsn' ] ?>" />
    <input type="text" style="display:none" name="pTableName" value="<?= $aTableInfo[ 'table' ] ?>" />
    <input type="text" style="display:none" name="pTableType" value="<?= $sTableType ?>" />
  </form>
</div>
<?php 
}
?>
