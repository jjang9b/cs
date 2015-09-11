<?php
class Service
{
  public function getSsnListAll($bFromCache=true)
  {
    $CI =& get_instance();
    $CI->load->driver('cache');

    $nNowTime = time();
    $nCachedTime = $CI->cache->apc->get('SSN_LIST_CACHE_TIME');
    //echo 'diff seconds : '.($nNowTime - $nCachedTime).', cache time : '.$nCachedTime.', now time '.$nNowTime; // DEBUG

    if (!$bFromCache || empty($nNowTime) || ($nNowTime - $nCachedTime) > 600)  // 60sec * 10
    {
      //echo 'read from api'; // DEBUG

      $ch = curl_init();
      $sApiUrl = 'http://backoffice.four33.co.kr/ssnlist.aspx';
      curl_setopt($ch, CURLOPT_URL, $sApiUrl);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);  // 2 seconds
      curl_setopt($ch, CURLOPT_TIMEOUT, 3);  // 3 seconds

      $sContent = curl_exec($ch);
      //$aCurlInfo = curl_getinfo($ch);
      curl_close($ch);

      /*
      // DEBUG
      $sContent = '[{"Category":1,"Code":1,"Name":"커뮤니티","Order":0,"IsHide":true,"Short":""},{"Category":1,"Code":3,"Name":"시크릿박스","Order":0,"IsHide":true,"Short":""},{"Category":1,"Code":4,"Name":"모로저택의비밀","Order":0,"IsHide":true,"Short":""},{"Category":1,"Code":5,"Name":"에픽하츠","Order":0,"IsHide":true,"Short":""},{"Category":1,"Code":6,"Name":"케리비안점프","Order":0,"IsHide":true,"Short":""},{"Category":1,"Code":7,"Name":"마스터오브디팬스","Order":0,"IsHide":true,"Short":""},{"Category":1,"Code":8,"Name":"My Ocean","Order":0,"IsHide":true,"Short":""},{"Category":1,"Code":9,"Name":"Crazy 433","Order":0,"IsHide":true,"Short":""},{"Category":1,"Code":10,"Name":"R2","Order":0,"IsHide":true,"Short":""},{"Category":1,"Code":11,"Name":"활","Order":0,"IsHide":false,"Short":""},{"Category":1,"Code":12,"Name":"CityOfHero","Order":0,"IsHide":true,"Short":""},{"Category":1,"Code":13,"Name":"Myst","Order":0,"IsHide":false,"Short":""},{"Category":1,"Code":14,"Name":"히어로메이커","Order":0,"IsHide":false,"Short":""},{"Category":1,"Code":15,"Name":"활 베트남","Order":0,"IsHide":false,"Short":""},{"Category":1,"Code":16,"Name":"활 인도네시아","Order":0,"IsHide":false,"Short":""},{"Category":1,"Code":17,"Name":"활 일본","Order":0,"IsHide":false,"Short":""},{"Category":1,"Code":18,"Name":"블랙썬","Order":0,"IsHide":false,"Short":"BS"},{"Category":1,"Code":19,"Name":"최후의날","Order":0,"IsHide":false,"Short":"lastday"},{"Category":1,"Code":20,"Name":"로봇킹","Order":0,"IsHide":false,"Short":"RK"},{"Category":1,"Code":21,"Name":"블레이드","Order":0,"IsHide":false,"Short":"blade"},{"Category":1,"Code":22,"Name":"용","Order":0,"IsHide":false,"Short":"dragon"},{"Category":1,"Code":23,"Name":"수호지","Order":0,"IsHide":false,"Short":"suhoji"},{"Category":1,"Code":24,"Name":"총","Order":0,"IsHide":false,"Short":"gun"},{"Category":1,"Code":25,"Name":"샌드스톰","Order":0,"IsHide":false,"Short":"SS"},{"Category":1,"Code":26,"Name":"TT 레이서","Order":0,"IsHide":false,"Short":"tt"},{"Category":1,"Code":27,"Name":"이터널크래쉬","Order":0,"IsHide":false,"Short":"EC"},{"Category":1,"Code":28,"Name":"샐러드볼","Order":0,"IsHide":false,"Short":"SB"},{"Category":1,"Code":29,"Name":"마피아","Order":0,"IsHide":false,"Short":""},{"Category":1,"Code":30,"Name":"영웅","Order":0,"IsHide":false,"Short":"hod"},{"Category":1,"Code":31,"Name":"히든하츠","Order":0,"IsHide":false,"Short":"hidden"},{"Category":1,"Code":32,"Name":"ark","Order":0,"IsHide":false,"Short":"ark"},{"Category":1,"Code":33,"Name":"활 대만","Order":0,"IsHide":false,"Short":"bow-tw"},{"Category":1,"Code":34,"Name":"회색도시2","Order":0,"IsHide":false,"Short":""},{"Category":1,"Code":35,"Name":"붉은보석","Order":0,"IsHide":false,"Short":"rj"},{"Category":1,"Code":39,"Name":"몬스터샷","Order":0,"IsHide":false,"Short":""},{"Category":1,"Code":40,"Name":"블레이드 해외","Order":0,"IsHide":false,"Short":"BG"},{"Category":1,"Code":41,"Name":"더 챔피언","Order":0,"IsHide":false,"Short":"champ"},{"Category":1,"Code":42,"Name":"Project SF","Order":0,"IsHide":false,"Short":"SF"},{"Category":1,"Code":43,"Name":"아이언 사이드","Order":0,"IsHide":false,"Short":"IS"},{"Category":1,"Code":44,"Name":"호조팡","Order":0,"IsHide":false,"Short":"hj"},{"Category":1,"Code":45,"Name":"활2","Order":0,"IsHide":false,"Short":"bow2"},{"Category":1,"Code":46,"Name":"플랜츠워2","Order":0,"IsHide":false,"Short":"pw2"}]';
      */

      if (!empty($sContent))
        $CI->cache->apc->save('SSN_LIST_ALL', $sContent);

      $CI->cache->apc->save('SSN_LIST_CACHE_TIME', $nNowTime);
    }
    else
    {
      //echo 'read from cache'; // DEBUG
      $sContent = $CI->cache->apc->get('SSN_LIST_ALL');
    }

    $aSsnList = array();
    if (!empty($sContent))
      $aSsnList = json_decode($sContent);

    $aReturn = array();
    foreach ($aSsnList as $key => $oCurSsn)
      $aReturn[$oCurSsn->Code] = $oCurSsn; 

    return $aReturn;
  }

  public function getSsnList($bFromCache=true)
  {
    $aSsnList = $this->getSsnListAll($bFromCache);

    foreach ($aSsnList as $key => $oCurSsn)
    {
      if ($oCurSsn->IsHide)
        unset($aSsnList[$key]);
    }

    return $aSsnList;
  }

}
