<?php
$config['menuName']='define';

$config['tab']['def_monster']['table']='def_monster';
$config['tab']['def_monster']['dsn']='gm_monshot';
$config['tab']['def_monster']['column']['0']='def_version_idx';
$config['tab']['def_monster']['column']['1']='idx';
$config['tab']['def_monster']['column']['2']='name';
$config['tab']['def_monster']['column']['3']='grade';
$config['tab']['def_monster']['column']['4']='att';
$config['tab']['def_monster']['column']['5']='hp';
$config['tab']['def_monster']['column']['6']='spd';
$config['tab']['def_monster']['column']['7']='recovery';
$config['tab']['def_monster']['column']['8']='cri';
$config['tab']['def_monster']['column']['9']='attr';
$config['tab']['def_monster']['column']['10']='attr_att';
$config['tab']['def_monster']['column']['11']='attr_def';
$config['tab']['def_monster']['column']['12']='friend_power';
$config['tab']['def_monster']['column']['13']='monstertype';
$config['tab']['def_monster']['column']['14']='magic_power';
$config['tab']['def_monster']['column']['15']='def_buff_idx';
$config['tab']['def_monster']['column']['16']='inc_att';
$config['tab']['def_monster']['column']['17']='inc_hp';
$config['tab']['def_monster']['column']['18']='inc_spd';
$config['tab']['def_monster']['column']['19']='inc_recovery';
$config['tab']['def_monster']['column']['20']='inc_cri';
$config['tab']['def_monster']['column']['21']='inc_friend_power';
$config['tab']['def_monster']['column']['22']='unit_price';
$config['tab']['def_monster']['column']['23']='inc_rateent';
$config['tab']['def_monster']['column']['24']='slotCount';
$config['tab']['def_monster']['column']['25']='costType';
$config['tab']['def_monster']['column']['26']='costSubType';
$config['tab']['def_monster']['column']['27']='costAmount';
$config['tab']['def_monster']['column']['28']='evo_mon';
$config['tab']['def_monster']['column']['29']='prop_match';

$config['tab']['def_monster']['columnText']['def_version_idx']='게임 버전';
$config['tab']['def_monster']['columnText']['idx']='몬스터 식별자';
$config['tab']['def_monster']['columnText']['name']='몬스터 이름';
$config['tab']['def_monster']['columnText']['grade']='등급';
$config['tab']['def_monster']['columnText']['att']='공격력';
$config['tab']['def_monster']['columnText']['hp']='체력';
$config['tab']['def_monster']['columnText']['spd']='속력';
$config['tab']['def_monster']['columnText']['recovery']='회복력';
$config['tab']['def_monster']['columnText']['cri']='치명타';
$config['tab']['def_monster']['columnText']['attr']='속성';
$config['tab']['def_monster']['columnText']['attr_att']='속성 공격력';
$config['tab']['def_monster']['columnText']['attr_def']='속성 방어력';
$config['tab']['def_monster']['columnText']['friend_power']='우정 공격력';
$config['tab']['def_monster']['columnText']['monstertype']='몬스터 유형';
$config['tab']['def_monster']['columnText']['magic_power']='MP';
$config['tab']['def_monster']['columnText']['def_buff_idx']='리더 스킬';
$config['tab']['def_monster']['columnText']['inc_att']='공격력 증가분';
$config['tab']['def_monster']['columnText']['inc_hp']='체력 증가분';
$config['tab']['def_monster']['columnText']['inc_spd']='속력 증가분';
$config['tab']['def_monster']['columnText']['inc_recovery']='회복력 증가분';
$config['tab']['def_monster']['columnText']['inc_cri']='치명타 증가분';
$config['tab']['def_monster']['columnText']['inc_friend_power']='우정 공격력 증가분';
$config['tab']['def_monster']['columnText']['unit_price']='판매 단가';
$config['tab']['def_monster']['columnText']['inc_rateent']='강화 상승률';
$config['tab']['def_monster']['columnText']['slotCount']='장비 슬롯 갯수';
$config['tab']['def_monster']['columnText']['costType']='진화 비용 구분';
$config['tab']['def_monster']['columnText']['costSubType']='진화 비용 하위 구분';
$config['tab']['def_monster']['columnText']['costAmount']='진화 비용 총액';
$config['tab']['def_monster']['columnText']['evo_mon']='진화 결과 몬스터';
$config['tab']['def_monster']['columnText']['prop_match']='강화 속성 일치 추가 경험치';
$config['tab']['def_monster']['viewType']='table';
$config['tab']['def_monster']['tableText']='몬스터 정보';


