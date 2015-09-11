<div class="page-header">
  <small>
    <h5><b>주문 등록 / 조회</b></h5>
  </small>
</div>
<?php 
$this->load->view('common/widget/search_form', array(
      'aSearchWidget'=>array('input', 'date'),
      'aSearchTypeList'=>array('유저 고유번호'=>1, '주문 번호'=>2)));

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

<div class="row" id="d_order">
  <div class="col-md-6">
    <div class="box box-gray">
      <div class="box-header">
        <span class="box-title"><small><b>주문 등록</b></small></span>
      </div>
      <div class="box-body">
        <div class="form-group">
          <small><b>유저 고유번호</b></small>
          <input type="text" class="form-control" name="pOrderAccountIdx">
        </div>
        <div class="form-group">
          <small><b>주문 os type</b></small>
          <br />
          <select id="sel_order_os" class="selectpicker" data-style="bg-navy">
            <?php 
            foreach ($aOsList as $sOsName=>$sOsValue)
            {
            ?>
            <option value="<?= $sOsValue?>"><?= $sOsName ?></option>
            <?php } ?> 
            
          </select>
        </div>
        <div class="form-group">
          <small><b>주문 store type</b></small>
          <br />
          <select id="pOrderStore" class="selectpicker" data-style="bg-navy">
            <?php 
            foreach ($aStoreList as $sStoreName=>$sStoreValue)
            {
            ?>
            <option value="<?= $sStoreValue?>"><?= $sStoreName ?></option>
            <?php } ?> 
            
          </select>
        </div>
        <div class="form-group">
          <small><b>주문 번호</b></small>
          <input type="text" class="form-control" name="pOrderId">
        </div>
        <div class="form-group">
          <small><b>복구 아이템</b></small>
          <br />
          <select id="pOrderProduct" class="selectpicker" data-style="bg-navy">
            <?php 
            foreach ($aItemList as $aItemId=>$aItemName)
            {
            ?>
            <option value="<?= $aItemId ?>"><?= $aItemName ?></option>
            <?php } ?> 
            
          </select>
        </div>
        <div class="form-group">
          <small><b>추가 지급 포인트</b></small>
          <br />
          <select id="pOrderBonus" class="selectpicker" data-style="bg-navy">
            <?php 
            foreach ($aItemPercentList as $sPercentName=>$sPercentValue)
            {
            ?>
            <option value="<?= $sPercentValue?>"><?= $sPercentName ?></option>
            <?php } ?> 
          </select>
        </div>
        <div class="form-group">
          <small><b>주문 등록 사유 (추가 메모)</b></small>
          <input type="text" class="form-control" name="pOrderMemo" />
        </div>
      </div>
      <div class="box-footer">
        <button name="btn_order" class="btn bg-white"><b>주문 등록</b></button>
      </div>
    </div>
  </div>
</div>
