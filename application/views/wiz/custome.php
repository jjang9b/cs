<script type="text/javascript">
  function showTableList4Account(aData, sStatus, oXhr)
  {
    if (typeof(aData) == 'undefined' || aData == '')
    {
      alert('no result');
      return;
    }

    $( 'select[name="main_table"]' ).html('');
    $( 'select[name="tab_table_all[]"]' ).hide();
    $( "#column_list" ).html('');

    for (var k in aData)
    {
      $( 'select[name="main_table"]' ).append( '<option value="' + aData[k] + '">' + aData[k] + '</option>' );
      $( 'select[name="tab_table_all[]"]' ).append( '<option value="' + aData[k] + '">' + aData[k] + '</option>' );
    }
  }

  function showColumnList4Account( type, aData )
  {
    if (typeof(aData) == 'undefined' || aData == '')
    {
      alert('no result');
      return;
    }

    var html = '<table id="e_infolist" class="table table-bordered table-hover">';
    html += '<thead>';
    html += '<tr>';
    html += '<th class="bg-red">PK 컬럼(키)</th>';
    html += '<th class="bg-navy">노출 여부</th>';
    html += '<th class="bg-navy">수정 여부</th>';
    html += '<th>Column Name</th>';
    html += '<th class="bg-navy">한글 노출 컬럼명</th>';
    html += '<th>Default Value</th>';
    html += '<th>Nullable</th>';
    html += '<th>Data Type</th>';
    html += '<th>Max Length</th>';
    html += '<th>Primary</th>';
    html += '</tr>';
    html += '</thead>';
   
    html += '<tbody>';

    for (var k in aData)
    {
      html += '<tr>';
      html += '<td align=center>';
      html += '<input type="checkbox" name="whereColumn['+ type +'][]" value="' + aData[k].column_name + '"' 
        + ( ( aData[k].is_primary == 'Y' ? 'checked' : '' ) || ( aData[k].data_type == 'datetime' ? 'checked' : '' ) ) +' />';
      html += '</td>';
      html += '<td align=center>';
      html += '<input type="checkbox" name="column['+ type +'][]" value="' + aData[k].column_name + '" checked />';
      html += '</td>';
      html += '<td align=center>';
      if (aData[k].is_primary != 'Y')
        html += '<input type="checkbox" name="editColumn['+ type +'][]" value="' + aData[k].column_name + '" />';
      html += '</td>';

      html += '<td>'+aData[k].column_name+'</td>';
      html += '<td><input type="text" class="form-control" name="columnText['+ type +']['+aData[k].column_name+']"' + 
        'value="'+ ( aData[k].column_comment != '' ? aData[k].column_comment : aData[k].column_name ) +'"></td>';

      html += '<td>'+aData[k].column_default+'</td>';
      html += '<td>'+aData[k].is_nullable+'</td>';
      html += '<td>'+aData[k].data_type+'</td>';
      html += '<td>'+aData[k].max_len+'</td>';
      html += '<td>'+( aData[k].is_primary == 'Y' ? '<b>'+aData[k].is_primary+'</b>' : aData[k].is_primary )+'</td>';
      html += '</tr>';
    }

    html += '</tbody>';
    html += '</table>';

    return html;
  }

  function closeTab(sTabId)
  {
    var sPaneId = 'tab_pane_'+sTabId.substring(7);
    $( '#'+sTabId ).remove();
    $( '#'+sPaneId ).remove();
    $('#tab_related_table a:last').tab('show');

    $("#tab_pid_content div").each( function(){
      if ($(this).is(':last-child'))
        $(this).addClass('active');
      else
        $(this).removeClass('active');
    });
  }

  function onError(sMessage, sStatus, oXhr)
  {
    alert('AJAX ERROR : '+sStatus);
  }

  $(document).ready(function() {

    $( '#tab_wrap' ).hide();

    $("select[name='database']").change( function( e ){ 
      var oData = {};
      oData['database'] = ''+$(this).val();

      if (oData['database'] == '')
        return;

      $("select[name='tab_table_all[]']").html( '' );

      ajax('GET', '/wiz/custome/getTableList', $.param(oData), showTableList4Account, onError);
    });

    $("select[name='main_table']").change( function(){ 
      var database = $("select[name='database']").val()
        , table = $( this ).val();

      window._tmp_main_table = table;

      $.get( '/wiz/custome/getColumnList', { database : database, table : table }, function( r ){

        var html = showColumnList4Account( 'main_' + _tmp_main_table, r );

        $( '#column_list' ).html( html );

        if (table)
          $( 'select[name="tab_table_all[]"]' ).show();

      }).fail( onError );
    });

    $("select[name='tab_table_all[]']").click( function(){ 
      $( '#tab_wrap' ).show();

      var database = $("select[name='database']").val();
      var aSelectedTable = $( this ).val();

      var aDisplayTabObj = $("#tab_related_table li");
      var aDisplayTabId = new Array();
      $("#tab_related_table li").each( function(){
        aDisplayTabId[aDisplayTabId.length] = $(this).attr('id');
      });

      for( i = 0, j = aDisplayTabId.length; i < aSelectedTable.length; i++)
      {
        sCurTabId = 'tab_id_'+aSelectedTable[i];
        if ( jQuery.inArray(sCurTabId, aDisplayTabId) >= 0 )
          continue;

        $("#tab_related_table").append('<li id="'+ sCurTabId +'"><a href="" data-toggle="tab">'+ aSelectedTable[i] 
          +'<i class="fa fa-fw fa-times" onClick="closeTab(\''+ sCurTabId +'\')"></i></a></li>');

        window._tmp_cur_table_name = aSelectedTable[i];

        $("#tab_related_table li").click( function( e ){ 

          var sCurTabName = 'tab_pane_'+$(this).text();

          $("#tab_pid_content div").each( function(){
            $(this).removeClass('active');
          });

          $("#"+sCurTabName).addClass('active');

        });

        $.get( '/wiz/account/getColumnList', { database : database , table : _tmp_cur_table_name }, function( r ){
          var html = showColumnList4Account( 'tab_'+_tmp_cur_table_name , r );

          $("#tab_pid_content div").each( function(){ // tab content
            $(this).removeClass('active');
          });

          var r_viewtype = '<div class="alert alert-dismissable bg-gray col-md-6">' +
          '<table><tr>' +
          '<td><label class="text-white">Tab 노출명 : &nbsp;</label></td>' + 
          '<td><div><input type="text" name="tab_disp_name[tab_' + _tmp_cur_table_name +']" value="'+ _tmp_cur_table_name +
          '" class="form-control" placeholder="" /></div></td>' +
          '<td style="width:10px"></td>' + 
          '<td><label class="text-white">View Type : &nbsp;</label></td>' + 
          '<td><input type="radio" name="r_viewtype[tab_' + _tmp_cur_table_name +']" value="list"/><b>list</b>&nbsp;&nbsp;' + 
          '<input type="radio" name="r_viewtype[tab_' + _tmp_cur_table_name +']" value="table" checked /><b>table</b></td>' +
          '</tr></table>' + 
          '</div>';

          html = r_viewtype +  html;

          $( '#tab_pid_content' ).append( '<div class="tab-pane active" id="tab_pane_'+ _tmp_cur_table_name +'">' + html + '</div>' );
          $('#tab_related_table a:last').tab('show');
        }).fail( onError );
      }
    });

    $("button[name='go']").click( function( e ){ 
      $( '.form-group' ).attr( 'class', 'form-group' );
      $( '.control-label' ).hide();

      if( $( 'input[name=ssn]' ).val() == null || !$.isNumeric( $( 'input[name=ssn]' ).val() ) ){
        $( '#d_ssn' ).attr( 'class', 'form-group has-error' );
        $( '#d_ssn' ).children( '.control-label' ).show();
        $( 'input[name=ssn]' ).focus();
        return false;
        
      } else if( $( 'select[name=database] option:selected' ).val() == '' ) {
        $( '#d_database' ).attr( 'class', 'form-group has-error' );
        $( '#d_database' ).children( '.control-label' ).show();
        return false;

      } else if( $( 'input[name=pCustomeKey]' ).val() == '' ){
        $( '#d_custome_key' ).attr( 'class', 'form-group has-error' );
        $( '#d_custome_key' ).children( '.control-label' ).show();
        $( 'input[name=pCustomeKey]' ).focus();
        return false;

      } else if( $( 'select[name="main_table"] option:selected' ).length == 0 ) {
        $( '#d_table' ).attr( 'class', 'form-group has-error' );
        $( '#d_table' ).children( '.control-label' ).show();
        return false;
      }
        
      $("#fo").submit(); 
    }); 
  });
