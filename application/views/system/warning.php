<div class="row">
  <div class="alert alert-danger" role="alert">
<?php if($nMsgType == 1){ ?>
    <strong>로그인 후 이용가능합니다.</strong>
<?php } elseif($nMsgType == 2){ ?>
    <strong>접근 권한이 필요합니다.&nbsp;담당자에게 권한을 요청해 주세요.</strong>
<?php } else if($nMsgType == 3){ ?>
    <strong>정지된 계정입니다.</strong>
<?php } ?>
  </div>
</div>
