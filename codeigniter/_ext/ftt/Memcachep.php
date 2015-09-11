<?php
/** 
* Memcachd pure php client
*
* @package ftt
* @version 1.0  
* @author itraveler@gmail.com
*/
//namespace ftt;

/**
 * Flag: indicates data is serialized
 */
if (!defined('MEMCACHE_SERIALIZED'))
  define('MEMCACHE_SERIALIZED', 1<<0);

/**
 * Flag: indicates data is compressed
 */
if (!defined('MEMCACHE_COMPRESSED'))
  define('MEMCACHE_COMPRESSED', 1<<1);

/**
 * Minimum savings to store data compressed
 */
if (!defined('MEMCACHE_COMPRESSION_SAVINGS'))
  define('MEMCACHE_COMPRESSION_SAVINGS', 0.20);

if (!defined('MEMCACHE_QUERY_TIMEOUT'))
  define('MEMCACHE_QUERY_TIMEOUT', 1);

class Memcachep extends Memcache
{
  protected $strDSN;
  protected $arrHostInfo;
  protected $nHostCount;
  protected $oHostChooser;
  protected $nCurHostIndex;

  public $bZip = true;
  public $nZipThreshold;
  public $bExistZlib;
  public $strResultCode;
  public $strResultMessage;

  protected $oDataEncoder;

  /**
  * constructor
  *
  * @param $arrHostInfo : host info for connection
  * @return
  */
  public function __construct($arrHostInfo=array()) /*{{{*/
  {
    $this->nZipThreshold = 10240;
    $this->bExistZlib = function_exists("gzcompress");

    $this->setHostChooser();
    $this->setHostInfo($arrHostInfo);
  }/*}}}*/


  public function setHostInfo($arrHostInfo)/*{{{*/
  {
    $this->arrHostInfo = $arrHostInfo;
    $this->nHostCount = count($this->arrHostInfo);

    if ($this->oHostChooser)
      $this->oHostChooser->setKeyAll($arrHostInfo);
  }/*}}}*/

  public function setHostChooser($oHostChooser=NULL)/*{{{*/
  {
    if (isset($oHostChooser))
    {
      $this->oHostChooser = $oHostChooser;
    }
    else if(!isset($this->oHostChooser)) // default
    {
      $CI =& get_instance();
      $CI->load->library('ftt/KeyChooser', NULL, '_ftt_keychooser');
   
      $this->oHostChooser = $CI->_ftt_keychooser;
    }
  }/*}}}*/

  public function setEncoder(&$oDataEncoder)/*{{{*/
  {
    $this->oDataEncoder = $oDataEncoder;
  }/*}}}*/

  public function setZipThreshold($nZipThreshold=10240)/*{{{*/
  {
    $this->nZipThreshold = $nZipThreshold;
  }/*}}}*/

  protected function _connect($strKey)/*{{{*/
  {
    $nHostIndex = $this->oHostChooser->getKeyIndex($strKey);
    $this->nCurHostIndex = $nHostIndex;

    if ($nHostIndex < 0 || $nHostIndex >= $this->nHostCount)
    {
      $this->strResultCode = "SYS_ERROR";
      $this->strResultMessage = 'can not choose a host';
      return false;
    }

    $arrCurHostInfo = &$this->arrHostInfo[$nHostIndex];

    $sock = fsockopen($arrCurHostInfo['host'], $arrCurHostInfo['port'], $errno, $errstr, (isset($arrCurHostInfo['timeout']) ? $arrCurHostInfo['timeout'] : 1));
    if (!$sock)
    {
      $this->strResultCode = "SYS_ERROR";
      $this->strResultMessage = 'can not connect to '.$arrCurHostInfo['host'].":".$arrCurHostInfo['port'];
    }
    else
    {
      socket_set_timeout($sock, MEMCACHE_QUERY_TIMEOUT);

      $this->strResultCode = "OK";
      $this->strResultMessage = $arrCurHostInfo['host'].":".$arrCurHostInfo['port']."(".$nHostIndex.") connected.";
    }

    return $sock;
  }/*}}}*/
 
  protected function _close ($sock)/*{{{*/
  {
    if ($sock)
      @fclose($sock);
  }/*}}}*/

  public function connect($strAddr, $nPort=11211, $nTimeout=1)/*{{{*/
  {
    return true;
  }/*}}}*/

  public function close()/*{{{*/
  {
    return true;
  }/*}}}*/

  public function get ($strKey)/*{{{*/
  {
    $sock = $this->_connect($strKey);
    if (!$sock)
      return false;
    
    $mixData = $this->_get($sock, $strKey);
    $this->_close($sock);

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey) => ".$mixData;

