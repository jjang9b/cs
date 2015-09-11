<div class="page-header">
  <small>
    <h5><b>Log 테이블 조회</b></h5>
  </small>
</div>

<p><small><b class="text-red">유저 고유번호</b> <b>로 조회해 주세요.</b></small></p>

<?php 
$this->load->view('common/widget/search_form', array(
      'aSearchWidget'=>array('input', 'date'),
      'aSearchTypeList'=>$aCategoryList, 'sPlaceholder'=>'유저 고유번호'));

if($nTabDataCount > 0)
{
  $this->load->view('common/widget/util_buttons', array('table_type'=>'tab') );
?>
<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">

      <ul id="u_tabtable" class="nav nav-tabs">
        <li class="active"><a name="a_tab" data-toggle="tab" data-table=<?= $aTabTableInfo[ 'table' ]?>>
          <small><b><?= $aTabTableInfo[ 'tableText' ] ?></b></small></a></li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="tab_0"><?= $aTabResultView ?></div>
      </div>

    </div>
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
