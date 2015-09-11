<?php 
/**
 * CodeIgniter Redis
 *
 * A CodeIgniter library to interact with Redis
 *
 * @package       CodeIgniter
 * @category      Libraries
 * @author        Joël Cox
 * @modified      itraveler@gmail.com
 * @version       1.0
 * @link          https://github.com/joelcox/codeigniter-redis
 * @link          http://joelcox.nl
 * @link          http://redis.io/topics/protocol
 * @link          http://redis.io/topics/pipelining
 * @license       http://www.opensource.org/licenses/mit-license.html
 */
//namespace ftt;

if (!defined('REDIS_QUERY_TIMEOUT'))
  define('REDIS_QUERY_TIMEOUT', 1);

class Redisp extends Memcache{

  /**
   * CI
   *
   * CodeIgniter instance
   * @var   object
   */
  private $_ci;

  /**
   * Connection
   *
   * Socket handle to the Redis server
   * @var    handle
   */
  private $sock;
  private $_force_keep_alive = false;

  protected $strDSN;
  protected $arrHostInfo;
  protected $nHostCount;
  protected $oHostChooser;
  protected $nCurHostIndex;

  public $bZip = true;
  public $bExistZlib;
  public $strResultCode;
  public $strResultMessage;

  protected $oEncoder;

  /**
   * CRLF
   *
   * User to delimiter arguments in the Redis unified request protocol
   * @var    string
   */
  const CRLF = "\r\n";

  /**
   * Constructor
   */
  public function __construct($arrHostInfo=array())
  {
    //$this->bExistZlib = function_exists("gzcompress");

    $this->setHostChooser();
    $this->setHostInfo($arrHostInfo);

    $this->debug = false; // DEBUG
  }

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

  public function setEncoder(&$oEncoder)/*{{{*/
  {
    $this->oEncoder = $oEncoder;
  }/*}}}*/

  protected function _connect($strKey)/*{{{*/
  {
    //echo '<br>called _connect<br>'; // DEBUG
    $nHostIndex = $this->oHostChooser->getKeyIndex($strKey);
    $this->nCurHostIndex = $nHostIndex;

    if ($nHostIndex < 0 || $nHostIndex >= $this->nHostCount)
    {
      $this->strResultCode = "SYS_ERROR";
      $this->strResultMessage = 'can not choose a host';
      return false;
    }

    $arrCurHostInfo = &$this->arrHostInfo[$nHostIndex];

    // Connect to Redis
    $this->sock = fsockopen($arrCurHostInfo['host'], $arrCurHostInfo['port'], $errno, $errstr, (isset($arrCurHostInfo['timeout']) ? $arrCurHostInfo['timeout'] : 1));
    if (!$this->sock)
    {
      $this->strResultCode = "SYS_ERROR";
      $this->strResultMessage = 'can not connect to '.$arrCurHostInfo['host'].":".$arrCurHostInfo['port'];
    }
    else
    {
      //socket_set_timeout($this->sock, REDIS_QUERY_TIMEOUT);

      $this->strResultCode = "OK";
      $this->strResultMessage = $arrCurHostInfo['host'].":".$arrCurHostInfo['port']."(".$nHostIndex.") connected.";
    }

    // Authenticate when needed
    $this->_auth($config['password']);

    return $this->sock;
  }/*}}}*/
 
  protected function _close ()/*{{{*/
  {
    if ($this->sock)
      @fclose($this->sock);

    $this->sock = 0;
  }/*}}}*/

  /**
   * Info
   *
   * Overrides the default Redis response, so we can return a nice array
   * of the server info instead of a nasty string.
   * @return   array
   */
  private function _info($section = FALSE)
  {
    if ($section !== FALSE)
    {
      $response = $this->command('INFO '. $section);
    }
    else
    {
      $response = $this->command('INFO');
    }

    $data = array();
    $lines = explode(self::CRLF, $response);

    // Extract the key and value
    foreach ($lines as $line)
    {
      $parts = explode(':', $line);
      if (isset($parts[1])) $data[$parts[0]] = $parts[1];
    }

    return $data;
  }

  public function connect($strAddr, $nPort=6379, $nTimeout=1)/*{{{*/
  {
    return true;
  }/*}}}*/

  public function close()/*{{{*/
  {
    return true;
  }/*}}}*/

  //////////////////////////////////////////////////////////////////////////////

