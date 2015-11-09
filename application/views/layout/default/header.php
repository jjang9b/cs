<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="utf-8">
  <title>CSTool</title>
  <link rel="shortcut icon" href="/res/img/common/favicon/cs.png" type="image/x-icon">

  <link href="//static.four33.co.kr/external/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="//static.four33.co.kr/external/bootstrap/css/bootstrap-select.css" rel="stylesheet" type="text/css" />
  <link href="//static.four33.co.kr/external/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link href="//static.four33.co.kr/external/bootstrap/css/AdminLTE.css" rel="stylesheet" type="text/css" />
  <link href="//static.four33.co.kr/external/bootstrap/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
  <link href="//static.four33.co.kr/external/bootstrap/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
  <link href="/res/css/common.css" rel="stylesheet" type="text/css" />

  <script src="//static.four33.co.kr/external/jquery/jquery.min.js"></script>
  <script src="//static.four33.co.kr/external/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="//static.four33.co.kr/external/bootstrap/js/bootstrap-select.js" type="text/javascript"></script>
  <script src="//static.four33.co.kr/external_origin/adminlte_1.2/js/AdminLTE/app.js" type="text/javascript"></script>
  <script src="//static.four33.co.kr/external/bootstrap/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
  <script src="//static.four33.co.kr/external/bootstrap/js/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="//static.four33.co.kr/external/bootstrap/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
  <script src="/res/js/lib/jquery.cookie.js" type="text/javascript"></script>
  <script src="/res/js/common/csJs.js" type="text/javascript"></script>
</head>
<body>
  <header class="header">
    <a href="/" class="logo" style="background-color:#4C4C4C;color:#fff;">CSTOOL</a>
    <nav class="navbar navbar-static-top" role="navigation">
      <a href="javascript:void(0)" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only"></span>
        <span class="icon-bar" style="background-color:#111111"></span>
        <span class="icon-bar" style="background-color:#111111"></span>
        <span class="icon-bar" style="background-color:#111111"></span>
      </a>
      <div id="d_login_fail" class="cs_login">
        <div class="form-group col-xs-2">
          <input type="text" class="form-control" id="pGmId" placeholder="ID" />
        </div>
        <div class="form-group col-xs-2 passwd">
          <input type="password" class="form-control" id="pGmPassword" placeholder="PASSWORD" />
        </div>
        <span><button name="btn_login" class="btn bg-white">로그인</button></span>
      </div>
      <div id="d_login_success" class="cs_login_af" style="display:none">
        <div class="form-group col-md-2"> <span><h4><b id="b_login_userid"></b> <small>접속 중</small></h4></span> </div>
        <span><button name="btn_logout" class="btn bg-white">로그아웃</button></span>
      </div>
    </nav>
  </header>
  <div class="wrapper row-offcanvas row-offcanvas-left">
