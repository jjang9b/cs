<?php
$config['menuName']='inGameEvent_setting';
$config['accessLog']=true;

$config['procedure']['name']='monshot.USP_Insert_def_event_settings';
$config['procedure']['dsn']='gm_monshot';
$config['api']='http://ms-cs-api.fttinc.kr:19995/GM.asmx/ReloadEvent';

$config['main']['def_event_settings']['table']='def_event_settings';
$config['main']['def_event_settings']['dsn']='gm_monshot';
$config['main']['def_event_settings']['column']['0']='evt_mid';
$config['main']['def_event_settings']['column']['1']='evt_name';
$config['main']['def_event_settings']['column']['2']='evt_type';
$config['main']['def_event_settings']['column']['3']='is_forever';
$config['main']['def_event_settings']['column']['4']='dtmain_begin';
$config['main']['def_event_settings']['column']['5']='dtmain_end';
$config['main']['def_event_settings']['column']['6']='period_main';
$config['main']['def_event_settings']['column']['7']='period_sub';
$config['main']['def_event_settings']['column']['8']='dtsub_a';
$config['main']['def_event_settings']['column']['9']='dtsub_b';
$config['main']['def_event_settings']['column']['10']='dtsub_c';
$config['main']['def_event_settings']['column']['11']='join_repeatable';
$config['main']['def_event_settings']['column']['12']='except_market';
$config['main']['def_event_settings']['column']['13']='detail_mid';
$config['main']['def_event_settings']['column']['14']='store_evt_key';
$config['main']['def_event_settings']['column']['15']='banner_show';
$config['main']['def_event_settings']['column']['16']='banner_first';
$config['main']['def_event_settings']['column']['17']='banner_second';
$config['main']['def_event_settings']['column']['18']='disabled';
$config['main']['def_event_settings']['columnText']['evt_mid']= '이벤트 메인 아이디';
$config['main']['def_event_settings']['columnText']['evt_name']= '이벤트 이름';
$config['main']['def_event_settings']['columnText']['evt_type']= '이벤트 타입';
$config['main']['def_event_settings']['columnText']['is_forever']='종료 타입';
$config['main']['def_event_settings']['columnText']['dtmain_begin']='이벤트 시작시간 메인';
$config['main']['def_event_settings']['columnText']['dtmain_end']='이벤트 종료시간 메인';
$config['main']['def_event_settings']['columnText']['period_main']='주기 타입 메인';
$config['main']['def_event_settings']['columnText']['period_sub']='주기 타입 서브';
$config['main']['def_event_settings']['columnText']['dtsub_a']='시간 인자 1 (시작시간)';
$config['main']['def_event_settings']['columnText']['dtsub_b']='시간 인자 2 (종료시간)';
$config['main']['def_event_settings']['columnText']['dtsub_c']='시간 인자 3 ';
$config['main']['def_event_settings']['columnText']['join_repeatable']='계정당 반복 참여 여부';
$config['main']['def_event_settings']['columnText']['except_market']='제외 마켓 비트마스크';
$config['main']['def_event_settings']['columnText']['detail_mid']='이벤트 고유 ID';
$config['main']['def_event_settings']['columnText']['store_evt_key']='이벤트 고유 문자열 ( 예시 : 20141019-test )';
$config['main']['def_event_settings']['columnText']['banner_show']='배너 노출';
$config['main']['def_event_settings']['columnText']['banner_first']='썸네일 이미지 URL';
$config['main']['def_event_settings']['columnText']['banner_second']='메인 이미지 URL';
$config['main']['def_event_settings']['columnText']['disabled']='종료 플래그';

$config['main']['def_event_settings']['editColumn']['dtmain_begin']='dtmain_begin';
$config['main']['def_event_settings']['editColumn']['dtmain_end']='dtmain_end';
#$config['main']['def_event_settings']['editColumn']['period_main']='period_main';
#$config['main']['def_event_settings']['editColumn']['period_sub']='period_sub';
$config['main']['def_event_settings']['editColumn']['dtsub_a']='dtsub_a';
$config['main']['def_event_settings']['editColumn']['dtsub_b']='dtsub_b';
#$config['main']['def_event_settings']['editColumn']['dtsub_c']='dtsub_c';
$config['main']['def_event_settings']['editColumn']['banner_show']='banner_show';
$config['main']['def_event_settings']['editColumn']['banner_first']='banner_first';
$config['main']['def_event_settings']['editColumn']['banner_second']='banner_second';
$config['main']['def_event_settings']['editColumn']['disabled']='disabled';