  public function get ($strKey)/*{{{*/
  {
    $mixData = $this->call('GET', $strKey, array($strKey));

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey) => ".$mixData;

    if (isset($this->oEncoder))
      $mixData = $this->oEncoder->decode($mixData);

    return $mixData;
  }/*}}}*/

  public function set ($strKey, $mixData, $nExpireSec=0)/*{{{*/
  {
    if (isset($this->oEncoder))
      $mixData = $this->oEncoder->encode($mixData);

    $arrParam = array($strKey, $mixData);
    if ($nExpireSec > 0)
    {
      $arrParam[] = 'EX';
      $arrParam[] = $nExpireSec;
    }

    $bResult = ($this->call('SET', $strKey, $arrParam) == 'OK' ? true : false);

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $mixData, $nExpireSec) => ".($bResult ? 'true' : 'false');

    return $bResult;
  }/*}}}*/

  public function add ($strKey, $mixData, $nExpireSec=0)/*{{{*/
  {
    $this->_force_keep_alive = true;
    $this->_connect($key);

    $nResult = $this->call('EXISTS', $strKey, array($strKey)); // exist = 1, not exist = 0

    $bResult = false;
    if ($nResult !== 1) // not exist
    {
      if (isset($this->oEncoder))
        $mixData = $this->oEncoder->encode($mixData);

      $arrParam = array($strKey, $mixData);
      if ($nExpireSec > 0)
      {
        $arrParam[] = 'EX';
        $arrParam[] = $nExpireSec;
      }

      $bResult = ($this->call('SET', $strKey, $arrParam) == 'OK' ? true : false);
    }
    else
    {
      if ($this->debug)
        $this->strResultMessage .= "\n".__METHOD__."($strKey) => false (already exist key)";
    }

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $mixData, $nExpireSec) => ".($bResult ? 'true' : 'false');

    $this->_close();
    $this->_force_keep_alive = false;

    return $bResult;
  }/*}}}*/

  public function replace ($strKey, $mixData, $nExpireSec=0)/*{{{*/
  {
    $this->_force_keep_alive = true;
    $this->_connect($key);

    $nResult = $this->call('EXISTS', $strKey, array($strKey)); // exist = 1, not exist = 0

    $bResult = false;
    if ($nResult === 1) // exist
    {
      if (isset($this->oEncoder))
        $mixData = $this->oEncoder->encode($mixData);

      $arrParam = array($strKey, $mixData);
      if ($nExpireSec > 0)
      {
        $arrParam[] = 'EX';
        $arrParam[] = $nExpireSec;
      }

      $bResult = ($this->call('SET', $strKey, $arrParam) == 'OK' ? true : false);
    }
    else
    {
      if ($this->debug)
        $this->strResultMessage .= "\n".__METHOD__."($strKey) => false (not exist key)";
    }

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $mixData, $nExpireSec) => ".($bResult ? 'true' : 'false');

    $this->_close();
    $this->_force_keep_alive = false;

    return $bResult;
  }/*}}}*/

  public function delete ($strKey)/*{{{*/
  {
    $nResult = $this->call('DEL', $strKey, array($strKey));

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey) => ".$nResult.' row(s) deleted.';

    if ($nResult > 0)
      return true;

    return false;
  }/*}}}*/

  public function increment ($strKey, $nValue=1)/*{{{*/
  {
    $nResult = $this->call('INCRBY', $strKey, array($strKey, $nValue));

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $nValue) => $nResult";

    return $nResult;
  }/*}}}*/

  public function decrement ($strKey, $nValue=1)/*{{{*/
  {
    $nResult = $this->call('DECRBY', $strKey, array($strKey, $nValue));

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $nValue) => $nResult";

    return $nResult;
  }/*}}}*/

  //////////////////////////////////////////////////////////////////////////////
  // add here for additional redis command
  public function getset ($strKey, $mixData)/*{{{*/
  {
    if (isset($this->oEncoder))
      $mixData = $this->oEncoder->encode($mixData);

    $mixResult = $this->call('GETSET', $strKey, array($strKey, $mixData));

    if (isset($this->oEncoder))
      $mixResult = $this->oEncoder->decode($mixResult);

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, ".print_r($mixData, true).") => ".print_r($mixResult, true);

    return $mixResult;
  }/*}}}*/

  public function hset ($strKey, $strField, $mixData)/*{{{*/
  {
    if (isset($this->oEncoder))
      $mixData = $this->oEncoder->encode($mixData);

    // 1 if field is a new field in the hash and value was set.
    // 0 if field already exists in the hash and the value was updated.
    $nResult = $this->call('HSET', $strKey, array($strKey, array($strField, $mixData)));

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $strField, $mixData) => ".$nResult;

    return $nResult;
  }/*}}}*/

  public function hmset ($strKey, $arrData)/*{{{*/
  {
    if (isset($this->oEncoder))
    {
      foreach ($arrData as $key => $val)
        $arrData[$key] = $this->oEncoder->encode($val);
    }

    $bResult = ($this->call('HMSET', $strKey, array($strKey, $arrData)) == 'OK' ? true : false);

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, ".print_r($arrData, true).") => ".($bResult ? 'true' : 'false');

    return $bResult;
  }/*}}}*/

 
  public function hexists ($strKey, $strField)/*{{{*/
  {
    $nResult = $this->call('HEXISTS', $strKey, array($strKey, array($strField)));

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $strField) => ".$nResult;

    if ($nResult)
      return true;

    return false;
  }/*}}}*/

  public function hkeys ($strKey)/*{{{*/
  {
    $mixData = $this->call('HKEYS', $strKey, array($strKey));

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey) => ".$mixData;

    return $mixData;
  }/*}}}*/

  public function hvals ($strKey)/*{{{*/
  {
    $mixData = $this->call('HVALS', $strKey, array($strKey));

    if (isset($this->oEncoder))
    {
      if (is_array($mixData))
      {
        foreach ($mixData as $key => $val)
          $mixData[$key] = $this->oEncoder->decode($val);
      }
      else
      {
        $mixData = $this->oEncoder->decode($mixData);
      }
    }

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey) => ".$mixData;

    return $mixData;
  }/*}}}*/

  public function hlen ($strKey)/*{{{*/
  {
    $mixData = $this->call('HLEN', $strKey, array($strKey));

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey) => ".$mixData;

    return $mixData;
  }/*}}}*/

  public function hget ($strKey, $strField)/*{{{*/
  {
    $mixData = $this->call('HGET', $strKey, array($strKey, array($strField)));

    if (isset($this->oEncoder))
      $mixData = $this->oEncoder->decode($mixData);

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $strField) => ".print_r($mixData, true);

    return $mixData;
  }/*}}}*/

  public function hmget ($strKey, $arrField)/*{{{*/
  {
    $arrResult = $this->call('HMGET', $strKey, array($strKey, $arrField));

    if (isset($this->oEncoder))
    {
      foreach ($arrResult as $key => $val)
        $arrResult[$key] = $this->oEncoder->decode($val);
    }

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, ".print_r($arrField, true).") => ".print_r($arrResult, true);

    return $arrResult;
  }/*}}}*/

  public function hgetall ($strKey)/*{{{*/
  {
    $mixData = $this->call('HGETALL', $strKey, array($strKey));

    if (isset($this->oEncoder))
    {
      if (is_array($mixData))
      {
        foreach ($mixData as $key => $val)
          $mixData[$key] = $this->oEncoder->decode($val);
      }
      else
      {
        $mixData = $this->oEncoder->decode($mixData);
      }
    }
 
    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey) => ".$mixData;

    return $mixData;
  }/*}}}*/

  public function hdel ($strKey, $arrField)/*{{{*/
  {
    if (!is_array($arrField))
      $arrField = array($arrField);

    $nResult = $this->call('HDEL', $strKey, array($strKey, $arrField));

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, ".print_r($arrField, true).") => ".$nResult;

    return $nResult;
  }/*}}}*/

  public function expire ($strKey, $nSec=0)/*{{{*/
  {
    $nResult = $this->call('EXPIRE', $strKey, array($strKey, $nSec));
    //$nResult = $this->command('PEXPIRE '.$strKey.' '.$nSec));

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $nSec) => ".$nResult;

    if ($nResult === 1)
      return true;

    return false;
  }/*}}}*/

   public function expireat ($strKey, $nSec=0)/*{{{*/
  {
    $nResult = $this->call('EXPIREAT', $strKey, array($strKey, $nSec));
    //$nResult = $this->command('PEXPIRE '.$strKey.' '.$nSec));

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $nSec) => ".$nResult;

    if ($nResult === 1)
      return true;

    return false;
  }/*}}}*/

  public function rpush ($strKey, $mixData)/*{{{*/
  {
    if (isset($this->oEncoder))
      $mixData = $this->oEncoder->encode($mixData);

    $nTotCount = $this->call('RPUSH', $strKey, array($strKey, $mixData));

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $mixData) => ".$nTotCount;

    return $nTotCount;
  }/*}}}*/

  public function rpop ($strKey)/*{{{*/
  {
    $mixData = $this->call('RPOP', $strKey, array($strKey));

    if (isset($this->oEncoder))
      $mixData = $this->oEncoder->decode($mixData);

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey) => ".$mixData;

    return $mixData;
  }/*}}}*/

  public function lpush ($strKey, $mixData)/*{{{*/
  {
    if (isset($this->oEncoder))
      $mixData = $this->oEncoder->encode($mixData);

    $nTotCount = $this->call('LPUSH', $strKey, array($strKey, $mixData));

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $mixData) => ".$nTotCount;

    return $nTotCount;
  }/*}}}*/

  public function lpop ($strKey)/*{{{*/
  {
    $mixData = $this->call('LPOP', $strKey, array($strKey));

    if (isset($this->oEncoder))
      $mixData = $this->oEncoder->decode($mixData);

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey) => ".$mixData;

    return $mixData;
  }/*}}}*/

  public function lrange ($strKey, $nStart, $nStop)/*{{{*/
  {
    $arrResult = $this->call('LRANGE', $strKey, array($strKey, $nStart, $nStop));

    if (isset($this->oEncoder) && is_array($arrResult))
    {
      foreach ($arrResult as $key => $val)
        $arrResult[$key] = $this->oEncoder->decode($val);
    }

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $nStart, $nStop) => ".print_r($arrResult, true);

    return $arrResult;
  }/*}}}*/

  public function llen ($strKey)/*{{{*/
  {
    $mixData = $this->call('LLEN', $strKey, array($strKey));

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey) => ".$mixData;

    return $mixData;
  }/*}}}*/

  public function sadd ($strKey, $mixData)/*{{{*/
  {
    $nResult = $this->call('SADD', $strKey, array($strKey, $mixData));

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $mixData) => ".$nResult;

    return $nResult;
  }/*}}}*/

  public function srem ($strKey, $mixData)/*{{{*/
  {
    $nResult = $this->call('SREM', $strKey, array($strKey, $mixData));

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $mixData) => ".$nResult;

    return $nResult;
  }/*}}}*/

  public function sismember ($strKey, $strMember)/*{{{*/
  {
    $nResult = $this->call('SISMEMBER', $strKey, array($strKey, $strMember));

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $strMember) => ".$nResult;

    if ($nResult >= 1)
      return true;

    return false;
  }/*}}}*/


  public function smembers ($strKey)/*{{{*/
  {
    $arrResult = $this->call('SMEMBERS', $strKey, array($strKey));

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, $nStart, $nStop) => ".print_r($arrResult, true);

    return $arrResult;
  }/*}}}*/

  // SDIFF, SINTER, SUNION


  //////////////////////////////////////////////////////////////////////////////

  // http://redis.io/commands/mset
  // MSET is atomic, so all given keys are set at once.
  public function mset ($arrKeyValue)/*{{{*/
  {
    if (!isset($this->nHostCount) || $this->nHostCount > 1) // only single server support
      return false;

    if (isset($this->oEncoder) && is_array($arrKeyValue))
    {
      foreach ($arrKeyValue as $key => $val)
        $arrKeyValue[$key] = $this->oEncoder->encode($val);
    }

    $bResult = ($this->call('MSET', '_mset_', array($arrKeyValue)) == 'OK' ? true : false);

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."($strKey, ".print_r($arrKeyData, true).") => ".($bResult ? 'true' : 'false');

    return $bResult;
  }/*}}}*/

  public function mget ($arrKey)/*{{{*/
  {
    if (!isset($this->nHostCount) || $this->nHostCount > 1) // only single server support
      return false;

    $arrResult = $this->call('MGET', '_mget_', array($arrKey));

    if (isset($this->oEncoder) && is_array($arrResult))
    {
      foreach ($arrResult as $key => $val)
        $arrResult[$key] = $this->oEncoder->decode($val);
    }

    if($this->debug)
      $this->strResultMessage .= "\n".__METHOD__."(".print_r($arrKey, true).") => ".print_r($arrResult, true);

    return $arrResult;
  }/*}}}*/


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

      $arrStatistics = $this->_info();
      if (!empty($arrStatistics))
        $arrResult[$arrCurServerInfo['host'].':'.$arrCurServerInfo['port']] = $arrStatistics;

      @fclose($sock);
    }

    return $arrResult;
  }/*}}}*/

  //////////////////////////////////////////////////////////////////////////////

  /**
   * Call
   *
   * Catches all undefined methods
   * @param  string  method that was called
   * @param  mixed  arguments that were passed
   * @return   mixed
   * @link   http://redis.io/commands
   */
  //public function __call($method, $arguments)
  public function call($method, $key, $arguments)
  {
    if (!$this->_force_keep_alive)
      $this->_connect($key);

    $request = $this->_encode_request($method, $arguments);
    $mixResult = $this->_write_request($request);

    if (!$this->_force_keep_alive)
      $this->_close();

    return $mixResult;
  }

  /**
   * Command
   *
   * Generic command function, just like redis-cli
   * @param  string  full command as a string
   * @return   mixed
   */
  public function command($string)
  {
    if (!$this->_force_keep_alive)
      $this->_connect($key);

    $slices = explode(' ', $string);
    $request = $this->_encode_request($slices[0], array_slice($slices, 1));

    $mixResult = $this->_write_request($request);

    if (!$this->_force_keep_alive)
      $this->_close();

    return $mixResult;
  }

  /**
   * Auth
   *
   * Runs the AUTH command when password is set
   * @param   string  password for the Redis server
   * @return   void
   */
  private function _auth($password = NULL)
  {
    // Authenticate when password is set
    if ( ! empty($password))
    {
      // See if we authenticated successfully
      if ($this->command('AUTH ' . $password) !== 'OK')
      {
        show_error('Could not connect to Redis, invalid password');
      }
    }
  }

  /**
   * Clear Socket
   *
   * Empty the socket buffer of theconnection so data does not bleed over
   * to the next message.
   * @return   NULL
   */
  public function _clear_socket()
  {
    // Read one character at a time
    fflush($this->sock);
    return NULL;
  }

  /**
   * Write request
   *
   * Write the formatted request to the socket
   * @param  string   request to be written
   * @return   mixed
   */
  private function _write_request($request)
  {
    if ($this->debug)
      log_message('debug', 'Redis unified request: ' . $request);

    // How long is the data we are sending?
    $value_length = strlen($request);

    // If there isn't any data, just return
    if ($value_length <= 0) return NULL;


    // Handle reply if data is less than or equal to 8192 bytes, just send it over
    if ($value_length <= 8192)
    {
      fwrite($this->sock, $request);
    }
    else
    {
      while ($value_length > 0)
      {

        // If we have more than 8192, only take what we can handle
        if ($value_length > 8192) {
          $send_size = 8192;
        }

        // Send our chunk
        fwrite($this->sock, $request, $send_size);

        // How much is left to send?
        $value_length = $value_length - $send_size;

        // Remove data sent from outgoing data
        $request = substr($request, $send_size, $value_length);

      }
    }

    // Read our request into a variable
    $return = $this->_read_request();

    // Clear the socket so no data remains in the buffer
    $this->_clear_socket();

    return $return;
  }

  /**
   * Read request
   *
   * Route each response to the appropriate interpreter
   * @return   mixed
   */
  private function _read_request()
  {
    $type = fgetc($this->sock);

    // Times we will attempt to trash bad data in search of a
    // valid type indicator
    $response_types = array('+', '-', ':', '$', '*');
    $type_error_limit = 50;
    $try = 0;

    while ( ! in_array($type, $response_types) && $try < $type_error_limit)
    {
      $type = fgetc($this->sock);
      $try++;
    }

    if ($this->debug === TRUE)
    {
      log_message('debug', 'Redis response type: ' . $type);
    }

    switch ($type)
    {
      case '+':
        return $this->_single_line_reply();
        break;
      case '-':
        return $this->_error_reply();
        break;
      case ':':
        return $this->_integer_reply();
        break;
      case '$':
        return $this->_bulk_reply();
        break;
      case '*':
        return $this->_multi_bulk_reply();
        break;
      default:
        return FALSE;
    }

  }

  /**
   * Single line reply
   *
   * Reads the reply before the EOF
   * @return   mixed
   */
  private function _single_line_reply()
  {
    $value = rtrim(fgets($this->sock));
        $this->_clear_socket();

    return $value;
  }

  /**
   * Error reply
   *
   * Write error to log and return false
   * @return   bool
   */
  private function _error_reply()
  {
    // Extract the error message
    $error = substr(rtrim(fgets($this->sock)), 4);

    log_message('error', 'Redis server returned an error: ' . $error);
        $this->_clear_socket();

    return FALSE;
  }

  /**
   * Integer reply
   *
   * Returns an integer reply
   * @return   int
   */
  private function _integer_reply()
  {
    return (int) rtrim(fgets($this->sock));
  }

    /**
     * Bulk reply
     *
     * Reads to amount of bits to be read and returns value within
     * the pointer and the ending delimiter
     * @return  string
     */
    private function _bulk_reply()
    {

    // How long is the data we are reading? Support waiting for data to
    // fully return from redis and enter into socket.
        $value_length = (int) fgets($this->sock);

        if ($value_length <= 0) return NULL;

        $response = '';

    // Handle reply if data is less than or equal to 8192 bytes, just read it
    if ($value_length <= 8192)
    {
      $response = fread($this->sock, $value_length);
    }
    else
    {
      $data_left = $value_length;

        // If the data left is greater than 0, keep reading
            while ($data_left > 0 ) {

        // If we have more than 8192, only take what we can handle
        if ($data_left > 8192)
        {
          $read_size = 8192;
        }
        else
        {
          $read_size = $data_left;
        }

        // Read our chunk
        $chunk = fread($this->sock, $read_size);

        // Support reading very long responses that don't come through
        // in one fread

        $chunk_length = strlen($chunk);
        while ($chunk_length < $read_size)
        {
          $keep_reading = $read_size - $chunk_length;
          $chunk .= fread($this->sock, $keep_reading);
          $chunk_length = strlen($chunk);
        }

        $response .= $chunk;

        // Re-calculate how much data is left to read
        $data_left = $data_left - $read_size;

      }

    }

    // Clear the socket in case anything remains in there
    $this->_clear_socket();

  return isset($response) ? $response : FALSE;
    }

  /**
   * Multi bulk reply
   *
   * Reads n bulk replies and return them as an array
   * @return   array
   */
  private function _multi_bulk_reply()
  {
    // Get the amount of values in the response
    $response = array();
    $total_values = (int) fgets($this->sock);

    // Loop all values and add them to the response array
    for ($i = 0; $i < $total_values; $i++)
    {
      // Remove the new line and carriage return before reading
      // another bulk reply
      fgets($this->sock, 2);

      // If this is a second or later pass, we also need to get rid
      // of the $ indicating a new bulk reply and its length.
      if ($i > 0)
      {
        fgets($this->sock);
        fgets($this->sock, 2);
      }

      $response[] = $this->_bulk_reply();

    }

    // Clear the socket
    $this->_clear_socket();

    return isset($response) ? $response : FALSE;
  }

  /**
   * Encode request
   *
   * Encode plain-text request to Redis protocol format
   * @link   http://redis.io/topics/protocol
   * @param   string   request in plain-text
   * @param   string  additional data (string or array, depending on the request)
   * @return   string   encoded according to Redis protocol
   */
  private function _encode_request($method, $arguments = array())
  {
      $request = '$' . strlen($method) . self::CRLF . $method . self::CRLF;
      $_args = 1;

      // Append all the arguments in the request string
      foreach ($arguments as $argument)
      {
          if (is_array($argument))
          {
              foreach ($argument as $key => $value)
              {
                  // Prepend the key if we're dealing with a hash
                  if (!is_int($key))
                  {
                      $request .= '$' . strlen($key) . self::CRLF . $key . self::CRLF;
                      $_args++;
                  }

                  $request .= '$' . strlen($value) . self::CRLF . $value . self::CRLF;
                  $_args++;
              }
          }
          else
          {
              $request .= '$' . strlen($argument) . self::CRLF . $argument . self::CRLF;
              $_args++;
          }
      }

      $request = '*' . $_args . self::CRLF . $request;

      //var_dump($request); // DEBUG
      return $request;
  }

  /**
   * Destructor
   *
   * Kill the connection
   * @return   void
   */
  function __destruct()
  {
    if ($this->sock) 
      @fclose($this->sock);
  }
}