</script>
<div class="page-header">
  <small>
    <h4><b class="text-light-blue">CSTool Wizard</b></h4>
  </small>
</div>
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-gray">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-fw fa-edit"></i>
          <small><b class="text-red">Custome</b> 페이지 생성</small>
          </h3>
        </div>
        <div class="box-header">
          <label class="c_title"><small>제공되는 Wizard 템플릿을 선택하여 
            <b class="text-red">특정 Custome 이름으로 생성</b>하는 페이지 입니다<br />
            Custome으로 생성하기 위해 <b class="text-red">제한 조건없이 전체 허용</b>되며, 각 템플릿 성격에 맞춰 정보 입력해 주세요.
            </small>
          </label>
        </div>
        <form id="fo" name="fo" action="/wiz/custome/create" method="post">
          <div class="box-body">
            <div id="d_ssn" class="form-group">
              <label>1. Ssn : </label>
              <label class="control-label" for="inputError" style="display:none">
              <i class="fa fa-times-circle-o"></i><small> SSN을 숫자로 입력해 주세요.</small></label>
              <input type="text" class="form-control" name="ssn" placeholder="ssn">
            </div>

            <label><b class="text-red">2. Custome으로 생성할 View 형태 선택</b></label>
            <div class="callout callout-default">
              <div class="form-group">
                <select name="pCustomeViewTemplate" class="form-control">
                  <option value="account">사용자 정보 (Main:input, Tab 선택)</option>
                  <option value="define">정의 테이블 조회 (Tab 필수)</option>
                  <option value="log">로그 조회 (Tab:input, date 필수)</option>
                  <option value="order">주문 등록/조회 (Main:input, date 필수)</option>
                  <option value="post">우편함 지급/조회 (Main:input, date 필수)</option>
                  <option value="restrict">유저 제재/해제 (Main:input, date 필수)</option>
                  <option value="accessLog">GM 변동 이력 (Main:input, date 필수)</option>
                </select>
              </div>
            </div>
            <div id="d_custome_key" class="form-group">
              <label><b class="text-red">2-1. Custome Key : </b> (해당 key로 controller/model/view/config가 설정됩니다)</label>
              <small></small>
              <label class="control-label" for="inputError" style="display:none">
              <i class="fa fa-times-circle-o"></i><small> Custome Key를 입력해 주세요.</small></label>
              <input type="text" class="form-control" name="pCustomeKey" placeholder="custome key">
            </div>

            <div id="d_database" class="form-group">
              <label>3. Database : 원하는 값이 없을 경우 database config file 설정 (database.php)</label>
              <label class="control-label" for="inputError" style="display:none">
              <i class="fa fa-times-circle-o"></i><small> Database를 선택해 주세요.</small></label>
              <select name="database" class="form-control">
                <option value="">Database를 선택해 주세요!</option>
