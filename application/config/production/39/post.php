<?php
$config['menuName']='post';
$config['accessLog']=true;

$config['main']['tb_gift']['table']='tb_gift';
$config['main']['tb_gift']['dsn']='gm_monshot';

$config['main']['tb_gift']['procedure']	= 'monshot.USP_Insert_tb_gift_bulk';
$config['main']['tb_gift']['rewardIdx']['procedure']	= 'pubdb.USP_CS_GET_POST_REWARD_KEY';
$config['main']['tb_gift']['rewardIdx']['dsn'] = 'pubdb';
$config['main']['tb_gift']['t_reward']['procedure']	= 'monshot.USP_FTT_REWARD_CREATE';
$config['main']['tb_gift']['t_reward']['dsn'] = 'gm_monshot';

$config['main']['tb_gift']['column']['0']='id';
$config['main']['tb_gift']['column']['1']='tb_player_id';
$config['main']['tb_gift']['column']['2']='sender_id';
$config['main']['tb_gift']['column']['3']='message';
$config['main']['tb_gift']['column']['4']='rewardType';
$config['main']['tb_gift']['column']['5']='rewardSubType';
$config['main']['tb_gift']['column']['6']='rewardIdx';
$config['main']['tb_gift']['column']['7']='rewardValue';
$config['main']['tb_gift']['column']['8']='rewardAmount';
$config['main']['tb_gift']['column']['9']='rewardParam1';
$config['main']['tb_gift']['column']['10']='rewardParam2';
$config['main']['tb_gift']['column']['11']='received';
$config['main']['tb_gift']['column']['12']='createdDt';
$config['main']['tb_gift']['column']['13']='receivedDt';

$config['main']['tb_gift']['columnText']['id']='선물 식별자';
$config['main']['tb_gift']['columnText']['tb_player_id']='받는 사람 식별자';
$config['main']['tb_gift']['columnText']['sender_id']='보내는 사람 식별자';
$config['main']['tb_gift']['columnText']['message']='보내는 메시지';
$config['main']['tb_gift']['columnText']['rewardType']='보상 유형';
$config['main']['tb_gift']['columnText']['rewardSubType']='보상 하위 유형';
$config['main']['tb_gift']['columnText']['rewardIdx']='보상 식별자';
$config['main']['tb_gift']['columnText']['rewardValue']='보상 값';
$config['main']['tb_gift']['columnText']['rewardAmount']='보상 총량';
$config['main']['tb_gift']['columnText']['rewardParam1']='보상 매개변수 1';
$config['main']['tb_gift']['columnText']['rewardParam2']='보상 매개변수 2';
$config['main']['tb_gift']['columnText']['received']='수령 여부 (값을 1로 변경하면 우편이 삭제됩니다)';
$config['main']['tb_gift']['columnText']['createdDt']='생성 일시';
$config['main']['tb_gift']['columnText']['receivedDt']='수령 일시';
$config['main']['tb_gift']['editColumn']['received']='received';

$config['main']['tb_gift']['viewType']='table';
$config['main']['tb_gift']['whereColumn']['0']='tb_player_id';
$config['main']['tb_gift']['whereColumn']['1']='received';
$config['main']['tb_gift']['tableText']='우편함 지급 내역';

$config['main']['pkg_cancel']['dsn']='gm_monshot';
$config['main']['pkg_cancel']['procedure']	= 'monshot.USP_Cancel_MiracleRubi';


### Reward Item 식별 메타 데이터##
$config['postRewardItem']['0']['name'] = '골드';
$config['postRewardItem']['0']['column'][0] = 'pPostRewardAmount';
$config['postRewardItem']['0']['columnText']['pPostRewardAmount'] = '수량';

$config['postRewardItem']['1']['name'] = '루비';
$config['postRewardItem']['1']['column'][0] = 'pPostRewardAmount';
$config['postRewardItem']['1']['columnText']['pPostRewardAmount'] = '수량';

$config['postRewardItem']['2']['name'] = '모험의 날개';
$config['postRewardItem']['2']['column'][0] = 'pPostRewardAmount';
$config['postRewardItem']['2']['columnText']['pPostRewardAmount'] = '수량';

$config['postRewardItem']['3']['name'] = '몬스터';
$config['postRewardItem']['3']['column'][0] = 'pPostRewardIdx';
$config['postRewardItem']['3']['column'][1] = 'pPostRewardValue';
$config['postRewardItem']['3']['column'][2] = 'pPostRewardAmount';
$config['postRewardItem']['3']['column'][3] = 'pPostRewardParam1';
$config['postRewardItem']['3']['columnText']['pPostRewardIdx'] = '몬스터 식별값';
$config['postRewardItem']['3']['columnText']['pPostRewardValue'] = '레벨';
$config['postRewardItem']['3']['columnText']['pPostRewardAmount'] = '경험치';
$config['postRewardItem']['3']['columnText']['pPostRewardParam1'] = '강화등급';

$config['postRewardItem']['4']['name'] = '장비';
$config['postRewardItem']['4']['column'][0] = 'pPostRewardSubType';
$config['postRewardItem']['4']['column'][1] = 'pPostRewardIdx';
$config['postRewardItem']['4']['columnText']['pPostRewardSubType'] = '장비 타입';
$config['postRewardItem']['4']['columnText']['pPostRewardIdx'] = '장비 식별자';

$config['postRewardItem']['6']['name'] = '준비 아이템';
$config['postRewardItem']['6']['column'][0] = 'pPostRewardIdx';
$config['postRewardItem']['6']['column'][1] = 'pPostRewardAmount';
$config['postRewardItem']['6']['columnText']['pPostRewardIdx'] = '준비 아이템 타입';
$config['postRewardItem']['6']['columnText']['pPostRewardAmount'] = '수량';

$config['postRewardItem']['7']['name'] = '명예 포인트';
$config['postRewardItem']['7']['column'][0] = 'pPostRewardAmount';
$config['postRewardItem']['7']['columnText']['pPostRewardAmount'] = '수량';

$config['postRewardItem']['8']['name'] = '뽑기 티켓';
$config['postRewardItem']['8']['column'][0] = 'pPostRewardIdx';
$config['postRewardItem']['8']['column'][1] = 'pPostRewardSubType';
$config['postRewardItem']['8']['column'][2] = 'pPostRewardParam1';
$config['postRewardItem']['8']['column'][3] = 'pPostRewardParam2';
$config['postRewardItem']['8']['columnText']['pPostRewardIdx'] = '뽑기 식별자';
$config['postRewardItem']['8']['columnText']['pPostRewardSubType'] = '뽑기 타입 ( 1 : 몬스터, 2 : 장비 )';
$config['postRewardItem']['8']['columnText']['pPostRewardParam1'] = '뽑기 최하위 등급';
$config['postRewardItem']['8']['columnText']['pPostRewardParam2'] = '뽑기 최상위 등급';

$config['postRewardItem']['9']['name'] = '슈터';
$config['postRewardItem']['9']['column'][0] = 'pPostRewardIdx';
$config['postRewardItem']['9']['columnText']['pPostRewardIdx'] = '슈터 식별자';

$config['postRewardItem']['12']['name'] = '패키지 보상';
$config['postRewardItem']['12']['column'][0] = 'pPostRewardIdx';
$config['postRewardItem']['12']['columnText']['pPostRewardIdx'] = '패키지 식별자';

$config['postRewardItem']['15']['name'] = '플레이어 경험치';
$config['postRewardItem']['15']['column'][0] = 'pPostRewardAmount';
