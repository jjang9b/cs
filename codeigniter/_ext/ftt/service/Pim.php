<?php
class Pim
{
  public function encrypt($sServerUrl, $sType, $sVal)
  {
    $CI =& get_instance();
    $CI->load->library('jsonrpc');
    $oClient =& $CI->jsonrpc->get_client();

    $sRemoteMethod = 'pim.encrypt';
    $oParam = new \stdClass;
    $oParam->type = $sType;
    $oParam->val = $sVal;

    $oClient->server($sServerUrl);
    $oClient->method($sRemoteMethod);
    $oClient->request($oParam);
    if ($oClient->send_request())
    {
      $oResult = $oClient->get_response();

      //if (isset($oResult->data_object->error))
      //  echo 'logic error!';

      return $oResult->data_object;
    }

    //echo 'RPC Error';
    return NULL;
  }

  public function decrypt($sServerUrl, $sType, $nVal)
  {
    $CI =& get_instance();
    $CI->load->library('jsonrpc');
    $oClient =& $CI->jsonrpc->get_client();

    $sRemoteMethod = 'pim.decrypt';
    $oParam = new \stdClass;
    $oParam->type = $sType;
    $oParam->val = $nVal;

    $oClient->server($sServerUrl);
    $oClient->method($sRemoteMethod);
    $oClient->request($oParam);
    if ($oClient->send_request())
    {
      $oResult = $oClient->get_response();

      //if (isset($oResult->data_object->error))
      //  echo 'logic error!';

      return $oResult->data_object;
    }

    //echo 'RPC Error';
    return NULL;
  }

}