    return $mixData;
  }/*}}}*/

  public function set ($strKey, $mixData, $nExpireSec=0)/*{{{*/
  {
    $sock = $this->_connect($strKey);
    if (!$sock)
      return false;

    $bResult = $this->_store($sock, 'set', $strKey, $mixData, $nExpireSec);
    $this->_close($sock);

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $mixData, $nExpireSec) => ".($bResult ? 'true' : 'false');

    return $bResult;
  }/*}}}*/

  public function add ($strKey, $mixData, $nExpireSec=0)/*{{{*/
  {
    $sock = $this->_connect($strKey);
    if (!$sock)
      return false;

    $bResult = $this->_store($sock, 'add', $strKey, $mixData, $nExpireSec);
    $this->_close($sock);

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $mixData, $nExpireSec) => ".($bResult ? 'true' : 'false');

    return $bResult;
  }/*}}}*/

  public function replace ($strKey, $mixData, $nExpireSec=0)/*{{{*/
  {
    $sock = $this->_connect($strKey);
    if (!$sock)
      return false;

    $bResult = $this->_store($sock, 'replace', $strKey, $mixData, $nExpireSec);
    $this->_close($sock);

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $mixData, $nExpireSec) => ".($bResult ? 'true' : 'false');
     
    return $bResult;
  }/*}}}*/

  public function delete ($strKey)/*{{{*/
  {
    $sock = $this->_connect($strKey);
    if (!$sock)
      return false;

    $bResult = $this->_delete($sock, $strKey);
    $this->_close($sock);

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $nExpireSec) => ".($bResult ? 'true' : 'false');
     
    return $bResult;
  }/*}}}*/

  public function increment ($strKey, $nValue=1)/*{{{*/
  {
    $sock = $this->_connect($strKey);
    if (!$sock)
      return false;

    $nResult = $this->_incrdecr($sock, 'incr', $strKey, $nValue);
    $this->_close($sock);

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $nValue) => ".$nResult;

    return $nResult; // false or numeric
  }/*}}}*/

  public function decrement ($strKey, $nValue=1)/*{{{*/
  {
    $sock = $this->_connect($strKey);
    if (!$sock)
      return false;

    $nResult = $this->_incrdecr($sock, 'decr', $strKey, $nValue);
    $this->_close($sock);

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $nValue) => ".$nResult;

    return $nResult; // false or numeric
  }/*}}}*/


  //////////////////////////////////////////////////////////////////////////////

  public function getResultCode()/*{{{*/
  {
    return $this->strResultCode;
  }/*}}}*/

  public function getResultMessage()/*{{{*/
  {
    return $this->strResultMessage;
  }/*}}}*/

  public function getStats()/*{{{*/
  {
    $arrResult = array();
    foreach ($this->arrHostInfo as $arrCurServerInfo)
    {
      if (!empty($arrResult[$arrCurServerInfo['host'].':'.$arrCurServerInfo['port']]))
        continue;

      $sock = fsockopen($arrCurServerInfo['host'], $arrCurServerInfo['port'], $errno, $errstr, (isset($arrCurServerInfo['timeout']) ? $arrCurServerInfo['timeout'] : 1));
      if (!$sock)
        continue;

      $bResult = $this->_stats($sock, $arrStatistics);
      if (!empty($arrStatistics))
        $arrResult[$arrCurServerInfo['host'].':'.$arrCurServerInfo['port']] = $arrStatistics;

      $this->close();
    }

    return $arrResult;
  }/*}}}*/

  //////////////////////////////////////////////////////////////////////////////

  protected function _get ($sock, $strKey)
  {
    $this->_replaceDelimeter($strKey);
    $cmd = "get $strKey\r\n";
    if (!fwrite($sock, $cmd, strlen($cmd)))
    {
      $this->strResultCode = "SYS_ERROR";
      $this->strResultMessage .= "\n".__METHOD__."($sock, $strKey)";
      return false;
    }
    
    $arrData = array();
    $this->_load_items($sock, $arrData);
    
    $strData = $arrData[$strKey];
    if (!isset($arrData[$strKey]) || $arrData[$strKey] === false)
      $this->strResultCode = "NOT_FOUND";
    else
      $this->strResultCode = "OK";

    return ($this->strResultCode == "OK") ? $strData : false;
  }

  protected function _store ($sock, $strCommand, $strKey, $strData, $nExpireSec=0)
  {
    $arrCommand = array('set', 'add', 'replace'); // , 'append', 'prepend'
    if (!in_array($strCommand, $arrCommand))
    {
      if ($this->debug)
        printf("client: not supported storage command\n");
      return false;
    }

    $this->_replaceDelimeter($strKey);
    $flags = 0;
    
    if (isset($this->oDataEncoder) && !is_scalar($strData))
    {
      $strData = $this->oDataEncoder->encode($strData);
      $flags |= MEMCACHE_SERIALIZED;
    }
    
    $len = strlen($strData);
    
    if ($this->bZip && $this->bExistZlib && $this->nZipThreshold && $len >= $this->nZipThreshold)
    {
      $c_value = gzcompress($strData, 9);
      $c_len = strlen($c_value);
      
      if ($c_len < $len*(1 - MEMCACHE_COMPRESSION_SAVINGS))
      {
        $strData = $c_value;
        $len = $c_len;
        $flags |= MEMCACHE_COMPRESSED;
      }
    }
    if (!fwrite($sock, "$strCommand $strKey $flags $nExpireSec $len\r\n$strData\r\n"))
    {
      $this->strResultCode = "SYS_ERROR";
      $this->strResultMessage .= "\n".__METHOD__." : $strCommand failed.";
      return false;
    }
      
    $line = trim(fgets($sock));
    
    if ($line == "STORED")
    {
      $this->strResultCode = "OK";
      return true;
    }

    $this->strResultCode = $line;
    return false;
  }

  protected function _delete ($sock, $strKey)
  {
    $this->_replaceDelimeter($strKey);
    $cmd = "delete $strKey\r\n";
    if (!fwrite($sock, $cmd, strlen($cmd)))
    {
      $this->strResultCode = "SYS_ERROR";
      $this->strResultMessage .= "\n".__METHOD__." : delete failed.";
      return false;
    }
  
    $res = trim(fgets($sock));
    
    if ($res == "DELETED")
    {
      $this->strResultCode = "OK";
      $this->strResultMessage .= "\n".__METHOD__." : delete succeed.";
      return true;
    }

    $this->strResultCode = $res;
    return false;
  }

  protected function _incrdecr ($sock, $strCommand, $strKey, $nValue = 1)
  {
    $this->_replaceDelimeter($strKey);

    if ($strCommand != 'incr' && $strCommand != 'decr')
      return false;

    $cmd = "$strCommand $strKey $nValue\r\n";
    if (!fwrite($sock, $cmd, strlen($cmd)))
    {
      $this->strResultCode = "SYS_ERROR";
      $this->strResultMessage .= "\n".__METHOD__." : $strCommand failed.";
      return false;
    }
  
    $res = trim(fgets($sock));
    
    if (is_numeric($res))
    {
      $this->strResultCode = "OK";
      return $res;
    }

    $this->strResultCode = $res;
    return false;
  }

  protected function _load_items ($sock, &$ret)
  {
    while (1)
    {
      $decl = fgets($sock);
      if ($decl == "END\r\n")
      {
        return true;
      } 
      else if (preg_match('/^VALUE (\S+) (\d+) (\d+)\r\n$/', $decl, $match))
      {
        list($rkey, $flags, $len) = array($match[1], $match[2], $match[3]);
        $bneed = $len+2;
        $offset = 0;
        
        while ($bneed > 0)
        {
          $data = self::fread($sock, $bneed);
          $n = strlen($data);
          if ($n == 0)
            break;
          $offset += $n;
          $bneed -= $n;
          $ret[$rkey] .= $data;
        }
        
        if ($offset != $len+2)
        {
          $this->strResultCode = "SYS_ERROR";
          $this->strResultMessage .= "\n".__METHOD__." : broked data";

          unset($ret[$rkey]);
          return false;
        }
        
        $ret[$rkey] = substr($ret[$rkey], 0, -2);

        if ($this->bExistZlib && $flags & MEMCACHE_COMPRESSED)
          $ret[$rkey] = gzuncompress($ret[$rkey]);

        if ($flags & MEMCACHE_SERIALIZED)
          $ret[$rkey] = $this->oDataEncoder->decode($ret[$rkey]);
      }
      else 
      {
        return false;
      }
    }
  }

  protected function _replaceDelimeter(&$strKey)
  {
    $pos = strpos($strKey, "\0");
    if ($pos === false)
      return;

    $strKey = str_replace("\0", ",", $strKey);
  }

  /**
   * get statistics data
   *
   * @param
   * @return  
   */

  protected function _stats ($sock, &$arrStats)
  {
    $this->_replaceDelimeter($strKey);
    $cmd = "stats\r\n";
    if (!fwrite($sock, $cmd, strlen($cmd)))
    {
      $this->strResultCode = "SYS_ERROR";
      return false;
    }
    
    while (1)
    {
      $decl = fgets($sock);
      if ($decl == "END\r\n")
      {
        $this->strResultCode = "OK";
        return true;
      } 
      else if (preg_match('/^STAT (\S+) (\S+)\r\n$/', $decl, $match))
      {
        list($name, $value) = array($match[1], $match[2]);
        $arrStats[$name] = $value;
      }
      else 
      {
        $this->strResultCode = "SYS_ERROR";
        return false;
      }
    }
    
    $this->strResultCode = "SYS_ERROR";
    return false;
  }


  public static function fread($fp, $len)
  {
    while (!feof($fp) && strlen($buf) < $len)
    {
      $buf .= fread($fp, $len - strlen($buf));
    }
    return $buf;
  }/*}}}*/
}
