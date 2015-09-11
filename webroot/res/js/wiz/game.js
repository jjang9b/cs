/* game.js */
"use strict";

$(function(){

  var uPostPoint = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/postPoint'
    , uPostUserInfo = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/postUserInfo'
    , uPostUserState = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/postUserState'
    , uPostOrder = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/postOrder'
    , uSubmitPost = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/submitPost'
    , uPostRestrict = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/postRestrict';

  var sMaxPostCount = $( '#i_sMaxPostCount' ).val()
    , sPostTimeOutSecond = $( '#i_sPostTimeOutSecond' ).val();

  this.onVisibleInit = function(){
    if( $( 'select[name=pInfoType]' ).length > 0 ){
      $( 'select[name=pInfoType]' ).change(function(){
        var sSelValue = $(this).find( 'option:selected' ).val()
          , sValue = $( '#p_' + sSelValue ).val(); 

        $( 'input[name=pInfoNow]' ).val( sValue );
      });
    }

    if( $( 'select[name=pStateType]' ).length > 0 ){
      $( 'select[name=pStateType]' ).change(function(){
        var sSelValue = $(this).find( 'option:selected' ).val();
        $( 'div[name=d_' + sSelValue + ']' ).show();

        $(this).find( 'option' ).each(function( k, v ){
          var sSelOtherValue = $( v ).val();

          if( sSelOtherValue != sSelValue ){
            $( 'div[name=d_' + sSelOtherValue + ']' ).hide();
          }
        });
      });
    }
  };

  this.onAutoParamInit = function(){
    var oData = {
      postErrMsg : {
        pInfoAfterValue : '정보 수정 값을 입력해 주세요.', 
        pInfoAmount : '유저 수정 포인트값을 입력해 주세요.',
        pInfoMemo : '유저 포인트값 변경 사유를 입력해 주세요.',
        pStateExpiredt : '유저 제재 기간을 입력해 주세요.',
        pStateMemo : '유저 상태 변경 사유를 입력해 주세요.', 
        pOrderAccountIdx : '유저 고유번호(유저키 번호)를 입력해 주세요.',
        pOrderId : '주문 번호를 입력해 주세요.',
        pOrderMemo : '주문 등록 사유(추가메모)를 입력해 주세요.',
        pPostMsg : '우편함 노출 메세지를 입력해 주세요.',
        pPostItemStr: '우편함 지급 아이템을 입력해 주세요.',
        pPostReason: '우편함 지급 사유를 입력해 주세요.',
        pPostUser: '우편함 발송 대상 유저를 입력해 주세요.',
        pRestrictGmReason: '유저 제재/해제 GM 사유를 입력해 주세요.',
        pRestrictUser: '유저 제재/해제 대상 유저를 입력해 주세요.'
      }, nonCheck : {
        pSearchValue : 1, 
        pSearchType : 1,
        pInfoNow : 1, // [유저정보수정] 유저 현재값
        pStateBlockedFlag : 1 // [유저제재] 유저 제재 상태
      }
    };

    cs.setData( oData.postErrMsg, oData.nonCheck );
  };

  var oCallback = function( result, sActionName ){
    if( result.result_code ){
      var nSearchIdx = null;

      switch( sActionName ){
        case 'ac_userinfo' : 
          alert( '정상 유저 정보 수정 되었습니다.' );
          nSearchIdx = window.cs.oPostParam.pInfoAccountIdx;
         break;
        case 'ac_userstate' : 
          alert( '정상 유저 상태 변경 되었습니다.' );
          nSearchIdx = window.cs.oPostParam.pStateAccountIdx;
         break;
        case 'ac_order' : 
          alert( '정상 주문 등록/복구 되었습니다.' );
          nSearchIdx = window.cs.oPostParam.pOrderAccountIdx;
         break;
        case 'ac_restrict' : 
          alert( '정상 유저 제재/해제 되었습니다.' );
         break;
        default : 
          alert( '정상 변경 되었습니다.' );
         break; 
      }

      $( '#i_isaccount' ).val( false );
      $( 'input[name=pSearchValue]' ).val( nSearchIdx );
      $( 'button[name=btn_search]' ).click();
    } else {

      alert( '오류가 발생 하였습니다.\n' + result );
      cs.func.log( 'error', result );
    }
  }

  $( 'button[name=btn_userinfo]' ).click( function(){ 
    cs.func.setPostParam();

    if( window.cs.oPostParam.pInfoValue == window.cs.oPostParam.pInfoNow ) {
      alert( '현재와 다른 값을 입력해 주세요.' );
      $( 'input[name=pInfoValue]' ).eq(0).focus();
      return false;
    }

    cs.func.doPost( uPostUserInfo, {}, oCallback, 'ac_userinfo', 'frm_userinfo');
  });

  $( 'button[name=btn_userstate]' ).click( function(){ 
    cs.func.doPost( uPostUserState, {}, oCallback, 'ac_userstate', 'frm_userstate');
  });

  $( 'button[name=btn_order]' ).click( function(){ 
    cs.func.doPost( uPostOrder, {}, oCallback, 'ac_order');
  });

  $( 'button[name=btn_post]' ).click( function(){ 
    var pPostUser = $( 'textarea[name=pPostUser]' );

    cs.func.doMultiPost( uSubmitPost, {}, pPostUser );
  });

  $( 'button[name=btn_restrict]' ).click( function(){ 
    var pRestrictUser = $( 'textarea[name=pRestrictUser]' );

    cs.func.doMultiPost( uPostRestrict, {}, pRestrictUser );
  });

  this.onVisibleInit();
  this.onAutoParamInit();
});
