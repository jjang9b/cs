<script type="text/javascript">
  function showTableList4Account(aData, sStatus, oXhr)
  {
    if (typeof(aData) == 'undefined' || aData == ''){
      alert('no result');
      return;
    }

    $( 'select[name="tab_table_all[]"]' ).html( '' );

    for (var k in aData)
      $( 'select[name="tab_table_all[]"]' ).append( '<option value="' + aData[k] + '">' + aData[k] + '</option>' );
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
    html += '<th class="bg-red">검색 여부(키)</th>';
    html += '<th class="bg-navy">노출 여부</th>';
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
      html += '<input type="checkbox" id="whereColumn" name="whereColumn['+ type +'][]" value="' + aData[k].column_name + '"' 
        + ( ( aData[k].is_primary == 'Y' ? 'checked' : '' ) || ( aData[k].data_type == 'datetime' ? 'checked' : '' ) ) +' />';
      html += '</td>';
      html += '<td align=center>';
      html += '<input type="checkbox" name="column['+ type +'][]" value=' + aData[k].column_name + ' checked />';
      html += '</td>';

      html += '<td>'+aData[k].column_name+'</td>';
      html += '<td><input type="text" class="form-control" name="columnText['+ type +']['+aData[k].column_name+']" value="'+aData[k].column_name+'"></td>';
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
      var sDbName = $( this ).val();

      if( sDbName.indexOf( 'master' ) > -1 ){
        alert( '로그 조회는 Slave DB로만 가능 합니다.' ); 
        return false;
      }
      
      var oData = {};
      oData['database'] = '' + sDbName;

      if (oData['database'] == '')
        return;

      ajax('GET', '/wiz/log/getTableList', $.param(oData), showTableList4Account, onError);
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

        $.get( '/wiz/log/getColumnList', { database : database , table : _tmp_cur_table_name }, function( r ){
          var html = showColumnList4Account( 'tab_'+_tmp_cur_table_name , r );

          $("#tab_pid_content div").each( function(){ // tab content
            $(this).removeClass('active');
          });

          // ad tab content
          var r_viewtype = '<div class="alert alert-dismissable bg-gray col-md-6">' +
          '<table><tr>' +
          '<td><label class="text-white">Tab 노출명 : &nbsp;</label></td>' + 
          '<td><div><input type="text" name="tab_disp_name[tab_' + _tmp_cur_table_name +']" value="'+ _tmp_cur_table_name +
          '" class="form-control" placeholder="" /></div></td>' +
          '<td style="width:10px"></td>' + 
          '<td><label class="text-white">View Type : &nbsp;</label></td>' + 
          '<td><input type="radio" name="r_viewtype[tab_' + _tmp_cur_table_name +']" value="table" checked /><b>table</b></td>' +
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

      } else if( $( 'select[name="tab_table_all[]"] option:selected' ).length == 0 ) {
        $( '#d_table' ).attr( 'class', 'form-group has-error' );
        $( '#d_table' ).children( '.control-label' ).show();
        return false;

      } else if( $( 'input[name^="whereColumn"]:checked' ).length > 2 ) {
        alert( '검색 여부 키를 Key Column과 Date Column 두가지만 선택해 주세요.' );
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
          <small><b class="text-red">Log</b> 조회 페이지 생성</small></h3>
        </div>
        <form id="fo" name="fo" action="/wiz/log/create" method="post">
          <div class="box-body">
            <div id="d_ssn" class="form-group">
              <label>1. Ssn : </label>
              <label class="control-label" for="inputError" style="display:none">
              <i class="fa fa-times-circle-o"></i><small> SSN을 숫자로 입력해 주세요.</small></label>
              <input type="text" class="form-control" name="ssn" placeholder="ssn">
            </div>

            <div id="d_database" class="form-group">
              <label>2. Database : 원하는 값이 없을 경우 database config file 설정 (database.php)</label>
              <label class="control-label" for="inputError" style="display:none">
              <i class="fa fa-times-circle-o"></i><small> Database를 선택해 주세요.</small></label>
              <select name="database" class="form-control">
                <option value="">Database를 선택해 주세요!</option>
<?php
              foreach ($aDatabase as $sDSN => $aCurDatabase) :
?>
                <option value="<?php echo $sDSN; ?>"><?php echo $sDSN.' ( Host : '.$aCurDatabase['hostname'].', DB Type : '.$aCurDatabase['dbdriver'].', 
                  Database : '.$aCurDatabase['database'].')'; ?></option>
<?php
              endforeach;
?>
              </select>
            </div>

            <label>3. TAB 으로 노출할 테이블 </label>
            <div class="callout callout-default">
              <div id="d_table" class="form-group">
                <label>3-1. 노출 테이블</label>
                <label class="control-label" for="inputError" style="display:none">
                <i class="fa fa-times-circle-o"></i><small> 테이블을 선택해 주세요.</small></label>
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
        <input type="hidden" name="htype" value="log" />
      </form>
  </div>
</div>
