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
?>

<div class="row">
  <div class="col-md-16">
    <?= $aAccountResultView ?>
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
<input type="hidden" id="i_isaccount" value="true" />
