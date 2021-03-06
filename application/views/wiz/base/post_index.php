<div class="page-header">
  <small>
    <h5><b>우편함 지급</b></h5>
  </small>
</div>
<?php 
$this->load->view('common/widget/search_form', array(
      'aSearchWidget'=>array('input', 'date'),
      'aSearchTypeList'=>array('유저 고유번호'=>1)));

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
  if($sSearchValue)
  {
?>
  <br /><p><small><b class="text-danger">&nbsp;&nbsp;데이터가 없습니다.</b></small></p>
<?php }} ?>
<br />

<div class="row">
  <div class="col-md-6">
    <div class="box box-gray">
      <div class="box-header">
        <span class="box-title"><small><b class="text-navy">우편함 지급</b></small></span>
      </div>
      <form name="f_post">
        <div class="box-body">
          <div class="form-group">
            <small><b>우편함 노출 메세지</b> 
            <b class="text-danger"> (메세지 텍스트)</b></small>
            <input type="text" class="form-control" name="pPostMsg" />
          </div>
          <div class="form-group">
            <small><b>지급 아이템</b></small>
            <input type="text" class="form-control" name="pPostItemStr" />
          </div>
          <div class="form-group">
            <small><b>지급 사유 <span class="text-danger">(GM 지급 사유)</span></b></small>
            <input type="text" class="form-control" name="pPostReason" />
          </div>
          <div class="form-group">
            <small><b>우편함 지급 유효일시</b></small>
            <input type="text" class="form-control" name="pPostExpireDt" value="<?= $sExpireDt?>" />
          </div>
          <div class="form-groupo">
            <small><b>전체 유저 지급</b></small>
            <div class="checkbox">
              <label><input name="pPostIsAll" type="checkbox"> <b class="text-danger">전체 유저 발송</b></label>
            </div>
          </div>
          <div name="d_post_user" class="form-group">
            <small><b>발송 대상 유저 <span class="text-danger">(유저 계정 번호)</span></b></small>&nbsp;
            <small><b>1회 최대 유저 지급 제한수 : <span class="text-yellow"><?= $sMaxPostCount ?></span>명</b></small><br />
            <small><b class="text-danger">엔터 (Enter)</b> 로 대상 유저를 구분해서 입력해 주세요</small>&nbsp;
            <textarea type="text" rows="5" class="form-control" name="pPostUser" placeholder="유저 다수 입력시 , (엔터) 로 구분"></textarea>
          </div>
        </div>
      </form>
      <div class="box-footer">
        <button name="btn_post" class="btn bg-white"><b>우편 발송</b></button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="postWaitModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><small>우편함 지급</small>
          <a href="javascript:void(0)" name="btn_modal_close" data-dismiss="modal" class="btn bg-white pull-right">닫기</a>
        </h4>
      </div>
      <div class="modal-body">
<div id="txtModalMsg">
  <span id="txtPostModal" class="text-navy"><b>우편 발송 중입니다.</b></span>
  <span class="text-red"><b> 완료되기 전까지 브라우저를 닫지 말아 주세요.</b></span>
</div>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="i_sMaxPostCount" value="<?= $sMaxPostCount ?>" />
<input type="hidden" id="i_sPostTimeOutSecond" value="<?= $sPostTimeOutSecond ?>" />
