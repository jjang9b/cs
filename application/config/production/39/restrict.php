<?php
$config['menuName']='restrict';
$config['accessLog']=1;

$config['main']['tb_block']['table']='tb_block';
$config['main']['tb_block']['dsn']='gm_monshot';

$config['main']['tb_block']['procedure']='monshot.USP_Insert_tb_block_bulk';
$config['main']['tb_block']['api'][0]='http://ms-cs-api.fttinc.kr:19995/GM.asmx/LoginInvalidation';
$config['main']['tb_block']['api'][1]='http://ms-cs-api.fttinc.kr:19995/GM.asmx/RankingRemove';

$config['main']['tb_block']['column']['0']='id';
$config['main']['tb_block']['column']['1']='tb_player_id';
$config['main']['tb_block']['column']['2']='idx';
$config['main']['tb_block']['column']['3']='flag';
$config['main']['tb_block']['column']['4']='comment_reason';
$config['main']['tb_block']['column']['5']='createdDt';
$config['main']['tb_block']['column']['6']='limitedDt';

$config['main']['tb_block']['columnText']['id']='식별자';
$config['main']['tb_block']['columnText']['tb_player_id']='사용자 식별자';
$config['main']['tb_block']['columnText']['idx']='징계 구분';
$config['main']['tb_block']['columnText']['flag']='관련 사항';
$config['main']['tb_block']['columnText']['comment_reason']='징계 사유';
$config['main']['tb_block']['columnText']['createdDt']='시작 일시';
$config['main']['tb_block']['columnText']['limitedDt']='징계 종료 일시';
$config['main']['tb_block']['editColumn']['limitedDt']='limitedDt';

$config['main']['tb_block']['viewType']='table';
$config['main']['tb_block']['whereColumn']['0']='tb_player_id';
$config['main']['tb_block']['tableText']='제재 정보';


$config['main']['tb_player']['table']='tb_player';
$config['main']['tb_player']['dsn']='gm_monshot';
$config['main']['tb_player']['column']['0']='id';
$config['main']['tb_player']['column']['1']='pltfrm';
$config['main']['tb_player']['column']['2']='usn';
$config['main']['tb_player']['whereColumn']['0']='id';


$config['main']['force_cmd']['dsn']='gm_monshot';
$config['main']['force_cmd']['procedure']['1']='monshot.USP_Write_tb_player';
$config['main']['force_cmd']['procedure']['2']='monshot.USP_Insert_tb_block';
$config['main']['force_cmd']['procedure']['3']='monshot.USP_Update_tb_player_resurrect';

