<div class="page-header">
  <small>
    <h5><b>GM 변경 이력 조회</b></h5>
  </small>
</div>
<?php 
$this->load->view('common/widget/search_form', array(
        'aSearchWidget'=>array('input', 'date'), 
        'aSearchTypeList'=>array('GM 번호'=>1))); 

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
