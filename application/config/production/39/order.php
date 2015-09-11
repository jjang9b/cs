<?php
$config['menuName']='주문 등록';
$config['accessLog']=true;

$config['main']['tb_iaptransaction']['table']='tb_iaptransaction';
$config['main']['tb_iaptransaction']['dsn']='gm_monshot';

$config['main']['tb_iaptransaction']['column']['0']='tb_player_id';
$config['main']['tb_iaptransaction']['column']['1']='sessionkey';
$config['main']['tb_iaptransaction']['column']['2']='protocolseq';
$config['main']['tb_iaptransaction']['column']['3']='pltfrm';
$config['main']['tb_iaptransaction']['column']['4']='marketData';
$config['main']['tb_iaptransaction']['column']['5']='marketSig';
$config['main']['tb_iaptransaction']['column']['6']='tran_status';
$config['main']['tb_iaptransaction']['column']['7']='cancelReason';
$config['main']['tb_iaptransaction']['column']['8']='startedAt';
$config['main']['tb_iaptransaction']['column']['9']='addressee';
$config['main']['tb_iaptransaction']['column']['10']='gooddefidx';
$config['main']['tb_iaptransaction']['column']['11']='gooddefcategory';
$config['main']['tb_iaptransaction']['column']['12']='completedAt';
$config['main']['tb_iaptransaction']['column']['13']='kakao';
$config['main']['tb_iaptransaction']['column']['14']='cash';

$config['main']['tb_iaptransaction']['columnText']['tb_player_id']='사용자 식별자';
$config['main']['tb_iaptransaction']['columnText']['sessionkey']='세션 키';
$config['main']['tb_iaptransaction']['columnText']['protocolseq']='프로토콜 순번';
$config['main']['tb_iaptransaction']['columnText']['pltfrm']='플랫폼';
$config['main']['tb_iaptransaction']['columnText']['marketData']='주문 번호(마켓 데이터)';
$config['main']['tb_iaptransaction']['columnText']['marketSig']='마켓 시그내쳐';
$config['main']['tb_iaptransaction']['columnText']['tran_status']='주문 상태';
$config['main']['tb_iaptransaction']['columnText']['cancelReason']='사유';
$config['main']['tb_iaptransaction']['columnText']['startedAt']='결제 시작 시간';
$config['main']['tb_iaptransaction']['columnText']['addressee']='받을 사람 식별자 ( 0 이면 본인 )';
$config['main']['tb_iaptransaction']['columnText']['gooddefidx']='상점 식별자';
$config['main']['tb_iaptransaction']['columnText']['gooddefcategory']='상점 카테고리';
$config['main']['tb_iaptransaction']['columnText']['completedAt']='결제 완료 시간';
$config['main']['tb_iaptransaction']['columnText']['kakao']='kakao';
$config['main']['tb_iaptransaction']['columnText']['cash']='캐시 가격';
$config['main']['tb_iaptransaction']['viewType']='table';
$config['main']['tb_iaptransaction']['whereColumn']['0']='tb_player_id';
$config['main']['tb_iaptransaction']['tableText']='구매 성공 로그';

$config['main']['tb_gift']['table']='tb_gift';
$config['main']['tb_gift']['dsn']='gm_monshot';

$config['order_item_table']['def_storegood']['table']='def_storegood';
$config['order_item_table']['def_storegood']['dsn']='gm_monshot';
$config['order_item_table']['def_storegood']['column']['0']='idx';
$config['order_item_table']['def_storegood']['column']['1']='name';
$config['order_item_table']['def_storegood']['column']['2']='category';
$config['order_item_table']['def_storegood']['column']['3']='rewardType';
$config['order_item_table']['def_storegood']['column']['4']='rewardSubType';
$config['order_item_table']['def_storegood']['column']['5']='rewardIdx';
$config['order_item_table']['def_storegood']['column']['6']='rewardValue';
$config['order_item_table']['def_storegood']['column']['7']='rewardAmount';
$config['order_item_table']['def_storegood']['column']['8']='rewardParam1';
$config['order_item_table']['def_storegood']['column']['9']='rewardParam2';
$config['order_item_table']['def_storegood']['column']['10']='description';
$config['order_item_table']['def_storegood']['column']['11']='iapprice';
