<?php 
if($aMenuList){
?>
<aside class="left-side sidebar-offcanvas">
  <section class="sidebar">
    <ul class="sidebar-menu">

      <li class="treeview active">
        <ul class="treeview-menu">
          <li><img class="i_game_logo" src="/res/img/common/banner/<?= $url[0] ?>.jpg" 
            onerror="this.src='/res/img/common/banner/default.jpg'" /></li>
          <li class="menus">&nbsp;</li>
<?php 
  foreach($aMenuList as $sMenuName=>$mMenuList)
  {
    if(!is_array($mMenuList))
    {
?>
          <li class="menus">
            <a href="/<?= $url[0] ?>/<?= $mMenuList ?>">
            <small><b class="text-gray"><?= $sMenuName ?></b></small></a>
          </li>
<?php
    } 
    else 
    {
?>
          <li class="treeview menus">
            <a href="javascript:void(0)">
            <small><b><?= $sMenuName ?></b></small>
            <i class="fa pull-right fa-angle-down"></i></a>
            <ul class="treeview-menu">
<?php 
      foreach($mMenuList as $sSubMenuName=>$sSubMenuUrl)
      {
?>
          <li class="menus">
            <a href="/<?= $url[0] ?>/<?= $sSubMenuUrl ?>">
            <small><b class="text-gray"><?= $sSubMenuName?></b></small></a>
          </li>
<?php 
      }
?>
            </ul>
          </li>
<?php
    }
  }
?>
    </ul>
  </section>
</aside>
<?php
}
?>
