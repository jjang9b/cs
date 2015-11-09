<div class="page-header">
  <small>
    <h5><b>GM 계정 관리</b></h5>
  </small>
</div>
<?php 
if($nMainDataCount > 0)
{
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
?>
  <br /><p><small><b class="text-danger">&nbsp;&nbsp;데이터가 없습니다.</b></small></p>
<?php } ?>
<br />

<div class="row" id="d_order">
  <div class="col-md-6">
    <div class="box box-gray">
      <div class="box-header">
        <span class="box-title"><small><b>GM 계정 생성</b></small></span>
      </div>
      <form name="frm_auth">
        <div class="box-body">
          <div class="form-group">
            <small><b>GM 이름</b></small>
            <input type="text" class="form-control" name="pGmName">
          </div>
          <div class="form-group">
            <small><b>GM 아이디</b>&nbsp;<b class="text-red">(중복 불가)</b></small>
            <input type="text" class="form-control" name="pGmId">
          </div>
          <div class="form-group">
            <small><b>GM 비밀번호</b></small>
            <input type="password" class="form-control" name="pGmPassword" />
          </div>
          <div class="form-group">
            <small><b>GM 권한</b></small>
            <select name="pGmPrivilege" class="selectpicker" data-style="bg-navy">
              <option value="R">읽기 권한</option>
              <option value="W">쓰기 권한</option>
              <option value="A">어드민 권한</option>
            </select>
          </div>
          <div class="form-group">
            <small><b>GM 상태</b></small>
            <select name="pGmStatus" class="selectpicker" data-style="bg-navy">
              <option value="N">정상</option>
              <option value="D">중지</option>
            </select>
          </div>
          <br />
          <div class="form-group">
            <small><b>접근 가능 메뉴</b></small>
<?php 
foreach($aAuthMenu as $sMenuName=>$sMenuKey){
?>
            <div class="checkbox">
              <label><input name="pGmMenu" type="checkbox" value="<?= $sMenuKey ?>"> <?= $sMenuName ?></label>
            </div>
<?php
}
?>
          </div>
        </div>
      </form>
      <div class="box-footer">
        <button name="btn_auth_create" class="btn bg-white"><b>계정 생성</b></button>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="d_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title"><small class="text-navy">GM 유저 권한 및 정보수정</small></h4>
      </div>
      <form name="frm_auth_change"> 
      <div class="modal-body">
        <input type="intput" class="form-control" name="pGmModalIdx" style="display:none" />
        <div class="form-group">
          <small><b>GM 아이디</b></small>
          <input type="intput" class="form-control" name="pGmModalId" disabled />
        </div>
        <div class="form-group">
          <small><b>GM 비밀번호</b></small>
          <input type="password" class="form-control" name="pGmModalPassword" />
        </div>
        <div class="form-group">
          <small><b>사용자 권한</b></small>
          <select name="pGmModalPrivilege" class="selectpicker" data-style="bg-navy">
            <option value="R">읽기 권한</option>
            <option value="W">쓰기 권한</option>
            <option value="A">어드민 권한</option>
          </select>
        </div>
        <div class="form-group">
          <small><b>사용자 상태</b></small>
          <select name="pGmModalStatus" class="selectpicker" data-style="bg-navy">
            <option value="N">정상</option>
            <option value="D">중지</option>
          </select>
        </div>
        <div class="form-group">
          <small><b>접근 가능 메뉴</b></small>
<?php 
foreach($aAuthMenu as $sMenuName=>$sMenuKey){
?>
          <div class="checkbox">
            <label><input name="pGmModalMenu" type="checkbox" value="<?= $sMenuKey ?>"> <?= $sMenuName ?></label>
          </div>
<?php
}
?>
        </div>
      </div>
      </form>
      <div class="modal-footer">
        <a href="javascript:void(0)" name="btn_auth_change" class="btn bg-navy">변경</a>
        <a href="javascript:void(0)" data-dismiss="modal" class="btn bg-white">닫기</a>
      </div>
    </div>
  </div>
</div>