<?php
              foreach ($aDatabase as $sDSN => $aCurDatabase) :
?>
                <option value="<?php echo $sDSN; ?>"><?php echo $sDSN.' ( Host : '.$aCurDatabase['hostname'].', 
                  DB Type : '.$aCurDatabase['dbdriver'].', Database : '.$aCurDatabase['database'].')'; ?></option>
<?php
              endforeach;
?>
              </select>
            </div>

            <label>4. 메인 테이블</label>
            <div class="callout callout-default">
              <div id="d_table" class="form-group">
                <label>4-1. 메인 정보 테이블 선택</label>
                <label class="control-label" for="inputError" style="display:none">
                <i class="fa fa-times-circle-o"></i><small> 메인 테이블을 선택해 주세요.</small></label>
                <select name="main_table" size=10 class="form-control"></select>
              </div>
              <div class="form-group">
                <label>4-2. Main table 노출 Column 선택 : PK 컬럼 선택 / 노출 컬럼 선택 / 한글 노출 컬럼명 입력</label>
                <div id="column_list" class="box-body table-responsive">메인 테이블을 선택해 주세요.</div>
              </div>
            </div>

            <label>5. 아래쪽 TAB 으로 노출할 테이블 </label>
            <div class="callout callout-default">
              <div class="form-group">
                <label>5-1. 노출 테이블</label>
                <select name="tab_table_all[]" size=10 multiple class="form-control"></select>
              </div>

              <div id="tab_wrap" class="form-group">
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs" id="tab_related_table"></ul>
                  <div class="tab-content" id="tab_pid_content"></div>
                </div>
              </div>
            </div>

          </div>
          <div class="box-footer">
            <button type="button" name="go" class="btn bg-navy">실행</button>
          </div>
        </div>
      </form>
  </div>
</div>
