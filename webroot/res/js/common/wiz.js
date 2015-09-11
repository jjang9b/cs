function ajax(sType, sUrl, sData, oSucessFunc, oErrorFunc, oOption) {

  if (typeof(oSucessFunc) == 'undefined' || oSucessFunc == '')
    oSucessFunc = _showResultSuccess; //function(){ };

  if (typeof(oErrorFunc) == 'undefined' || oErrorFunc == '')
    oErrorFunc= _showResultError; //function(){ };

  if (typeof(oOption) != 'undefined' && typeof(oOption.contentType) != 'undefined')
    sContentType = oOption.contentType;
  else
    sContentType = 'application/x-www-form-urlencoded; charset=UTF-8'; // json = 'application/json; charset=utf-8'

  var packet = {
                  type: sType, // 'GET', 'POST'
                  url: sUrl,
                  contentType: sContentType,
                  data: sData,
                  success: function (oData, sStatus, oXhr) {
                              oSucessFunc(oData, sStatus, oXhr);
                           },
                  error:   function (oXhr, sStatus) {
                              switch (sStatus) {
                                case 404:
                                    oErrorFunc(sStatus + ' File not found', sStatus, oXhr);
                                    break;
                                case 500:
                                    oErrorFunc(sStatus + ' Server error', sStatus, oXhr);
                                    break;
                                case 0:
                                    oErrorFunc(sStatus + ' Request aborted', sStatus, oXhr);
                                    break;
                                default:
                                    oErrorFunc('Unknown error or invalid url '+sUrl, sStatus, oXhr);
                              }
                          }
        };

  $.ajax(packet);
}

function json_rpc(sUrl, sData, oSucessFunc, oErrorFunc) {
  ajax('POST', sUrl, sData, oSucessFunc, oErrorFunc, {'contentType' : 'application/json; charset=utf-8'});
}

function api_proxy(sType, sUrl, sData, oSucessFunc, oErrorFunc, oOption) {
  if (typeof(oSucessFunc) == 'undefined')
    oSucessFunc = _showResultSuccess;
  if (typeof(oErrorFunc) == 'undefined')
    oErrorFunc = _showResultError;

  ajax(sType, '/proxy?_debug=1&_target='+sUrl, sData, oSucessFunc, oErrorFunc, oOption);
}

// default function
function _showResultSuccess(oData, sStatus, oXhr) {
    var sContent = $("[name='_result']").val();
    $("[name='_result']").val(oData + "\n\n" + sContent);
}

// default function
function _showResultError(sMessage, sStatus, oXhr) {
    var sContent = $("[name='_result']").val();
    $("[name='_result']").val('Error : '+sMessage + "\n\n" + sContent);
}
function onLoadResize(){
  var height = $(window).height() - $( 'body > .header' ).height() - ($( 'body > .footer' ).outerHeight() || 0);
  height = parseInt(height) - 40;
  $( '.wrapper' ).css( 'min-height', height + 'px' );

  var content = $( '.wrapper').height();

  if (content > height)
    $( '.left-side, html, body' ).css( 'min-height', content + 'px' );
  else
    $( '.left-side, html, body' ).css( 'min-height', height + 'px' );
}

$(function(){
  onLoadResize();
  $( 'ul[class=treeview-menu]' ).first().show();
});
