<?php if ($sTableType == 'main'){ ?>

<div class="row">
  <div class="col-md-12">

    <?php $this->load->view('common/widget/util_buttons', array('table_type'=>'main', 'is_window'=>true) ) ?>
    <?= $aResultView ?>

  </div>
</div>

<?php } else { ?>

<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <div class="tab-content">

        <?php $this->load->view('common/widget/util_buttons', array('table_type'=>'tab', 'is_window'=>true)) ?>

        <div class="tab-pane active"><?= $aResultView ?></div>

      </div>
    </div>
  </div>
</div>

<?php } ?>
