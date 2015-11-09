<?php
/* Auth 관련 테이블 */
$config['main']['t_simple_auth']['table']='t_simple_auth';
$config['main']['t_simple_auth']['dsn']='pubdb';
$config['main']['t_simple_auth']['column']['0']='idx';
$config['main']['t_simple_auth']['column']['1']='auth_id';
$config['main']['t_simple_auth']['column']['2']='auth_name';
$config['main']['t_simple_auth']['column']['3']='auth_password';
$config['main']['t_simple_auth']['column']['4']='auth_priv';
$config['main']['t_simple_auth']['column']['5']='auth_status';
$config['main']['t_simple_auth']['column']['6']='access_menu';
$config['main']['t_simple_auth']['column']['7']='modify_date';
$config['main']['t_simple_auth']['column']['8']='reg_date';
$config['main']['t_simple_auth']['columnText']['idx']='순번';
$config['main']['t_simple_auth']['columnText']['auth_id']='사용자 아이디';
$config['main']['t_simple_auth']['columnText']['auth_name']='사용자 이름';
$config['main']['t_simple_auth']['columnText']['auth_password']='사용자 비번';
$config['main']['t_simple_auth']['columnText']['auth_priv']='사용자 권한';
$config['main']['t_simple_auth']['columnText']['auth_status']='사용자 상태';
$config['main']['t_simple_auth']['columnText']['access_menu']='접근 가능 메뉴';
$config['main']['t_simple_auth']['columnText']['modify_date']='수정 날짜';
$config['main']['t_simple_auth']['columnText']['reg_date']='등록 날짜';
$config['main']['t_simple_auth']['whereColumn']['0']='auth_id';
$config['main']['t_simple_auth']['whereColumn']['1']='auth_password';
$config['main']['t_simple_auth']['tableText']='GM 계정 관리';

/* GM 로그 테이블 */
$config['t_cs_access_log']['table']='cstool_access_log';
$config['t_cs_access_log']['dsn']='pubdb';
$config['t_cs_access_log']['tableText']='GM 계정 관리';

/* Auth 설정 */
$config['auth_master'] = array(
  'admin'=>'admin'
);

$config['auth_menu'] = array(
  '사용자 계정 정보 조회'=>'account',
  '주문 복구/조회'=>'order',
  '우편함 발송 조회'=>'post',
  '공지사항 관리'=>'notice',
  '불법 프로그램 체크'=>'abusing',
  '제재유저 관리'=>'restrict',
  'GM 변경 로그'=>'gmlog',
  '암시장 관리'=>'blackmarket'
);
