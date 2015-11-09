<div class="page-header">
  <small>
    <h5><b>Define 테이블 조회</b></h5>
  </small>
</div>

<?php 
if($aTabInfo)
{
  $this->load->view('common/widget/util_buttons', array('table_type'=>'tab')); 
?>
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
      ?>
        <li class="active"><a name="a_tab" data-toggle="tab" data-table="<?= $sTabTableName ?>">
          <small><b><?= $aTabTableInfo[ 'tableText' ] ?></b></small></a></li>
      <?php
        } 
        else 
        { 
      ?>
        <li><a name="a_tab" data-toggle="tab" data-table="<?= $sTabTableName ?>">
          <small><b><?= $aTabTableInfo[ 'tableText' ] ?></b></small></a></li>
      <?php 
        }
        $i++;
      }
      ?>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_0"><?= $aTabResultView ?></div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
