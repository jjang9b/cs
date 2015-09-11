<form id="f_search">
  <div class="box-body">
    <?php if(in_array('input', $aSearchWidget))
      { 
        foreach($aSearchTypeList as $sSearchTypeText=>$sSearchTypeVal)
        {
          $sSearchTypeTitle = $sSearchTypeText;
          break;
        }
    ?>
    <div class="form-group">
      <div class="input-group col-xs-5">
        <div class="input-group-btn">
          <button type="button" class="btn bg-navy dropdown-toggle" data-toggle="dropdown">
          <span id="txt_usn_type"><?= $sSearchTypeTitle ?></span><span class="fa fa-caret-down"></span></button>

          <ul class="dropdown-menu" id="uSearchType">
            <?php 
            foreach($aSearchTypeList as $sSearchTypeText=>$sSearchTypeVal)
            {
            ?>
              <li value="<?= $sSearchTypeVal ?>"><a href="javascript:void(0)"><?= $sSearchTypeText ?></a></li>
            <?php } ?>
          </ul>
        </div>

        <input type="text" name="pSearchValue" class="form-control" value="<?= $sSearchValue ?>" placeholder="<?= $sPlaceholder?>"/>
        <input type="text" name="pSearchType" style="display:none" value="<?= $sSearchType ?>"/>
      </div>
    </div>
    <?php } ?>

    <?php 
    if(in_array('select', $aSearchWidget))
    { 
    ?>
    <div class="row">
    <?php
      foreach($aSelectList as $sSelectKey=>$aSelectTypeList)
      {
    ?>
        <div class="col-md-2">
          <label><b><small><?= $aSelectTypeList['sTitle'] ?></small></b></label>&nbsp;
          <select name="pSearchSelectType_<?= $sSelectKey ?>" class="selectpicker" data-style="bg-gray" data-width="150px">
          <?php
          foreach($aSelectTypeList['aData'] as $sSelectTypeText=>$sSelectTypeVal)
          {
          ?>
            <option value="<?= $sSelectTypeVal ?>"><?= $sSelectTypeText ?></option>
          <?php } ?>
          </select>
        </div>
    <?php }?>
    </div>
    <br />
    <?php }?>

    <?php 
    if(in_array('date', $aSearchWidget))
    { 
      if(!$sSearchDate)
        $sSearchDate = date('Y/m/d H:i:s', strtotime('-1 week')).' - '.date('Y/m/d H:i:s');
    ?>
    <div class="form-group">
      <label><b><small>시작, 종료 일자</small></b></label>
      <div class="input-group col-xs-5">
        <div class="input-group-addon">
          <i class="fa fa-clock-o"></i>
        </div>
        <input type="text" class="form-control pull-right" id="reservationtime" name="pSearchDate" value="<?= $sSearchDate ?>" />
      </div>
    </div>
    <?php }?>
     
    <div class="form-group">
      <div class="input-group col-xs-5">
        <span class="input-group-btn">
          <button type="button" name="btn_search" class="btn btn-default">조회</button>
        </span>
      </div>
    </div>

  </div>
</form>
