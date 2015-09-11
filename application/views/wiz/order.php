<script type="text/javascript">
  function showTableList4Account(aData, sStatus, oXhr)
  {
    if (typeof(aData) == 'undefined' || aData == '')
    {
      alert('no result');
      return;
    }

    $( 'select[name="main_table"]' ).html('');
    $( "#column_list" ).html('');

    for (var k in aData)
    {
      $( 'select[name="main_table"]' ).append( '<option value="' + aData[k] + '">' + aData[k] + '</option>' );
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
        + ( ( aData[k].is_primary == 'Y' ? 'checked' : '' ) || ( $.inArray( aData[k].data_type, ['datetime', 'timestamp'] ) >= 0 ? 'checked' : '' ) ) +' />';
      html += '</td>';
      html += '<td align=center>';
      html += '<input type="checkbox" name="column['+ type +'][]" value=' + aData[k].column_name + ' checked />';
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

      ajax('GET', '/wiz/order/getTableList', $.param(oData), showTableList4Account, onError);
    });

    $("select[name='main_table']").change( function(){ 
      var database = $("select[name='database']").val()
        , table = $( this ).val();

      window._tmp_main_table = table;

      $.get( '/wiz/order/getColumnList', { database : database, table : table }, function( r ){

        var html = showColumnList4Account( 'main_' + _tmp_main_table, r );

        $( '#column_list' ).html( html );

      }).fail( onError );
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

      } else if( $( 'select[name="main_table"] option:selected' ).length == 0 ) {
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
      <div class="box box-navy">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-fw fa-edit"></i>
          <small><b class="text-red">주문 등록/조회</b> 페이지 생성</small></h3>
        </div>

        <form id="fo" name="fo" action="/wiz/order/create" method="post">
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
                <option value="<?php echo $sDSN; ?>"><?php echo $sDSN.' ( Host : '.$aCurDatabase['hostname'].', 
                  DB Type : '.$aCurDatabase['dbdriver'].', Database : '.$aCurDatabase['database'].')'; ?></option>
<?php
              endforeach;
?>
              </select>
            </div>

            <label>3. 주문 정보 메인 테이블</label>
            <div class="callout callout-default">
              <div id="d_table" class="form-group">
                <label>3-1. 메인 정보 테이블 선택</label>
                <label class="control-label" for="inputError" style="display:none">
                <i class="fa fa-times-circle-o"></i><small> 메인 테이블을 선택해 주세요.</small></label>
                <select name="main_table" size=10 class="form-control"></select>
              </div>

              <div class="form-group">
                <label>3-2. 노출 Column 선택 : PK 컬럼 선택 / 노출 컬럼 선택 / 한글 노출 컬럼명 입력</label>
                <div id="column_list" class="box-body table-responsive"></div>
              </div>
            </div>
          </div>
          <div class="box-footer">
            <button type="button" name="go" class="btn bg-navy">실행</button>
          </div>
        </div>
        <input type="hidden" name="htype" value="order" />
      </form>
  </div>
</div>
