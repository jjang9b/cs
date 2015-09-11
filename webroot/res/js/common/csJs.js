/* csJs.js 2014.10.09 */
"use strict";

$(function(){
    
  function cs( oPostErrMsg, oNonCheck ){
    this.sLocation = location.href;
    this.aLocationSplit = this.sLocation.split( '/' );
    this.uDebug = '/' + this.aLocationSplit[ 3 ] + '/' + this.aLocationSplit[ 4 ] + '/getDebug';

    this.oPostErrMsg = oPostErrMsg || {};
    this.oNonCheck = oNonCheck || {};
  }

  cs.prototype = {
    setData : function( oPostErrMsg, oNonCheck ){

      cs.call( this, oPostErrMsg, oNonCheck );
    }
  };

  cs.prototype.func = {
    log : function( k, v ){

      console.log( '%c '+k, 'color:#B22222', v );
    }, getDebug : function(){

      var afterDebug = function(){
        if( _cs.aLocationSplit[ 4 ] === undefined ) return false;

        $.getJSON( _cs.uDebug, {}, function( aDebugData ){
          console.clear();

          for(var i in aDebugData)
            _cs.func.log( i, aDebugData[ i ] );

        }).fail(function( a, b, error ){ _cs.func.log( 'error', error.responseText )}); 
      };

      $( 'a[name=a_tab]' ).on( 'click', function(){
        $( this ).after(function(){ setTimeout(function(){ afterDebug(); }, 400); });
      });

      $.when( $( document ).on( 'submit' ) ).then(function(){
         afterDebug(); 
      });
    }, checkParam : function( oPostParam, sFrmName ){

      return _menu_func.checkParam( oPostParam, sFrmName );
    }, setPostParam : function(){

      _menu_func.setPostParam( arguments ); 
    /* arguments 
      0 : post api url
      1 : post add params - Object
      2 : post after callback function 
      3 : button action name. ex) btn_order 
    */
    }, doPost : function(){

      _menu_func.runPost( arguments ); 
    /* arguments 
      0 : post api url
      1 : post params - Object
      2 : post User Object
      3 : post after callback function (Option) 
      4 : button action name. ex) btn_post
    */
    }, doMultiPost : function(){
    
      _menu_func.runMultiPost( arguments ); 
    }
  };

  var _menu_func = {
    setPostParam : function(){
      var _arguments = arguments[0];
      var oPostParamAdd = _arguments[0]
        , sFrmName = _arguments[1] || null
        , oPostParam = oPostParamAdd || {}; 
      var sSelector = null;

      /* input, textarea, select, radio, checkbox 수집 */
      if( $( 'form[name=' + sFrmName + ']' ).length > 0 ){
        sSelector = 'form[name=' + sFrmName + '] input, ' +
                  'form[name=' + sFrmName + '] textarea, ' +
                  'form[name=' + sFrmName + '] select, ' +
                  'form[name=' + sFrmName + '] input[type=radio]:checked ';
      } else
        sSelector = 'input, textarea, select, input[type=radio]:checked';

      $( sSelector ).each(function( k, v ){
        var type = $( v ).eq(0).attr( 'type' )
          , id = $( v ).eq(0).attr( 'id' )
          , name = $( v ).eq(0).attr( 'name' )
          , val = $( v ).eq(0).val();

        if( type != 'hidden' && type != 'checkbox' ){
          if( id !== undefined )
            oPostParam[ id ] = val; 
          else if( name !== undefined )
            oPostParam[ name ] = val; 
        }
      });

      if( $( 'form[name=' + sFrmName + ']' ).length > 0 )
        sSelector = 'form[name=' + sFrmName + '] input[type=checkbox]:checked';
      else
        sSelector = 'input[type=checkbox]:checked';

      $( sSelector ).each(function( k, v ){
        var id = $( v ).eq(0).attr( 'id' )
          , name = $( v ).eq(0).attr( 'name' )
          , val = $( v ).val();

        if( id !== undefined ){
          if( oPostParam[ id ] === undefined )
            oPostParam[ id ] = [];

          oPostParam[ id ].push( val ); 
        } else if( name !== undefined ) {

          if( oPostParam[ name ] === undefined )
            oPostParam[ name ] = [];

          oPostParam[ name ].push( val ); 
        }
      });

      window.cs.oPostParam = oPostParam;

    }, runPost : function(){
      var _arguments = arguments[0];

      var sPostUrl = _arguments[0] || null        
        , oPostParamAdd = _arguments[1] || {}
        , oCallback = _arguments[2] || function(){}
        , sActionName = _arguments[3] || null
        , sFrmName = _arguments[4] || null;

      _cs.func.setPostParam( oPostParamAdd, sFrmName );

      var oPostParam = window.cs.oPostParam;
      var sChkResult = _cs.func.checkParam( oPostParam, sFrmName );

      if( !sChkResult ) return false;

      /* Post 호출, callback 호출 */
      $.post( sPostUrl, oPostParam, function( result ){
        oCallback( result, sActionName );

        _cs.func.log( 'result', result );
      }, 'json').fail(function( err, a, b ){
        alert( '에러가 발생했습니다.\n\n' + err.responseText );

        _cs.func.log( 'error', err.responseText );
      });

    }, checkParam : function( oPostParam, sFrmName ){
      var oNonCheck = _cs.oNonCheck || {}
        , oPostErrMsg = _cs.oPostErrMsg || {};

      /* 입력 데이터 유효성 자동 체크 */
      for( var k in oPostParam){
        if( oPostParam[ k ] == '' || oPostParam[ k ] == undefined ){
          var oParam = null;

          if( $( 'form[name=' + sFrmName + ']' ).length > 0 ){
            oParam = ($( 'form[name=' + sFrmName + '] #' + k ).length > 0 ) 
              ? $( '#' + k ) : $( 'form[name=' + sFrmName + '] [name=' + k + ']' );
          } else
            oParam = ($( '#' + k ).length > 0 ) ? $( '#' + k ) : $( '[name=' + k + ']' );

          if( oParam.length > 0 ){
            if( oNonCheck[ k ] === undefined ){
              alert( oPostErrMsg[ k ] ); 
              oParam.focus();
              return false;
            }
          }
        }
      }
      return true;

    }, runMultiPost : function(){

      var _arguments = arguments[0];
      var sMaxPostCount = $( '#i_sMaxPostCount' ).val()
        , sPostTimeOutSecond = $( '#i_sPostTimeOutSecond' ).val();

      var sPostUrl = _arguments[0]        
        , oPostParamAdd = _arguments[1]
        , oPostUser = _arguments[2]
        , oCallback = _arguments[3] || function(){}
        , sActionName = _arguments[4] || null;
      
      _cs.func.setPostParam( oPostParamAdd );

      var oPostParam = window.cs.oPostParam;
      var sChkResult = _cs.func.checkParam( oPostParam, null );

      if( !sChkResult ) return false;
      
      var aSplitUser = oPostUser[0].value.split( ',' );

      if( aSplitUser.length > sMaxPostCount ){
        alert( sMaxPostCount + '건 이상 한 번에 처리할 수 없습니다.\n현재 개수 : ' + aSplitUser.length );
        return false;
      }

      window.sStartNum = 0;
      window.csPostError = false;
      window.csPostTimeout = false;
      window.csPostStartTime = new Date();

      var doPost = function(sUserId){
        oPostParam.pPostUserId = sUserId;

        return $.post( sPostUrl, oPostParam, function( result ){
          oCallback( result, sActionName );

          if( result.result_code == 1 ){
            var sCurUserNum = aSplitUser[ window.sStartNum ];
            window.sStartNum++;
            _cs.func.log( 'result 완료 건수 ' + window.sStartNum + ', 고객번호 ' + sCurUserNum, result );

          } else {
            window.csPostError = true;
            _cs.func.log( 'result error', result );
          }

        }, 'json').then(function(){
          if( (aSplitUser.length > window.sStartNum) && !window.csPostError && !window.csPostTimeout )
            doPost( aSplitUser[ window.sStartNum ] );
            
        }, 'json').fail(function(error){
          window.csPostError = true;
          _cs.func.log( 'error', error.responseText );

        }, 'json');
      }

      doPost(aSplitUser[0]);

      (function(){
         var int_post = setInterval(function(){
            
          var csPostEndTime = new Date();

          if(window.sStartNum != aSplitUser.length)
          {
            if( ((csPostEndTime.getTime() - window.csPostStartTime.getTime()) / Math.floor(1000)) > sPostTimeOutSecond ){
              window.csPostTimeout = true;

              $( '#txtPostModal' ).html( '<b class="text-red">' + window.sStartNum + '</b> 건 정상 완료, 고객번호 <b class="text-red">' 
                + aSplitUser[ window.sStartNum ] + '</b>, <b class="text-red">' 
                + sPostTimeOutSecond + '</b>초 응답시간 초과 발생하였습니다.' 
                + '<br />서버쪽 이상이 있을수 있으므로 잠시 뒤 시도 후 개발팀으로 문의해 주세요.');
                

              $( 'button[name=btn_post]' ).attr( 'disabled', false );
              $( 'button[name=btn_post]' ).attr( 'class', 'btn btn-primary' );

              $( '#postWaitModal' ).modal();
              clearInterval(int_post);

            } else if( window.csPostError ) {
              $( '#txtPostModal' ).html( '총 <b class="text-red">' + aSplitUser.length 
                + '</b>건 중 <b class="text-red">' + window.sStartNum + '</b> 건 처리 완료, 고객번호 <b class="text-red">' 
                + aSplitUser[ window.sStartNum ]+ '</b> 건 에서 지급 오류 발생하였습니다.'
                + '<br />해당 고객번호건 재시도 후 오류시 F12 콘솔 오류 값을 통해 개발팀으로 문의해 주세요.');

              $( 'button[name=btn_post]' ).attr( 'disabled', false );
              $( 'button[name=btn_post]' ).attr( 'class', 'btn btn-primary' );

              $( '#postWaitModal' ).modal();
              clearInterval(int_post);

            } else {
              $( '#txtPostModal' ).html( '총 <b class="text-red">' + aSplitUser.length + '</b>건 중 <b class="text-red">' 
                + window.sStartNum + '</b> 건, 고객번호 <b class="text-red">' + aSplitUser[ window.sStartNum ] + '</b> 처리 중' );

              $( 'button[name=btn_post]' ).attr( 'disabled', true );
              $( 'button[name=btn_post]' ).attr( 'class', 'btn btn-muted' );
              $( '#postWaitModal' ).modal();
            }
          } 
          else 
          {

            $( '#txtPostModal' ).html( '총<b class="text-red"> ' +window.sStartNum + '</b> 건 정상 처리 완료 하였습니다.' );
            $( '#postWaitModal' ).modal();

            $( 'button[name=btn_post]' ).attr( 'disabled', false );
            $( 'button[name=btn_post]' ).attr( 'class', 'btn btn-primary' );

            clearInterval(int_post);
          }

        }, 50);
      })();

    }
  };

  var _cs = window.cs = new cs();
});

