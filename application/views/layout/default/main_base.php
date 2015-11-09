<div id="d_csmain">
  <section class="content-header">
    <h4> csTool <small>Games</small></h4>
  </section>

  <section class="content">
<?php
$i = 0;
foreach($aMainSsnList as $sSsn)
{
  if($aAuthMenuIdx[$sSsn]){
    if($aAuthMenuList->{$aAuthMenuIdx[ $sSsn ]})
    {
      if($i % 3 == 0){
?>
    <div class="col-md-4" style="clear:both !important">
<?php } else { ?>
    <div class="col-md-4">
<?php } ?>
      <div class="box box-solid">
        <div class="box-header">
          <img src="/res/img/common/banner/<?= $sSsn ?>.jpg" onerror="this.src='/res/img/common/banner/default.jpg'">
          <h5 class="box-title"><small><b class="text-navy"> <?= $aAuthMenuList->{$aAuthMenuIdx[ $sSsn ]}->service_name ?></b></small></h5>
        </div>
        <div class="box-body">
          <ul class="sidebar sidebar-menu">
<?php
        foreach($aAuthMenuList->{$aAuthMenuIdx[ $sSsn ]}->menus as $sMenuIdx=>$oMenu)
        {
?>
            <li>
              <a href="<?= $oMenu->menu_url ?>"><p><small><b class="text-black"><?= $oMenu->menu_name ?></b></small></p></a>
            </li>
<?php
        }
?>
          </ul>
        </div>
      </div>
    </div>
<?php 
    $i++;
  }}} 
?>
  </section>

  <?php if($isDev){ ?>

  <section class="content-header">
    <h4> csTool <small>Wizard</small></h4>
  </section>

  <section class="content">
    <div class="col-md-4">
      <div class="box box-solid bg-gray">
        <div class="box-header">
          <h5 class="box-title"><small><b>Wizard</b></small></h5>
        </div>
        <div class="box-body">
          <ul>
            <li><p><a href="/wiz/account"><small><b class="text-white">사용자 정보 조회 생성</b></small></a></p></li>
            <li><p><a href="/wiz/define"><small><b class="text-white">정의 테이블 조회 생성</b></small></a></p></li>
            <li><p><a href="/wiz/log"><small><b class="text-white">로그 조회 생성</b></small></a></p></li>
            <li><p><a href="/wiz/order"><small><b class="text-white">주문 등록/조회 생성</b></small></a></p></li>
            <li><p><a href="/wiz/post"><small><b class="text-white">우편함 지급/조회 생성</b></small></a></p></li>
            <li><p><a href="/wiz/restrict"><small><b class="text-white">유저 제재 및 해제/조회 생성</b></small></a></p></li>
            <li><p><a href="/wiz/accessLog"><small><b class="text-white">GM 변동 이력 조회 생성</b></small></a></p></li>
            <li><p><a href="/wiz/auth"><small><b class="text-white">GM 계정 관리 생성</b></small></a></p></li>
            <li><p><a href="/wiz/custome"><small><b class="text-white">Custome 생성</b></small></a></p></li>
          </ul>
        </div>
      </div>
    </div>
  </section>
</div>
<?php } ?>
