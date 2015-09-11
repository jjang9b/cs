    <div class="row">
      <div class="col-md-8">
        <div class="box box-solid bg-gray">
          <div class="box-header">
              <h3 class="box-title">
                <small><b>GM 변경</b></small>
              </h3>
          </div>
<?php
if ($sAffectedRows > 0)
{
?>
          <div class="box-body">
            <div class="form-group">
              <label><b class="text-white">정상 변경 되었습니다.</b></label><br />
            </div>
          </div>
          <div class="box-footer">
            <p>
              <button name="btn_window_end" class="btn bg-navy">닫기</button>
            </p>
          </div>
<?php
}
else if($aPrimaryColumn)
{
?>
          <div class="box-body">
            <form id="f_window_edit">
<?php
  foreach ($aPrimaryColumn as $sPrimaryKey=>$sPrimaryColumn)
  {
?>
              <input type="text" style="display:none" name="pPrimaryColumn[]" value="<?= $sPrimaryColumn ?>" />
              <input type="text" style="display:none" name="pPrimaryValue[]" value="<?= $aPrimaryValue[ $sPrimaryKey ] ?>" />
<?php
  }

  foreach ($aColumnList as $aColumn)
  {
    if($aColumn->column_name == $sColumnName)
    {
      if($aTableInfo[ 'editColumnOption' ][ $aColumn->column_name ])
        $sColumnType = $aTableInfo[ 'editColumnOption' ][ $aColumn->column_name ][ 'type' ];

      else if(in_array(strtolower($aColumn->data_type), array('int', 'tinyint', 'bigint', 'smallint', 'mediumint')))
        $sColumnType = 1;
      elseif(in_array(strtolower($aColumn->data_type), array('datetime')))
        $sColumnType = 2;
      else
        $sColumnType = 3;
    }

    switch($sColumnType)
    {
      case 1 : 
        $sColumnTypeName = '숫자형';
        break;
      case 2 : 
        $sColumnTypeName = '날짜형';
        break;
      case 3 : 
        $sColumnTypeName = '문자형';
        break;
    }
  }
?>
              <div class="form-group">
                <label><small>변경 컬럼 및 현재 값</small> : <br />
                <b class="text-green"><?= $sColumnText?></b>&nbsp;
                <b class="text-yellow"><?= $aResultData[ $sColumnName ]?></b></label><br />
                <br />
              </div>
              <div class="form-group">
                <label><small>변경 컬럼 타입</small> : <br />
                <span class="text-green"><small><b class="text-yellow">숫자형</b>일 경우 증감 및 차감이 되며,
                <br />차감시 변경 값에 - (마이너스) 기호를 포함해 주세요.</small></span>
                <br /><br />
                <b class="text-yellow"><?= $sColumnTypeName?></b></label><br />
                <br />
              </div>
              <div class="row">
                <div  class="col-xs-8">
                  <small><b>변경 값</b></small> 
                  
                  <?php if($sColumnType == 2){ ?>
                  <input type="text" class="form-control pull-right" id="i_window_editdate" name="pEditValue" value="<?= $aResultData[ $sColumnName ] ?>" />
                  <?php } else { ?>
                  <input type="text" name="pEditValue" class="form-control" />
                  <?php }?>

                  <br />
                  <small><b>변경 사유</b></small> <textarea type="text" name="pEditReason" class="form-control"></textarea>
                  <br />
                </div>
              </div>
              <input type="text" name="pMenuName" style="display:none" value="<?= $sMenuName?>" />
              <input type="text" name="pTableType" style="display:none" value="<?= $sTableType?>" />
              <input type="text" name="pTableName" style="display:none" value="<?= $sTableName?>" />
              <input type="text" name="pColumnName" style="display:none" value="<?= $sColumnName?>" />
              <input type="text" name="pBeforeValue" style="display:none" value="<?= $aResultData[ $sColumnName ]?>" />
              <input type="text" name="pColumnType" style="display:none" value="<?= $sColumnType?>" />
            </form>
          </div>
          <div class="box-footer">
            <p>
              <button name="btn_window_edit" class="btn bg-maroon">변경</button>
              <button name="btn_window_close" class="btn bg-navy">닫기</button>
            </p>
          </div>

<?php
}
else
{
?>
          <div class="box-body">
            <div class="form-group">
              <label><b class="text-white">변경시 오류가 발생하였습니다.</b></label><br />
            </div>
          </div>
          <div class="box-footer">
            <p>
              <button name="btn_window_end" class="btn bg-navy">닫기</button>
            </p>
          </div>
<?php
}
?>

        </div>
      </div>
    </div>
  </div>
</body>
