<div class="box-body">

  <a name="btn_util" class="btn bg-white" data-button_type='excel' data-table_type='<?= $table_type ?>'>
    <i class="fa fa-save"></i> Excel Download</a>

  <?php if (!$is_window){ ?>
  <a name="btn_util" class="btn bg-white" data-button_type='window' data-table_type='<?= $table_type ?>'>
    <i class="fa fa-windows"></i> 새창</a>
  <?php } ?>

  <form id="f_util">
    <input type="text" style="display:none" name="pTableName" />
    <input type="text" style="display:none" name="pTableType" />
    <input type="text" style="display:none" name="pWhereValParam" value="<?= $aWhereValParam?>" />
    <input type="hidden" id="sCurrentTable" class="form-control" value="<?= $sCurrentTable ?>"/>
  </form>
</div>
<div style="height:30px"></div>