$config['main']['def_event_settings']['whereColumn']['0']='dtmain_begin';
$config['main']['def_event_settings']['whereColumn']['1']='detail_mid';
$config['main']['def_event_settings']['viewType']='table';
$config['main']['def_event_settings']['tableText']='인게임 이벤트 정보';


$config['main']['def_event_detail']['table']='def_event_detail';
$config['main']['def_event_detail']['dsn']='gm_monshot';
$config['main']['def_event_detail']['column']['0']='detail_mid';
$config['main']['def_event_detail']['column']['1']='detail_sid';
$config['main']['def_event_detail']['column']['2']='detail_type';
$config['main']['def_event_detail']['column']['3']='apply_where';
$config['main']['def_event_detail']['column']['4']='where_value';
$config['main']['def_event_detail']['column']['5']='apply_how';
$config['main']['def_event_detail']['column']['6']='how_value';
$config['main']['def_event_detail']['column']['7']='detail_desc';
$config['main']['def_event_detail']['columnText']['detail_mid']='detail_mid';
$config['main']['def_event_detail']['columnText']['detail_sid']='detail_sid';
$config['main']['def_event_detail']['columnText']['detail_type']='detail_type';
$config['main']['def_event_detail']['columnText']['apply_where']='apply_where';
$config['main']['def_event_detail']['columnText']['where_value']='where_value';
$config['main']['def_event_detail']['columnText']['apply_how']='apply_how';
$config['main']['def_event_detail']['columnText']['how_value']='how_value';
$config['main']['def_event_detail']['columnText']['detail_desc']='detail_desc';
$config['main']['def_event_detail']['editColumn']['apply_where']='apply_where';
$config['main']['def_event_detail']['editColumn']['where_value']='where_value';
$config['main']['def_event_detail']['editColumn']['apply_how']='apply_how';
$config['main']['def_event_detail']['editColumn']['how_value']='how_value';
$config['main']['def_event_detail']['editColumn']['detail_desc']='detail_desc';
$config['main']['def_event_detail']['whereColumn']['0']='detail_mid';
$config['main']['def_event_detail']['viewType']='table';
$config['main']['def_event_detail']['tableText']='인게임 이벤트 메타 정보';



$config['event_settings_meta']['evt_type']['column'][1] = "System Check";
$config['event_settings_meta']['evt_type']['column'][2] = "Ranking Adjust";
$config['event_settings_meta']['evt_type']['column'][3] = "In Game";
$config['event_settings_meta']['evt_type']['column'][4] = "In Game PVP";
$config['event_settings_meta']['evt_type']['column'][5] = "In Game Store";

$config['event_settings_meta']['is_forever']['column'][0] = "기간";
$config['event_settings_meta']['is_forever']['column'][1] = "영원히";

$config['event_settings_meta']['join_repeatable']['column'][0] = "NO";
$config['event_settings_meta']['join_repeatable']['column'][1] = "YES";


$config['event_settings_meta']['banner_show']['column'][0] = "NO";
$config['event_settings_meta']['banner_show']['column'][1] = "YES";

$config['event_settings_meta']['period_main']['column'][0] = "주간 요일별";
$config['event_settings_meta']['period_main']['column'][1] = "월간 일별";
$config['event_settings_meta']['period_main']['column'][2] = "연간 월별";
$config['event_settings_meta']['period_main']['column'][3] = "시간대";
$config['event_settings_meta']['period_main']['column'][4] = "지정시간";

$config['event_settings_meta']['period_sub']['column'][0] = "한번만 실행";
$config['event_settings_meta']['period_sub']['column'][1] = "기간 내내 실행";
$config['event_settings_meta']['period_sub']['column'][2] = "지정 시간 동안만 실행";

$config['event_settings_meta']['dtsub_c'][0]['column'][0] = "일요일";
$config['event_settings_meta']['dtsub_c'][0]['column'][1] = "월요일";
$config['event_settings_meta']['dtsub_c'][0]['column'][2] = "화요일";
$config['event_settings_meta']['dtsub_c'][0]['column'][3] = "수요일";
$config['event_settings_meta']['dtsub_c'][0]['column'][4] = "목요일";
$config['event_settings_meta']['dtsub_c'][0]['column'][5] = "금요일";
$config['event_settings_meta']['dtsub_c'][0]['column'][6] = "토요일";

$aTempArr = array();
$config['event_settings_meta']['dtsub_c'][1]['column'] = array_merge($aTempArr, range(0, 31));
$config['event_settings_meta']['dtsub_c'][2]['column'] = array_merge($aTempArr, range(1, 12));

$config['event_settings_meta']['disabled']['column'][0] = "NO";
$config['event_settings_meta']['disabled']['column'][1] = "YES";
