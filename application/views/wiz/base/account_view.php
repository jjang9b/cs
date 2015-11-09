<div class="page-header">
  <small>
    <h5><b>사용자 정보 조회</b></h5>
  </small>
</div>
<?php 
$this->load->view('common/widget/search_form', array(
        'aSearchWidget'=>array('input'),
        'aSearchTypeList'=>array('유저 고유 번호'=>1, '고객번호'=>2, '닉네임'=>3, '이메일'=>3, '휴대폰 번호'=>4)));

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
<?php 
  }
}
if($nMainDataCount > 0)
{ 
?>

<br />
<div class="row">
  <div class="col-md-3">
    <div class="box box-gray">
      <div class="box-header">
        <span class="box-title"><small><b class="text-navy">유저 정보 수정</b></small></span>
      </div>
      <form name="frm_userinfo">
        <div class="box-body">
          <div class="form-group">
            <small>유저 고유번호</small>
            <input type="text" class="form-control" name="pInfoAccountIdx" value="<?= $nAccountIdx?>" disabled />
          </div>
          <div class="form-group">
            <select name="pInfoType" class="selectpicker" data-style="bg-navy">
              <option value="passwd">비밀 번호</option>
              <option value="email">이메일</option>
              <option value="pointAmount">포인트 추가/회수</option>
            </select>
          </div>
          <div class="form-group">
            <small>현재 값</small>
            <input type="text" class="form-control" name="pInfoNow" value="<?= $sPasswd?>" disabled />
            <input type="hidden" id="p_passwd" value="<?= $sPasswd?>"/>
            <input type="hidden" id="p_email" value="<?= $sEmail?>"/>
            <input type="hidden" id="p_pointAmount" value="<?= $nPointAmount?>"/>
          </div>
          <div class="form-group">
            <small>수정 값</small>
            <input type="text" class="form-control" name="pInfoAfterValue" />
          </div>
          <div class="form-group">
            <small>사유</small>
            <input type="text" class="form-control" name="pInfoMemo" />
          </div>
        </div>
      </form>
      <div class="box-footer">
        <button name="btn_userinfo" class="btn bg-white"><b>유저 정보 수정</b></button>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="box box-gray">
      <div class="box-header">
        <span class="box-title"><small><b class="text-navy">유저 상태 변경</b></small></span>
      </div>
      <form name="frm_userstate">
        <div class="box-body">
          <div class="form-group">
            <small>유저 고유번호</small>
            <input type="text" class="form-control" name="pStateAccountIdx" placeholder="<?= $nAccountIdx?>" value="<?= $nAccountIdx?>" disabled />
          </div>
          <div class="form-group">
            <select name="pStateType" class="selectpicker" data-style="bg-navy">
              <option value="blocked">유저 제재</option>
              <option value="recovery">탈퇴 계정 복구</option>
            </select>
          </div>
          <div name="d_blocked" class="form-group">
            <small>유저 제재 타입</small>
            <select name="pStateBlockedType" class="selectpicker" data-style="bg-navy">
              <option value=1>제재 해제</option>
              <option value=2>로그인 차단</option>
              <option value=3>PVP 이용 제한</option>
              <option value=4>채팅 제한</option>
            </select>
          </div>
          <div name="d_blocked" class="form-group">
            <small>유저 제재 상태</small>
            <input type="text" class="form-control" name="pStateBlockedFlag" placeholder="<?= $sBlockedFlag?>" value="<?= $sBlockedFlag?>" disabled />
          </div>
          <div name="d_blocked" class="form-group">
            <small>제재 기간 (일단위 숫자 입력 ex. 1)</small>
            <input type="text" class="form-control" name="pStateExpiredt" placeholder="" value="1" />
          </div>
          <div class="form-group">
            <small>사유</small>
            <input type="text" class="form-control" name="pStateMemo">
          </div>
        </div>
      </form>
      <div class="box-footer">
        <button name="btn_userstate" class="btn bg-white"><b>유저 상태 변경</b></button>
      </div>
    </div>
  </div>

</div>
<br />
<?php } ?>
<?php if($aTabInfo){ ?>
<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">

      <ul id="u_tabtable" class="nav nav-tabs">
      <?php
      $i = 0;

      foreach($aTabInfo as $sTabTableName=>$aTabTableInfo)
      {
        if( $i == 0 )
        {
          $sLogLinkTable = $sTabTableName;
      ?>
        <li class="active"><a name="a_tab" data-toggle="tab" data-table="<?= $sTabTableName ?>">
          <small><b><?= $aTabTableInfo[ 'tableText' ] ?></small></b></a></li>
      <?php
        } 
        else 
        { 
      ?>
        <li><a name="a_tab" data-toggle="tab" data-table="<?= $sTabTableName ?>">
          <small><b><?= $aTabTableInfo[ 'tableText' ] ?></small></b></a></li>
      <?php 
        }
        $i++;
      }
      ?>
        <li class="bg-navy"><a name="a_tab_log" data-table='<?= $sLogLinkTable ?>'><small><b class="text-yellow">Log 전체 조회</small></b></a></li>
      </ul>

      <div class="tab-content">

        <?php $this->load->view('common/widget/util_buttons', array('table_type'=>'tab')) ?>

        <div class="tab-pane active" id="tab_0"><?= $aTabResultView ?></div>
      </div>

    </div>
  </div>
</div>
<?php } ?>
<input type="hidden" id="i_isaccount" value="true" />
