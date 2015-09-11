<div class="page-header">
  <small>
    <h4><b class="text-light-blue">CSTool Wizard</b></h4>
  </small>
</div>

<h4 class="page-header">
  <small> <b>개발환경 설정 가이드<b/> </small>
</h4>
<div class="row">

  <div class="col-xs-8">
    <div class="box box-solid">
      <div class="box-header">
        <h4 class="box-title"><b>Install Shell</b></h4>
      </div>
      <div class="box-body">

        <code>sh <?= $shPath?>install.sh <?= $ssn.' '.$cfg?></code>
        <br /><br />

        <code>실행 후 예상 결과</code>
        <br /><br />
<pre>
<?php 
exec( 'sh '.$shPath.'install.sh '.$ssn.' '.$cfg, $out, $bb );

foreach( $out as $v )
echo trim( $v )."<br />";
?>
</pre>

      </div>
    </div>
  </div>

  <div class="col-xs-8">
    <div class="box box-solid">
      <div class="box-header">
        <h4 class="box-title"><b>Config Shell</b></h4>
      </div>
      <div class="box-body">

        <code>sh <?= $shPath?>install_cfg.sh <?= $ssn.' '.$cfg?></code>
        <br /><br />

        <code>실행 후 예상 결과</code>
        <br /><br />
<pre>
<?php 
exec( 'sh '.$shPath.'install_cfg.sh '.$ssn.' '.$cfg, $outCfg, $bb );

foreach( $outCfg as $cv )
echo trim( $cv )."<br />";
?>
</pre>

      </div>
    </div>
  </div>

  <div class="col-xs-8">
    <div class="box box-solid bg-maroon">
      <div class="box-header">
        <h4 class="box-title"><b><?= $cfg ?> 페이지 Url</b></h4>
      </div>
      <div class="box-body">
        <a href="/<?= $ssn ?>/<?=$cfg?>"><code>/<?= $ssn ?>/<?=$cfg?></code></a>
      </div>
    </div>
  </div>
</div>
