/* game.js */
"use strict";

$(function(){

  var uPrimaryList = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/ajaxPrimaryList';
  var uPostPoint = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/postPoint'
    , uPostUserInfo = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/postUserInfo'
    , uPostUserState = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/postUserState'
    , uPostOrder = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/postOrder'
    , uSubmitPost = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/submitPost'
    , uPostRestrict = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/postRestrict'
    , uPostAuthCreate = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/postAuthCreate'
    , uPostAuthGetAccount = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/postAuthGetAccount'
    , uPostAuthChange = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/postAuthChange';

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
        pRestrictUser: '유저 제재/해제 대상 유저를 입력해 주세요.',
        pGmName: 'GM 이름을 입력해 주세요.',
        pGmId: 'GM 아이디를 입력해 주세요.',
        pGmPassword: 'GM 비밀번호를 입력해 주세요.'
      }, nonCheck : {
        pSearchValue : 1, 
        pSearchType : 1,
        pInfoNow : 1, // [유저정보수정] 유저 현재값
        pPostUser : 1, // [우편발송] 발송 유저
        pStateBlockedFlag : 1, // [유저제재] 유저 제재 상태
        pGmId : 1, // [전체] 로그인 영역,
        pGmPassword : 1, // [전체] 로그인 영역,
        pGmModalIdx: 1, // [GM 계정관리] GM idx 
        pGmModalMenu : 1 // [GM 계정관리] 접근 가능 메뉴
      }
    };

    cs.setData( oData.postErrMsg, oData.nonCheck );
  };

  var oCallback = function( result, sActionName ){
    if( result.code == 0 ){
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
        case 'ac_auth' : 
          alert( '정상 계정 생성 되었습니다.' );
         break;
        default : 
          alert( '정상 변경 되었습니다.' );
         break; 
      }

      $( '#i_isaccount' ).val( false );
      $( 'input[name=pSearchValue]' ).val( nSearchIdx );

      if($( 'button[name=btn_search]' ).length > 0)
        $( 'button[name=btn_search]' ).click();
      else
        location.reload();
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
    var pPostUser = $( 'textarea[name=pPostUser]' ).val();
    var aSplitUser = pPostUser.split( '\n' );
    var sMaxPostCount = $( '#i_sMaxPostCount' ).val();

    if( aSplitUser.length > sMaxPostCount ){
      alert( sMaxPostCount + '건 이상 한 번에 처리할 수 없습니다.\n현재 개수 : ' + aSplitUser.length );
      return false;
    }

    cs.func.setPostParam();
    var sChkResult = cs.func.checkParam( window.cs.oPostParam, null );
    if( !sChkResult ) return false;

    cs.func.doPost( uSubmitPost, {}, function( ret ){
      $( '#postWaitModal a[name=btn_modal_close]' ).show();

      if( ret.code == 0 )
        $( '#txtModalMsg' ).html( '<i class="fa fa-check" /><b> 우편 정상 발송 완료</b>' );
      else
        $( '#txtModalMsg' ).html( '<i class="fa fa-warning" /><b> 우편 발송 오류</b>' );

      $( '#txtModalMsg' ).append( '<br /><br />' );
      if( ret.data.success_num === undefined ) ret.data.success_num = 0;

      $( '#txtModalMsg' ).append( '<h4>성공 <b class="text-red">' + ret.data.success_num + '건</b>,' 
        + '&nbsp;전체 <b>' + aSplitUser.length + '건</b></h4><br />' );

      for( var k in ret.data.user_result ){
        if( ret.data.user_result[ k ].code == 0 )
          $( '#txtModalMsg' ).append( '<b>' + k + '</b> &nbsp;&nbsp;(<b>성공</b>, &nbsp;' + ret.data.user_result[ k ].msg + ')<br />' );
        else
          $( '#txtModalMsg' ).append( '<b>' + k + '</b> &nbsp;&nbsp;(<b class="text-red">실패</b>, &nbsp;' + ret.data.user_result[ k ].msg + ')<br />' );
      }
    });

    $( '#postWaitModal' ).modal({ keyboard:false, backdrop:'static' });
    $( '#postWaitModal a[name=btn_modal_close]' ).hide();
  });

  $( 'button[name=btn_restrict]' ).click( function(){ 
    var pRestrictUser = $( 'textarea[name=pRestrictUser]' );

    cs.func.doMultiPost( uPostRestrict, {}, pRestrictUser );
  });

  $( 'button[name=btn_auth_create]' ).click( function(){ 
    cs.func.doPost( uPostAuthCreate, {}, oCallback, 'ac_auth', 'frm_auth');
  });

  $( ':checkbox[name=pPostIsAll]' ).on( 'ifChanged', function(){ 

    if( $(this).prop( 'checked' ) )
      $( 'div[name=d_post_user]' ).hide();
    else
      $( 'div[name=d_post_user]' ).show();

    $( 'textarea[name=pPostUser]' ).val( '' );
  });

  /* GM 계정 관리 - 권한 및 정보수정 */
  $( 'a[name=btn_auth_edit]' ).click( function(){ 
    var _t = this;
    var _db = $( _t ).parents( 'form[name=f_edit]:first' ).find( 'input[name=pDsn]' ).val()
      , _table = $( _t ).parents( 'form[name=f_edit]:first' ).find( 'input[name=pTableName]' ).val();

    $.getJSON( uPrimaryList, {pDsn:_db, pTableName:_table}, function( res ){

      $( _t ).parents().parents( 'tr' ).children( 'td' ).each( function( k, v ){
        if( v.dataset.primary_string !== undefined ){
          var aSplit =  v.dataset.primary_string.split( '|' );
          var aSplitMenu = '';

          for( var k in res ){
            if( res[ k ].column_name == aSplit[ 0 ] ){
              $.getJSON( uPostAuthGetAccount, {pGmIdx:aSplit[1]}, function( ret ){
                $( 'input[name=pGmModalIdx]' ).val( ret[0].idx );
                $( 'input[name=pGmModalId]' ).val( ret[0].auth_id );
                $( 'input[name=pGmModalPassword]' ).val( ret[0].auth_password );

                $( 'select[name=pGmModalPrivilege] option' ).each(function(k, v){
                  if( $( this ).val() == ret[0].auth_priv ){
                    $( this ).parent().val( ret[0].auth_priv );
                    $( this ).parent().selectpicker( 'refresh' );
                  }
                });
                $( 'select[name=pGmModalStatus] option' ).each(function(k, v){
                  if( $( this ).val() == ret[0].auth_status){
                    $( this ).parent().val( ret[0].auth_status );
                    $( this ).parent().selectpicker( 'refresh' );
                  }
                });

                $( 'input[name=pGmModalMenu]' ).prop( 'checked', false );
                $( 'input[name=pGmModalMenu]' ).iCheck('update');

                if( ret[0].access_menu.indexOf('|') > 0 )
                 aSplitMenu = ret[0].access_menu.split('|');
                else 
                 aSplitMenu = ret[0].access_menu;

                $( 'input[name=pGmModalMenu]' ).each(function(){
                  for(var k in aSplitMenu){
                    if( $(this).val() == aSplitMenu[ k ] || $(this).val() == aSplitMenu  ){
                      $( this ).prop( 'checked', true );
                    }  
                  }

                  $( 'input[name=pGmModalMenu]' ).iCheck('update');
                });
              });
            }
          }
        }
      });
    });

    $( '#d_modal' ).modal();
  });

  $( 'a[name=btn_auth_change]' ).click(function(){
    cs.func.doPost( uPostAuthChange, {}, oCallback, 'ac_default', 'frm_auth_change');
  });

  this.onVisibleInit();
  this.onAutoParamInit();
});
