<?php
class SimpleError
{
  private $arrError;
  private $nCount;
  private $sResource;
  private $sLanguage;
  private $CI;

  public function __construct($aParams=array())
  {
    $this->arrError = array();
    $this->nCount = 0;
    $this->sResource = ($aParams['resource'] ? $aParams['resource'] : 'error_common');
    $this->sLanguage = ($aParams['language'] ? $aParams['language'] : 'en');

    $this->CI =& get_instance();
    $this->CI->lang->load($this->sResource, $this->sLanguage);
  }

  public function setError($sCode, $sSubMessage='')
  {
    $oError = new \stdClass;
    $oError->code = $sCode;
    $oError->message = $this->_getErrorMessage($sCode, $sSubMessage);

    $this->arrError[$this->nCount++] = $oError;
    return $oError;
  }

  public function getError($bPop=false)
  {
    if (!$this->isExist())
      return NULL;

    if ($bPop)
    {
      $oError = array_pop($this->arrError);
      --$this->nCount;
      return $oError;
    }
    else
    {
      return $this->arrError[$this->nCount-1];
    }
  }

  public function getErrorAll()
  {
    return $this->arrError;
  }

  public function isExist()
  {
    if ($this->nCount > 0)
      return true;
    else
      return false;
  }

  private function _getErrorMessage($sCode, $sSubMessage='')
  {
    $sReturn = $this->CI->lang->line($sCode, array($sSubMessage));

    if (!isset($sReturn) || !$sReturn)
      $sReturn = $this->CI->lang->line('UNKNOWN', array($sSubMessage), true);

    return $sReturn;
  }
}
