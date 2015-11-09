<div class="page-header">
  <small>
    <h5><b>유저 제재 조회</b></h5>
  </small>
</div>
<?php 
$this->load->view('common/widget/search_form', array(
      'aSearchWidget'=>array('date', 'select'), 
      'aSearchTypeList'=>array('유저 고유번호'=>1), 
      'aSelectList'=>array(
        'problemReason'=>array('sTitle'=>'문제 사유', 'aData'=>array('전체'=>'all', '데이터변조'=>'modulation', '스피드핵'=>'hack', '어뷰징'=>'abuse'))
      )
));

$sExpireDt = date('Y-m-d H:i:s', strtotime('+1 week'));

if($nMainDataCount > 0)
{ 
  $this->load->view('common/widget/util_buttons', array('table_type'=>'main'));
?>
<div class="row">
  <div class="col-md-12">
    <?= $aMainResultView ?>
  </div>
</div>
<?php
} 
else 
{
  if($sSearchValue || $sSearchDate)
  {
?>
  <br /><p><small><b class="text-danger">&nbsp;&nbsp;데이터가 없습니다.</b></small></p>
<?php }} ?>
<br />

<div class="row">
  <div class="col-md-6">
    <div class="box box-gray">
      <div class="box-header">
        <span class="box-title"><small><b class="text-navy">유저 제재 / 해제</b></small></span>
      </div>
      <form name="f_post">
        <div class="box-body">
          <div class="form-group">
            <small><b>유저 제재 타입</b></small><br />
            <select name="pRestrictType" class="selectpicker" data-style="bg-navy">
              <option value="1">유저 제재</option>
              <option value="2">유저 제재 해제</option>
            </select>
          </div>
          <br />
          <div class="form-group">
            <small><b>문제 사유</b></small><br />
            <select name="pRestrictUserReason" class="selectpicker" data-style="bg-navy">
              <option value="1">데이터 변조</option>
              <option value="2">스피드핵</option>
              <option value="3">어뷰징</option>
            </select>
          </div>
          <div class="form-group">
            <small><b>사유 <span class="text-danger">(GM 지급 사유)</span></b></small>
            <input type="text" class="form-control" name="pRestrictGmReason" />
          </div>
          <div class="form-group">
            <small><b>유저 제재 유효일시<span class="text-danger">(제재 제한 만료 일시)</span></b></small>
            <input type="text" class="form-control" name="pRestrictExpireDt" value="<?= $sExpireDt?>" />
          </div>
          <div class="form-group">
            <small><b>제재/해제 대상 유저 <span class="text-danger">(유저 고유번호)</span></b></small>&nbsp;
            <small><b>1회 최대 유저 제재 제한수 : <span class="text-yellow"><?= $sMaxPostCount ?></span>명</b></small>
            <textarea type="text" rows="5" class="form-control" name="pRestrictUser" placeholder="유저 다수 입력시 , (콤마) 로 구분"></textarea>
          </div>
        </div>
      </form>
      <div class="box-footer">
        <button name="btn_restrict" class="btn bg-white"><b>유저 제재/해제</b></button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="postWaitModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title"><small>유저 제재 / 해제</small></h4>
      </div>
      <div class="modal-body">
        <span id="txtPostModal"class="text-navy">유저 제재/해제 중입니다.</span>
      </div>
      <div class="modal-footer">
        <a href="javascript:void(0)" data-dismiss="modal" class="btn bg-white">닫기</a>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="i_sMaxPostCount" value="<?= $sMaxPostCount ?>" />
<input type="hidden" id="i_sPostTimeOutSecond" value="<?= $sPostTimeOutSecond ?>" />