$(function(){

  var sTableName = null
  , sSearchValue = $( '#f_search input[name=pSearchValue]' ).eq( 0 ).val()
  , sSearchDate = $( '#f_search input[name=pSearchDate]' ).eq( 0 ).val();

  var uSearch = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/search' 
  , uBeforeSearch = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/beforeSearch'
  , uSaveExcel = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/submitSaveExcel'
  , uViewOneTable = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/submitViewOneTable'
  , uShowEditColumn = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/submitShowEditColumn'
  , uEditValue = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/submitEditValue'
  , uPrimaryList = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/ajaxPrimaryList'
  , uTabLogSearch = '/' + cs.aLocationSplit[ 3 ] + '/log/search'
  , uTabSelect = '/' + cs.aLocationSplit[ 3 ] + '/' + cs.aLocationSplit[ 4 ] + '/tabSelect';

  var func = {
    onloadGameJS : function(){
      var cs = cs || null;

      if( cs == null )
        $.getScript( '/res/js/wiz/game.js' ); 
      else {
        if( cs.aLocationSplit[ 3 ] != '' )
          $.getScript( '/res/js/game/' + cs.aLocationSplit[ 3 ] + '.js' ); 
      }
    },
    onloadResize : function(){
      var height = $(window).height() - $( 'body > .header' ).height() - ($( 'body > .footer' ).outerHeight() || 0);
      height = parseInt(height)-83;
      $( '.wrapper' ).css( 'min-height', height + 'px' );

      var content = $( '.wrapper').height();
      if (content > height)
        $( '.left-side, html, body' ).css( 'min-height', content + 'px' );
      else {
        $( '.left-side, html, body' ).css( 'min-height', height + 'px' );
      }
    },
    onloadEvent : function(){
      var sDebugConsole = $( '#sDebugConsole' ).val();

      if(!cs.aLocationSplit[ 3 ]){
        $( '[data-toggle="offcanvas"]' ).click();
        $( '[data-toggle="offcanvas"]' ).hide();
      }
              
      func.onloadResize();
      $( '.wrapper' ).resize(function() { func.onloadResize(); });

      func.setSearchDefaultType();

      if( $( '#t_datatable' ).length > 0 ){
        var table = $( '#t_datatable' ).DataTable();
        table.order([0, 'desc']).draw();
      }

      /* - view_type : list_before 지원 */
      if( $( 'a[name=btn_util]' ).length > 0 ) $( 'button[name=btn_before_search]' ).hide();

      if( $( 'input[name=pSearchDate]' ).length > 0 ){
        $( 'input[name=pSearchDate]' ).daterangepicker({ 
          todayHighlight:true,
          timePicker: true, timePickerIncrement: 30, 
          timePicker12Hour : false, format: 'YYYY/MM/DD h:mm A' 
        });
      }

      $( 'input[name=pSearchValue]' ).keydown(function( e ){
        if( e.which == 13 )
          $( 'button[name=btn_search]' ).click();
      });

      if( sDebugConsole == 1 )
        cs.func.getDebug();

    },
    setSearchDefaultType : function(){
                       
      $( '#uSearchType li' ).each( function( k, v ){ 

        var sSearchType = $( 'input[name=pSearchType]' ).val();

        if( sSearchType == $( this ).attr( 'value' ) )
          $( '#txt_usn_type' ).html( $( this ).text() );

      });

    }, 
    setOpenEdit : function( _t, sColumnName ){

       var primaryStr = []
         , _db = $( _t ).parents( 'form[name=f_edit]:first' ).find( 'input[name=pDsn]' ).val()
         , _table = $( _t ).parents( 'form[name=f_edit]:first' ).find( 'input[name=pTableName]' ).val()
         , _tableType = $( _t ).parents( 'form[name=f_edit]:first' ).find( 'input[name=pTableType]' ).val();

       $.getJSON( uPrimaryList, { pDsn : _db, pTableName : _table }, function( r ){

         if( $( '#iIsListAccount' ).val() && _tableType == 'main' ){
         
           $( 'table[name=t_listaccount]' ).children( 'tbody' ).children( 'tr' ).children( '[name=tdSelect]' ).each( function( k, v ){

             var rData = v.dataset.primary_string.split( '|' );

             for( var i = 0, j = r.length; i < j; i++ ){

               if( r[ i ].column_name == rData[ 0 ] ){

                 primaryStr.push( v.dataset.primary_string );

               }

             }
           });

         } else {
         
           $( _t ).parent().parent().children( '[name=tdSelect]' ).each( function( k, v ){

             var rData = v.dataset.primary_string.split( '|' );

             for( var i = 0, j = r.length; i < j; i++ ){

               if( r[ i ].column_name == rData[ 0 ] ){

                 primaryStr.push( v.dataset.primary_string );

               }

             }
           });

         }

         window.open( '', 'cs_edit', 'width=400,height=580,scrollbars=no' );

         $( _t ).parents( 'form[name=f_edit]:first' ).attr( 'method', 'post' );

         $( _t ).parents( 'form[name=f_edit]:first' ).attr( 'action', uShowEditColumn );
         $( _t ).parents( 'form[name=f_edit]:first' ).attr( 'target', 'cs_edit' );

         $( '<input />' ).attr( 'name', 'pColumnName' ).val( sColumnName ).hide().appendTo( $( _t ).parents( 'form[name=f_edit]:first' ) );
         $( '<input />' ).attr( 'name', 'pPrimaryString' ).val( primaryStr ).hide().appendTo( $( _t ).parents( 'form[name=f_edit]:first' ) );

         $( _t ).parents( 'form[name=f_edit]:first' ).submit();

      });
    }
  };

  $( '#uSearchType li' ).click( function( e ){ 

    var sSearchType = $(this).attr( 'value' )
      , sSearchTypeText = $(this).text();

    $( '#txt_usn_type' ).html( sSearchTypeText );

    $( '#f_search input[name=pSearchType]' ).val( sSearchType );

  });

  $( 'a[name=btn_util]' ).click( function(){ 

    var button_type = $( this ).data( 'button_type' )
      , ran_target = Math.random().toString( 36 ); 

    if( $( this ).data( 'table_type' ) == 'main' )
      sTableName = $( '#sCurrentTable' ).val();
    else
      sTableName = $( '#u_tabtable li.active a' ).data( 'table' ) || $( '#sCurrentTable' ).val();

    $( '#f_util' ).attr( 'method', 'post' );

    switch( button_type ){

      case "excel" : 

        $( '#f_util' ).attr( 'action', uSaveExcel );

        break;
    
      case "window" : 

        window.open( '', ran_target, '' );

        $( '#f_util' ).attr( 'action', uViewOneTable );
        $( '#f_util' ).attr( 'target', ran_target );

        break;
    }

    $( '#f_util input[name=pTableName]' ).val( sTableName );
    $( '#f_util input[name=pTableType]' ).val( $( this ).data( 'table_type' ) );

    $( '#f_util' ).submit();

  });

  $( 'a[name=btn_edit]' ).click( function(){

    var sColumnName = $( this ).data( 'column_name' );

    func.setOpenEdit( this, sColumnName );

  });

  $( 'a[name^=a_tab]' ).attr( 'href', 'javascript:void(0)' );
  $( 'a[name=a_tab]' ).click( function(){

    sTableName = $( this ).data( 'table' );

    $.post( uTabSelect, { pTableName : sTableName, pSearchValue : sSearchValue, pSearchDate : sSearchDate }, function( result ){

      $( '#tab_0' ).html( result );

      $( '#tab_0 a[name=btn_edit]' ).click( function(){

        var sColumnName = $( this ).data( 'column_name' );

        func.setOpenEdit( this, sColumnName );

      });

      if( $( '#t_datatable' ).length > 0 ){
        var table = $( '#t_datatable' ).DataTable();
        table.order([0, 'desc']).draw();
      }

    });

  });
  $( 'a[name=a_tab_log]' ).click( function(){

    var sTableName = $( this ).data( 'table' );

    window.open( uTabLogSearch + '/' + sSearchValue + '/' + sTableName, 'cs_log', '' ); 
      
  });

  $( 'button[name=btn_before_search]' ).click( function(){ 

    var sUsn = $( this ).data( 'usn' ) || $( '#f_search input[name=pSearchValue]' ).val();

    $( '#f_search' ).attr( 'method', 'post' );
    $( '#f_search' ).attr( 'action', uSearch );

    $( '#f_search input[name=pSearchValue]' ).val( sUsn );  

    $( '#f_search' ).submit();

    func.setSearchDefaultType();

  });

  $( 'button[name=btn_search]' ).click( function(){ 

    var sSearchType = $( '#uSearchType li' ).eq( 0 ).attr( 'value' )
      , sSearchValue = $( 'input[name=pSearchValue]' );
    
    if( sSearchType != undefined && sSearchValue[0].value == '' ){ 
      alert( '검색 값을 입력해 주세요.' );
      sSearchValue.focus();
      return false;
    }

    $( '#f_search' ).attr( 'method', 'post' );

    if( $( '#i_isaccount' ).val() == 'true' )
      $( '#f_search' ).attr( 'action', uBeforeSearch );
    else
      $( '#f_search' ).attr( 'action', uSearch );

    if( $( '#f_search input[name=pSearchType]' ).val() == '' ) $( '#f_search input[name=pSearchType]' ).val( sSearchType );

    $( '#f_search' ).submit(); 

    func.setSearchDefaultType();

  });

  $( 'button[name=btn_window_edit]' ).click( function(){

    if( $( '#f_window_edit input[name=pEditValue]' ).val() == '' )
    {
      alert( '변경 값을 입력해 주세요.' );
      $( '#f_window_edit input[name=pEditValue]' ).focus();
      return false;
    } 
    else if( $( '#f_window_edit textarea[name=pEditReason]' ).val() == '' )
    {
      alert( '변경 사유를 입력해 주세요.' );
      $( '#f_window_edit textarea[name=pEditReason]' ).focus();
      return false;
    }

    if( confirm( '정말 변경 하시겠습니까?' ) ){

      $( '#f_window_edit' ).attr( 'method', 'post' );
      $( '#f_window_edit' ).attr( 'action', uEditValue );

      $( '#f_window_edit' ).submit();
    }

  });

  $( 'button[name=btn_window_end]' ).click( function(){ 

    var sOpenerMethodName = $( opener.location ).attr( 'href' ).split( '/' )[5];

    if( sOpenerMethodName != 'submitViewOneTable' )
      location.reload();
    else
      opener.location.reload();

    $( opener.document ).find( '#i_isaccount' ).val( false );
    $( opener.document ).find( 'button[name=btn_search]' ).click();

    window.close();

  });

  $( 'button[name=btn_window_close]' ).click( function(){ window.close(); });

  func.onloadGameJS();
  func.onloadEvent();
});
