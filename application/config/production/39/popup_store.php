<?php
$config['menuName']='def_storegood';
$config['accessLog']=true;
$config['api']='http://ms-cs-api.fttinc.kr:19995/GM.asmx/ReloadStore';

$config['main']['def_storegood']['table']='def_storegood';
$config['main']['def_storegood']['dsn']='gm_monshot';
$config['main']['def_storegood']['column']['0']='def_version_idx';
$config['main']['def_storegood']['column']['1']='rev_store';
$config['main']['def_storegood']['column']['2']='category';
$config['main']['def_storegood']['column']['3']='idx';
$config['main']['def_storegood']['column']['4']='name';
$config['main']['def_storegood']['column']['5']='description';
$config['main']['def_storegood']['column']['6']='forsale';
$config['main']['def_storegood']['column']['7']='costType1';
$config['main']['def_storegood']['column']['8']='costSubType1';
$config['main']['def_storegood']['column']['9']='costAmount1';
$config['main']['def_storegood']['column']['10']='discount';
$config['main']['def_storegood']['column']['11']='costType2';
$config['main']['def_storegood']['column']['12']='costSubType2';
$config['main']['def_storegood']['column']['13']='costAmount2';
$config['main']['def_storegood']['column']['14']='additionalDiscount';
$config['main']['def_storegood']['column']['15']='eventType';
$config['main']['def_storegood']['column']['16']='eventAmount';
$config['main']['def_storegood']['column']['17']='dailyPurchaseLimit';
$config['main']['def_storegood']['column']['18']='iapprice';

$config['main']['def_storegood']['columnText']['def_version_idx']='게임 버전';
$config['main']['def_storegood']['columnText']['rev_store']='상점 버전';
$config['main']['def_storegood']['columnText']['category']='카테고리';
$config['main']['def_storegood']['columnText']['idx']='식별자';
$config['main']['def_storegood']['columnText']['name']='상품명';
$config['main']['def_storegood']['columnText']['description']='상품 설명';
$config['main']['def_storegood']['columnText']['forsale']='판매 여부';
$config['main']['def_storegood']['columnText']['costType1']='구매 비용 유형';
$config['main']['def_storegood']['columnText']['costSubType1']='구매 비용 하위 유형';
$config['main']['def_storegood']['columnText']['costAmount1']='구매 비용 총액';
$config['main']['def_storegood']['columnText']['discount']='할인 여부';
$config['main']['def_storegood']['columnText']['costType2']='할인 비용 유형';
$config['main']['def_storegood']['columnText']['costSubType2']='할인 비용 하위 유형';
$config['main']['def_storegood']['columnText']['costAmount2']='할인 비용 총액';
$config['main']['def_storegood']['columnText']['additionalDiscount']='추가 구매 할인 여부';
$config['main']['def_storegood']['columnText']['eventType']='추가 구매 할인 비용 유형';
$config['main']['def_storegood']['columnText']['eventAmount']='추가 구매 할인 비용 총액';
$config['main']['def_storegood']['columnText']['dailyPurchaseLimit']='일일 구매 제한';
$config['main']['def_storegood']['columnText']['iapprice']='가격';

$config['main']['def_storegood']['editColumn']['forsale']='forsale';
$config['main']['def_storegood']['viewType']='table';
$config['main']['def_storegood']['tableText']='팝업 상점 정보';