$config['tab']['def_attendancecontinuereward']['table']='def_attendancecontinuereward';
$config['tab']['def_attendancecontinuereward']['dsn']='gm_monshot';
$config['tab']['def_attendancecontinuereward']['column']['0']='def_version_idx';
$config['tab']['def_attendancecontinuereward']['column']['1']='idx';
$config['tab']['def_attendancecontinuereward']['column']['2']='atcount';
$config['tab']['def_attendancecontinuereward']['column']['3']='rewardType';
$config['tab']['def_attendancecontinuereward']['column']['4']='rewardSubType';
$config['tab']['def_attendancecontinuereward']['column']['5']='rewardIdx';
$config['tab']['def_attendancecontinuereward']['column']['6']='rewardValue';
$config['tab']['def_attendancecontinuereward']['column']['7']='rewardAmount';
$config['tab']['def_attendancecontinuereward']['column']['8']='rewardParam1';
$config['tab']['def_attendancecontinuereward']['column']['9']='rewardParam2';
$config['tab']['def_attendancecontinuereward']['columnText']['def_version_idx']='게임 버전';
$config['tab']['def_attendancecontinuereward']['columnText']['idx']='식별자';
$config['tab']['def_attendancecontinuereward']['columnText']['atcount']='지급 대상 연속 출석 일수';
$config['tab']['def_attendancecontinuereward']['columnText']['rewardType']='보상 유형';
$config['tab']['def_attendancecontinuereward']['columnText']['rewardSubType']='보상 하위 유형';
$config['tab']['def_attendancecontinuereward']['columnText']['rewardIdx']='보상 식별자';
$config['tab']['def_attendancecontinuereward']['columnText']['rewardValue']='보상 값';
$config['tab']['def_attendancecontinuereward']['columnText']['rewardAmount']='보상 총량';
$config['tab']['def_attendancecontinuereward']['columnText']['rewardParam1']='보상 매개변수 1';
$config['tab']['def_attendancecontinuereward']['columnText']['rewardParam2']='보상 매개변수 2';
$config['tab']['def_attendancecontinuereward']['viewType']='table';
$config['tab']['def_attendancecontinuereward']['tableText']='연속 출석 보상 정보';
$config['tab']['def_attendancereward']['table']='def_attendancereward';
$config['tab']['def_attendancereward']['dsn']='gm_monshot';
$config['tab']['def_attendancereward']['column']['0']='def_version_idx';
$config['tab']['def_attendancereward']['column']['1']='idx';
$config['tab']['def_attendancereward']['column']['2']='rewardType';
$config['tab']['def_attendancereward']['column']['3']='rewardSubType';
$config['tab']['def_attendancereward']['column']['4']='rewardIdx';
$config['tab']['def_attendancereward']['column']['5']='rewardValue';
$config['tab']['def_attendancereward']['column']['6']='rewardAmount';
$config['tab']['def_attendancereward']['column']['7']='rewardParam1';
$config['tab']['def_attendancereward']['column']['8']='rewardParam2';
$config['tab']['def_attendancereward']['column']['9']='ratio_1';
$config['tab']['def_attendancereward']['column']['10']='ratio_2';
$config['tab']['def_attendancereward']['column']['11']='ratio_3';
$config['tab']['def_attendancereward']['column']['12']='reveal_ratio';
$config['tab']['def_attendancereward']['columnText']['def_version_idx']='게임 버전';
$config['tab']['def_attendancereward']['columnText']['idx']='식별자';
$config['tab']['def_attendancereward']['columnText']['rewardType']='보상 유형';
$config['tab']['def_attendancereward']['columnText']['rewardSubType']='보상 하위 유형';
$config['tab']['def_attendancereward']['columnText']['rewardIdx']='보상 식별자';
$config['tab']['def_attendancereward']['columnText']['rewardValue']='보상 값';
$config['tab']['def_attendancereward']['columnText']['rewardAmount']='보상 총량';
$config['tab']['def_attendancereward']['columnText']['rewardParam1']='보상 매개변수 1';
$config['tab']['def_attendancereward']['columnText']['rewardParam2']='보상 매개변수 2';
$config['tab']['def_attendancereward']['columnText']['ratio_1']='1일 출석 확률';
$config['tab']['def_attendancereward']['columnText']['ratio_2']='2일 출석 확률';
$config['tab']['def_attendancereward']['columnText']['ratio_3']='3일 출석 확률';
$config['tab']['def_attendancereward']['columnText']['reveal_ratio']='미끼 확률';
$config['tab']['def_attendancereward']['viewType']='table';
$config['tab']['def_attendancereward']['tableText']='출석 보상 설정 정보';
$config['tab']['def_buff']['table']='def_buff';
$config['tab']['def_buff']['dsn']='gm_monshot';
$config['tab']['def_buff']['column']['0']='def_version_idx';
$config['tab']['def_buff']['column']['1']='idx';
$config['tab']['def_buff']['column']['2']='bufftype';
$config['tab']['def_buff']['column']['3']='bufftarget';
$config['tab']['def_buff']['column']['4']='buffvalue';
$config['tab']['def_buff']['columnText']['def_version_idx']='게임 버전';
$config['tab']['def_buff']['columnText']['idx']='버프 식별자';
$config['tab']['def_buff']['columnText']['bufftype']='버프 유형';
$config['tab']['def_buff']['columnText']['bufftarget']='버프 대상';
$config['tab']['def_buff']['columnText']['buffvalue']='버프 값';
$config['tab']['def_buff']['viewType']='table';
$config['tab']['def_buff']['tableText']='버프 정보';
$config['tab']['def_chapter']['table']='def_chapter';
$config['tab']['def_chapter']['dsn']='gm_monshot';
$config['tab']['def_chapter']['column']['0']='def_version_idx';
$config['tab']['def_chapter']['column']['1']='idx';
$config['tab']['def_chapter']['column']['2']='name';
$config['tab']['def_chapter']['column']['3']='introVersion';
$config['tab']['def_chapter']['columnText']['def_version_idx']='게임 버전';
$config['tab']['def_chapter']['columnText']['idx']='챕터 식별자';
$config['tab']['def_chapter']['columnText']['name']='챕터 명칭';
$config['tab']['def_chapter']['columnText']['introVersion']='진입 게임 설정 정보';
$config['tab']['def_chapter']['viewType']='table';
$config['tab']['def_chapter']['tableText']='챕터 정보';
$config['tab']['def_chapter_event']['table']='def_chapter_event';
$config['tab']['def_chapter_event']['dsn']='gm_monshot';
$config['tab']['def_chapter_event']['column']['0']='def_version_idx';
$config['tab']['def_chapter_event']['column']['1']='rev_chapter';
$config['tab']['def_chapter_event']['column']['2']='idx';
$config['tab']['def_chapter_event']['column']['3']='name';
$config['tab']['def_chapter_event']['column']['4']='startdate';
$config['tab']['def_chapter_event']['column']['5']='enddate';
$config['tab']['def_chapter_event']['column']['6']='imageurl';
$config['tab']['def_chapter_event']['column']['7']='clear_sequential';
$config['tab']['def_chapter_event']['column']['8']='pattern_type';
$config['tab']['def_chapter_event']['column']['9']='pattern_value';
$config['tab']['def_chapter_event']['column']['10']='pattern_starttime';
$config['tab']['def_chapter_event']['column']['11']='pattern_endtime';
$config['tab']['def_chapter_event']['column']['12']='attribute';
$config['tab']['def_chapter_event']['column']['13']='client_data';
$config['tab']['def_chapter_event']['columnText']['def_version_idx']='게임 버전';
$config['tab']['def_chapter_event']['columnText']['rev_chapter']='챕터 버전 정보';
$config['tab']['def_chapter_event']['columnText']['idx']='챕터 식별자';
$config['tab']['def_chapter_event']['columnText']['name']='챕터 명칭';
$config['tab']['def_chapter_event']['columnText']['startdate']='이벤트 시작 일자';
$config['tab']['def_chapter_event']['columnText']['enddate']='이벤트 종료 일자';
$config['tab']['def_chapter_event']['columnText']['imageurl']='타이틀 이미지 URL';
$config['tab']['def_chapter_event']['columnText']['clear_sequential']='연속 클리어 여부';
$config['tab']['def_chapter_event']['columnText']['pattern_type']='노출 타입';
$config['tab']['def_chapter_event']['columnText']['pattern_value']='노출 방식';
$config['tab']['def_chapter_event']['columnText']['pattern_starttime']='노출 시작 시각';
$config['tab']['def_chapter_event']['columnText']['pattern_endtime']='노출 종료 시각';
$config['tab']['def_chapter_event']['columnText']['attribute']='챕터 속성';
$config['tab']['def_chapter_event']['columnText']['client_data']='클라이언트 전용 데이터';
$config['tab']['def_chapter_event']['viewType']='table';
$config['tab']['def_chapter_event']['tableText']='이벤트 챕터 정보';
$config['tab']['def_chapter_event_reward']['table']='def_chapter_event_reward';
$config['tab']['def_chapter_event_reward']['dsn']='gm_monshot';
$config['tab']['def_chapter_event_reward']['column']['0']='def_version_idx';
$config['tab']['def_chapter_event_reward']['column']['1']='def_chapter_event_rev_chapter';
$config['tab']['def_chapter_event_reward']['column']['2']='def_chapter_event_idx';
$config['tab']['def_chapter_event_reward']['column']['3']='idx';
$config['tab']['def_chapter_event_reward']['column']['4']='clear_point';
$config['tab']['def_chapter_event_reward']['column']['5']='rewardType';
$config['tab']['def_chapter_event_reward']['column']['6']='rewardSubType';
$config['tab']['def_chapter_event_reward']['column']['7']='rewardIdx';
$config['tab']['def_chapter_event_reward']['column']['8']='rewardValue';
$config['tab']['def_chapter_event_reward']['column']['9']='rewardAmount';
$config['tab']['def_chapter_event_reward']['column']['10']='rewardParam1';
$config['tab']['def_chapter_event_reward']['column']['11']='rewardParam2';
$config['tab']['def_chapter_event_reward']['columnText']['def_version_idx']='게임 버전';
$config['tab']['def_chapter_event_reward']['columnText']['def_chapter_event_rev_chapter']='챕터 버전 정보';
$config['tab']['def_chapter_event_reward']['columnText']['def_chapter_event_idx']='챕터 식별자';
$config['tab']['def_chapter_event_reward']['columnText']['idx']='챕터 명칭';
$config['tab']['def_chapter_event_reward']['columnText']['clear_point']='보상 대상 트로피';
$config['tab']['def_chapter_event_reward']['columnText']['rewardType']='보상 유형';
$config['tab']['def_chapter_event_reward']['columnText']['rewardSubType']='보상 하위 유형';
$config['tab']['def_chapter_event_reward']['columnText']['rewardIdx']='보상 식별자';
$config['tab']['def_chapter_event_reward']['columnText']['rewardValue']='보상 값';
$config['tab']['def_chapter_event_reward']['columnText']['rewardAmount']='보상 총량';
$config['tab']['def_chapter_event_reward']['columnText']['rewardParam1']='보상 매개변수 1';
$config['tab']['def_chapter_event_reward']['columnText']['rewardParam2']='보상 매개변수 2';
$config['tab']['def_chapter_event_reward']['viewType']='table';
$config['tab']['def_chapter_event_reward']['tableText']='이벤트 챕터 보상 정보';
$config['tab']['def_chapter_reward']['table']='def_chapter_reward';
$config['tab']['def_chapter_reward']['dsn']='gm_monshot';
$config['tab']['def_chapter_reward']['column']['0']='def_chapter_def_version_idx';
$config['tab']['def_chapter_reward']['column']['1']='def_chapter_idx';
$config['tab']['def_chapter_reward']['column']['2']='idx';
$config['tab']['def_chapter_reward']['column']['3']='clear_point';
$config['tab']['def_chapter_reward']['column']['4']='rewardType';
$config['tab']['def_chapter_reward']['column']['5']='rewardSubType';
$config['tab']['def_chapter_reward']['column']['6']='rewardIdx';
$config['tab']['def_chapter_reward']['column']['7']='rewardValue';
$config['tab']['def_chapter_reward']['column']['8']='rewardAmount';
$config['tab']['def_chapter_reward']['column']['9']='rewardParam1';
$config['tab']['def_chapter_reward']['column']['10']='rewardParam2';
$config['tab']['def_chapter_reward']['columnText']['def_chapter_def_version_idx']='게임 버전';
$config['tab']['def_chapter_reward']['columnText']['def_chapter_idx']='챕터 식별자';
$config['tab']['def_chapter_reward']['columnText']['idx']='챕터 명칭';
$config['tab']['def_chapter_reward']['columnText']['clear_point']='보상 대상 트로피';
$config['tab']['def_chapter_reward']['columnText']['rewardType']='보상 유형';
$config['tab']['def_chapter_reward']['columnText']['rewardSubType']='보상 하위 유형';
$config['tab']['def_chapter_reward']['columnText']['rewardIdx']='보상 식별자';
$config['tab']['def_chapter_reward']['columnText']['rewardValue']='보상 값';
$config['tab']['def_chapter_reward']['columnText']['rewardAmount']='보상 총량';
$config['tab']['def_chapter_reward']['columnText']['rewardParam1']='보상 매개변수 1';
$config['tab']['def_chapter_reward']['columnText']['rewardParam2']='보상 매개변수 2';
$config['tab']['def_chapter_reward']['viewType']='table';
$config['tab']['def_chapter_reward']['tableText']='챕터 보상 정보';
$config['tab']['def_configconstants']['table']='def_configconstants';
$config['tab']['def_configconstants']['dsn']='gm_monshot';
$config['tab']['def_configconstants']['column']['0']='def_version_idx';
$config['tab']['def_configconstants']['column']['1']='idx';
$config['tab']['def_configconstants']['column']['2']='value1';
$config['tab']['def_configconstants']['columnText']['def_version_idx']='게임 버전';
$config['tab']['def_configconstants']['columnText']['idx']='상수 식별자';
$config['tab']['def_configconstants']['columnText']['value1']='상수 값';
$config['tab']['def_configconstants']['viewType']='table';
$config['tab']['def_configconstants']['tableText']='게임 상수 정보';
$config['tab']['def_consumable']['table']='def_consumable';
$config['tab']['def_consumable']['dsn']='gm_monshot';
$config['tab']['def_consumable']['column']['0']='def_version_idx';
$config['tab']['def_consumable']['column']['1']='idx';
$config['tab']['def_consumable']['column']['2']='itemType';
$config['tab']['def_consumable']['column']['3']='att';
$config['tab']['def_consumable']['column']['4']='hp';
$config['tab']['def_consumable']['column']['5']='spd';
$config['tab']['def_consumable']['column']['6']='cri';
$config['tab']['def_consumable']['column']['7']='recovery';
$config['tab']['def_consumable']['column']['8']='friend_power';
$config['tab']['def_consumable']['column']['9']='attr_att';
$config['tab']['def_consumable']['column']['10']='attr_def';
$config['tab']['def_consumable']['column']['11']='magic_power';
$config['tab']['def_consumable']['column']['12']='name';
$config['tab']['def_consumable']['columnText']['def_version_idx']='게임 버전';
$config['tab']['def_consumable']['columnText']['idx']='장비 식별자';
$config['tab']['def_consumable']['columnText']['itemType']='아이템 유형';
$config['tab']['def_consumable']['columnText']['att']='공격력';
$config['tab']['def_consumable']['columnText']['hp']='체력';
$config['tab']['def_consumable']['columnText']['spd']='속력';
$config['tab']['def_consumable']['columnText']['cri']='치명타';
$config['tab']['def_consumable']['columnText']['recovery']='회복';
$config['tab']['def_consumable']['columnText']['friend_power']='우정 공격력';
$config['tab']['def_consumable']['columnText']['attr_att']='속성 공격력';
$config['tab']['def_consumable']['columnText']['attr_def']='속성 방어력';
$config['tab']['def_consumable']['columnText']['magic_power']='MP';
$config['tab']['def_consumable']['columnText']['name']='아이템 이름';
$config['tab']['def_consumable']['viewType']='table';
$config['tab']['def_consumable']['tableText']='소모 아이템 정보';
$config['tab']['def_consumable_price']['table']='def_consumable_price';
$config['tab']['def_consumable_price']['dsn']='gm_monshot';
$config['tab']['def_consumable_price']['column']['0']='def_version_idx';
$config['tab']['def_consumable_price']['column']['1']='idx';
$config['tab']['def_consumable_price']['column']['2']='pricelotto';
$config['tab']['def_consumable_price']['column']['3']='price0';
$config['tab']['def_consumable_price']['column']['4']='price1';
$config['tab']['def_consumable_price']['column']['5']='price2';
$config['tab']['def_consumable_price']['column']['6']='price3';
$config['tab']['def_consumable_price']['column']['7']='price4';
$config['tab']['def_consumable_price']['column']['8']='price5';
$config['tab']['def_consumable_price']['column']['9']='price6';
$config['tab']['def_consumable_price']['column']['10']='price7';
$config['tab']['def_consumable_price']['column']['11']='price8';
$config['tab']['def_consumable_price']['columnText']['def_version_idx']='게임 버전';
$config['tab']['def_consumable_price']['columnText']['idx']='식별자 - 참고 레벨';
$config['tab']['def_consumable_price']['columnText']['pricelotto']='싱글 챕터 준비아이템 뽑기 가격';
$config['tab']['def_consumable_price']['columnText']['price0']='싱글 챕터 준비아이템 가격';
$config['tab']['def_consumable_price']['columnText']['price1']='싱글 챕터 준비아이템 가격';
$config['tab']['def_consumable_price']['columnText']['price2']='싱글 챕터 준비아이템 가격';
$config['tab']['def_consumable_price']['columnText']['price3']='싱글 챕터 준비아이템 가격';
$config['tab']['def_consumable_price']['columnText']['price4']='싱글 챕터 준비아이템 가격';
$config['tab']['def_consumable_price']['columnText']['price5']='싱글 챕터 준비아이템 가격';
$config['tab']['def_consumable_price']['columnText']['price6']='싱글 챕터 준비아이템 가격';
$config['tab']['def_consumable_price']['columnText']['price7']='싱글 챕터 준비아이템 가격';
$config['tab']['def_consumable_price']['columnText']['price8']='싱글 챕터 준비아이템 가격';
$config['tab']['def_consumable_price']['viewType']='table';
$config['tab']['def_consumable_price']['tableText']='소모 아이템 가격 정보';
$config['tab']['def_equipment']['table']='def_equipment';
$config['tab']['def_equipment']['dsn']='gm_monshot';
$config['tab']['def_equipment']['column']['0']='def_version_idx';
$config['tab']['def_equipment']['column']['1']='idx';
$config['tab']['def_equipment']['column']['2']='item_type';
$config['tab']['def_equipment']['column']['3']='grade';
$config['tab']['def_equipment']['column']['4']='att';
$config['tab']['def_equipment']['column']['5']='hp';
$config['tab']['def_equipment']['column']['6']='spd';
$config['tab']['def_equipment']['column']['7']='cri';
$config['tab']['def_equipment']['column']['8']='recovery';
$config['tab']['def_equipment']['column']['9']='friend_power';
$config['tab']['def_equipment']['column']['10']='attr_att';
$config['tab']['def_equipment']['column']['11']='attr_def';
$config['tab']['def_equipment']['column']['12']='magic_power';
$config['tab']['def_equipment']['column']['13']='name';
$config['tab']['def_equipment']['column']['14']='unit_price';
$config['tab']['def_equipment']['columnText']['def_version_idx']='게임 버전';
$config['tab']['def_equipment']['columnText']['idx']='장비 식별자';
$config['tab']['def_equipment']['columnText']['item_type']='아이템 유형';
$config['tab']['def_equipment']['columnText']['grade']='등급';
$config['tab']['def_equipment']['columnText']['att']='공격력';
$config['tab']['def_equipment']['columnText']['hp']='체력';
$config['tab']['def_equipment']['columnText']['spd']='속력';
$config['tab']['def_equipment']['columnText']['cri']='치명타';
$config['tab']['def_equipment']['columnText']['recovery']='회복';
$config['tab']['def_equipment']['columnText']['friend_power']='우정 공격력';
$config['tab']['def_equipment']['columnText']['attr_att']='속성 공격력';
$config['tab']['def_equipment']['columnText']['attr_def']='속성 방어력';
$config['tab']['def_equipment']['columnText']['magic_power']='MP';
$config['tab']['def_equipment']['columnText']['name']='아이템 이름';
$config['tab']['def_equipment']['columnText']['unit_price']='판매 단가';
$config['tab']['def_equipment']['viewType']='table';
$config['tab']['def_equipment']['tableText']='장비 정보';
$config['tab']['def_invitation']['table']='def_invitation';
$config['tab']['def_invitation']['dsn']='gm_monshot';
$config['tab']['def_invitation']['column']['0']='def_version_idx';
$config['tab']['def_invitation']['column']['1']='idx';
$config['tab']['def_invitation']['column']['2']='invitation_count';
$config['tab']['def_invitation']['column']['3']='rewardType';
$config['tab']['def_invitation']['column']['4']='rewardSubType';
$config['tab']['def_invitation']['column']['5']='rewardIdx';
$config['tab']['def_invitation']['column']['6']='rewardValue';
$config['tab']['def_invitation']['column']['7']='rewardAmount';
$config['tab']['def_invitation']['column']['8']='rewardParam1';
$config['tab']['def_invitation']['column']['9']='rewardParam2';
$config['tab']['def_invitation']['columnText']['def_version_idx']='게임 버전';
$config['tab']['def_invitation']['columnText']['idx']='식별자';
$config['tab']['def_invitation']['columnText']['invitation_count']='보상 대상 초대 인원';
$config['tab']['def_invitation']['columnText']['rewardType']='보상 유형';
$config['tab']['def_invitation']['columnText']['rewardSubType']='보상 하위 유형';
$config['tab']['def_invitation']['columnText']['rewardIdx']='보상 식별자';
$config['tab']['def_invitation']['columnText']['rewardValue']='보상 값';
$config['tab']['def_invitation']['columnText']['rewardAmount']='보상 총량';
$config['tab']['def_invitation']['columnText']['rewardParam1']='보상 매개변수 1';
$config['tab']['def_invitation']['columnText']['rewardParam2']='보상 매개변수 2';
$config['tab']['def_invitation']['viewType']='table';
$config['tab']['def_invitation']['tableText']='소셜 초대 보상 정보';
$config['tab']['def_launcher']['table']='def_launcher';
$config['tab']['def_launcher']['dsn']='gm_monshot';
$config['tab']['def_launcher']['column']['0']='def_version_idx';
$config['tab']['def_launcher']['column']['1']='idx';
$config['tab']['def_launcher']['column']['2']='name';
$config['tab']['def_launcher']['column']['3']='costType';
$config['tab']['def_launcher']['column']['4']='costSubType';
$config['tab']['def_launcher']['column']['5']='costAmount';
$config['tab']['def_launcher']['columnText']['def_version_idx']='게임 버전';
$config['tab']['def_launcher']['columnText']['idx']='슈터 식별자';
$config['tab']['def_launcher']['columnText']['name']='슈터 명칭';
$config['tab']['def_launcher']['columnText']['costType']='비용 구분';
$config['tab']['def_launcher']['columnText']['costSubType']='비용 하위 구분';
$config['tab']['def_launcher']['columnText']['costAmount']='비용 총액';
$config['tab']['def_launcher']['viewType']='table';
$config['tab']['def_launcher']['tableText']='슈터 정보';
$config['tab']['def_launcher_level']['table']='def_launcher_level';
$config['tab']['def_launcher_level']['dsn']='gm_monshot';
$config['tab']['def_launcher_level']['column']['0']='def_launcher_def_version_idx';
$config['tab']['def_launcher_level']['column']['1']='def_launcher_idx';
$config['tab']['def_launcher_level']['column']['2']='idx';
$config['tab']['def_launcher_level']['column']['3']='buff_att';
$config['tab']['def_launcher_level']['column']['4']='buff_hp';
$config['tab']['def_launcher_level']['column']['5']='buff_spd';
$config['tab']['def_launcher_level']['column']['6']='buff_cri';
$config['tab']['def_launcher_level']['column']['7']='buff_recovery';
$config['tab']['def_launcher_level']['column']['8']='buff_friend_power';
$config['tab']['def_launcher_level']['column']['9']='buff_attr_att';
$config['tab']['def_launcher_level']['column']['10']='buff_attr_def';
$config['tab']['def_launcher_level']['column']['11']='buff_magic_power';
$config['tab']['def_launcher_level']['column']['12']='def_buff_idx';
$config['tab']['def_launcher_level']['column']['13']='costType';
$config['tab']['def_launcher_level']['column']['14']='costSubType';
$config['tab']['def_launcher_level']['column']['15']='costAmount';
$config['tab']['def_launcher_level']['columnText']['def_launcher_def_version_idx']='게임 버전';
$config['tab']['def_launcher_level']['columnText']['def_launcher_idx']='슈터 식별자';
$config['tab']['def_launcher_level']['columnText']['idx']='강화 등급';
$config['tab']['def_launcher_level']['columnText']['buff_att']='공격력';
$config['tab']['def_launcher_level']['columnText']['buff_hp']='체력';
$config['tab']['def_launcher_level']['columnText']['buff_spd']='속력';
$config['tab']['def_launcher_level']['columnText']['buff_cri']='치명타';
$config['tab']['def_launcher_level']['columnText']['buff_recovery']='회복력';
$config['tab']['def_launcher_level']['columnText']['buff_friend_power']='우정 공격력';
$config['tab']['def_launcher_level']['columnText']['buff_attr_att']='속성 공격력';
$config['tab']['def_launcher_level']['columnText']['buff_attr_def']='속성 방어력';
$config['tab']['def_launcher_level']['columnText']['buff_magic_power']='MP';
$config['tab']['def_launcher_level']['columnText']['def_buff_idx']='버프 식별자';
$config['tab']['def_launcher_level']['columnText']['costType']='비용 유형';
$config['tab']['def_launcher_level']['columnText']['costSubType']='비용 하위 유형';
$config['tab']['def_launcher_level']['columnText']['costAmount']='비용 총액';
$config['tab']['def_launcher_level']['viewType']='table';
$config['tab']['def_launcher_level']['tableText']='슈터 강화 테이블';
$config['tab']['def_lotto']['table']='def_lotto';
$config['tab']['def_lotto']['dsn']='gm_monshot';
$config['tab']['def_lotto']['column']['0']='def_version_idx';
$config['tab']['def_lotto']['column']['1']='idx';
$config['tab']['def_lotto']['column']['2']='lottoidx';
$config['tab']['def_lotto']['column']['3']='baselottoidx';
$config['tab']['def_lotto']['column']['4']='score';
$config['tab']['def_lotto']['columnText']['def_version_idx']='게임 버전';
$config['tab']['def_lotto']['columnText']['idx']='식별자';
$config['tab']['def_lotto']['columnText']['lottoidx']='뽑기 식별자';
$config['tab']['def_lotto']['columnText']['baselottoidx']='기준 뽑기 식별자';
$config['tab']['def_lotto']['columnText']['score']='적용 대박 스코어';
$config['tab']['def_lotto']['viewType']='table';
$config['tab']['def_lotto']['tableText']='뽑기 대박 스코어 적용 정보';
$config['tab']['def_lotto_reward']['table']='def_lotto_reward';
$config['tab']['def_lotto_reward']['dsn']='gm_monshot';
$config['tab']['def_lotto_reward']['column']['0']='def_lotto_sub_def_version_idx';
$config['tab']['def_lotto_reward']['column']['1']='def_lotto_sub_idx';
$config['tab']['def_lotto_reward']['column']['2']='idx';
$config['tab']['def_lotto_reward']['column']['3']='ratio';
$config['tab']['def_lotto_reward']['column']['4']='rewardType';
$config['tab']['def_lotto_reward']['column']['5']='rewardSubType';
$config['tab']['def_lotto_reward']['column']['6']='rewardIdx';
$config['tab']['def_lotto_reward']['column']['7']='rewardValue';
$config['tab']['def_lotto_reward']['column']['8']='rewardAmount';
$config['tab']['def_lotto_reward']['column']['9']='rewardParam1';
$config['tab']['def_lotto_reward']['column']['10']='rewardParam2';
$config['tab']['def_lotto_reward']['columnText']['def_lotto_sub_def_version_idx']='뽑기 식별자';
$config['tab']['def_lotto_reward']['columnText']['def_lotto_sub_idx']='뽑기 하위 식별자';
$config['tab']['def_lotto_reward']['columnText']['idx']='뽑기 당첨 보상 식별자';
$config['tab']['def_lotto_reward']['columnText']['ratio']='보상 당첨 확률';
$config['tab']['def_lotto_reward']['columnText']['rewardType']='보상 유형';
$config['tab']['def_lotto_reward']['columnText']['rewardSubType']='보상 하위 유형';
$config['tab']['def_lotto_reward']['columnText']['rewardIdx']='보상 식별자';
$config['tab']['def_lotto_reward']['columnText']['rewardValue']='보상 값';
$config['tab']['def_lotto_reward']['columnText']['rewardAmount']='보상 총량';
$config['tab']['def_lotto_reward']['columnText']['rewardParam1']='보상 매개변수 1';
$config['tab']['def_lotto_reward']['columnText']['rewardParam2']='보상 매개변수 2';
$config['tab']['def_lotto_reward']['viewType']='table';
$config['tab']['def_lotto_reward']['tableText']='뽑기 당첨 보상 정보';
$config['tab']['def_lotto_serial']['table']='def_lotto_serial';
$config['tab']['def_lotto_serial']['dsn']='gm_monshot';
$config['tab']['def_lotto_serial']['column']['0']='def_version_idx';
$config['tab']['def_lotto_serial']['column']['1']='idx';
$config['tab']['def_lotto_serial']['column']['2']='lottoidx';
$config['tab']['def_lotto_serial']['column']['3']='baselottoidx';
$config['tab']['def_lotto_serial']['column']['4']='count';
$config['tab']['def_lotto_serial']['columnText']['def_version_idx']='게임 버전';
$config['tab']['def_lotto_serial']['columnText']['idx']='식별자';
$config['tab']['def_lotto_serial']['columnText']['lottoidx']='뽑기 식별자';
$config['tab']['def_lotto_serial']['columnText']['baselottoidx']='기준 뽑기 식별자';
$config['tab']['def_lotto_serial']['columnText']['count']='적용 횟수';
$config['tab']['def_lotto_serial']['viewType']='table';
$config['tab']['def_lotto_serial']['tableText']='연속 뽑기 정보';
$config['tab']['def_lotto_sub']['table']='def_lotto_sub';
$config['tab']['def_lotto_sub']['dsn']='gm_monshot';
$config['tab']['def_lotto_sub']['column']['0']='def_version_idx';
$config['tab']['def_lotto_sub']['column']['1']='idx';
$config['tab']['def_lotto_sub']['column']['2']='lottoidx';
$config['tab']['def_lotto_sub']['column']['3']='inrushlimitType';
$config['tab']['def_lotto_sub']['column']['4']='inrushlimitInterval';
$config['tab']['def_lotto_sub']['column']['5']='inrushlimitAmount';
$config['tab']['def_lotto_sub']['column']['6']='ratio';
$config['tab']['def_lotto_sub']['column']['7']='score_disp';
$config['tab']['def_lotto_sub']['column']['8']='score_reset';
$config['tab']['def_lotto_sub']['columnText']['def_version_idx']='게임 버전';
$config['tab']['def_lotto_sub']['columnText']['idx']='뽑기 하위 식별자';
$config['tab']['def_lotto_sub']['columnText']['lottoidx']='뽑기 식별자';
$config['tab']['def_lotto_sub']['columnText']['inrushlimitType']='유입 제한 유형';
$config['tab']['def_lotto_sub']['columnText']['inrushlimitInterval']='유입 제한 시간';
$config['tab']['def_lotto_sub']['columnText']['inrushlimitAmount']='유입 제한 총량';
$config['tab']['def_lotto_sub']['columnText']['ratio']='확률';
$config['tab']['def_lotto_sub']['columnText']['score_disp']='대박 스코어 변화량';
$config['tab']['def_lotto_sub']['columnText']['score_reset']='대박 스코어 리셋';
$config['tab']['def_lotto_sub']['viewType']='table';
$config['tab']['def_lotto_sub']['tableText']='뽑기 하위 정보';
