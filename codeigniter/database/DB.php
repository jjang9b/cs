<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @modified  itraveler@gmail.com
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Initialize the database
 *
 * @category	Database
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 * @param 	string
 * @param 	bool	Determines if active record should be used or not
 */
function &DB($params='', $active_record_override = NULL) // modified
{
  $CI =& get_instance();
  $strInstanceIdx = 'CI_DB_'.(empty($params) ? '_DEFAULT_' : $params);

  // reuse instance case 1
  if (!isset($CI->__instances)) 
    $CI->__instances = array();
  else if (isset($CI->__instances[$strInstanceIdx]) && $CI->__instances[$strInstanceIdx])
    return $CI->__instances[$strInstanceIdx];

	if (is_string($params) AND strpos($params, '://') === FALSE)
	{
    // Is the config file in the environment folder?
    if ( ! defined('ENVIRONMENT') OR ! file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/database.php'))
    {
      if ( ! file_exists($file_path = APPPATH.'config/database.php'))
      {
        show_error('The configuration file database.php does not exist.');
      }
    }

    include($file_path);

    // reuse instance case 2
    if (empty($params))
    {
      if (isset($active_group) && isset($CI->__instances['CI_DB_'.$active_group]) && $CI->__instances['CI_DB_'.$active_group]) // 'active_group' -> ''
      {
        $CI->__instances['CI_DB__DEFAULT_'] = &$CI->__instances['CI_DB_'.$active_group];
        return $CI->__instances['CI_DB__DEFAULT_'];
      }
    }
    else 
    {
      if (isset($active_group) && $params == $active_group && isset($CI->__instances['CI_DB__DEFAULT_']) && $CI->__instances['CI_DB__DEFAULT_']) // '' -> 'active_group' 
      {
        $CI->__instances['CI_DB_'.$active_group] = $CI->__instances['CI_DB__DEFAULT_'];
        return $CI->__instances['CI_DB__DEFAULT_'];
      }
    }

    if ( ! isset($db) OR count($db) == 0 )
      show_error('No database connection settings were found in the database config file.');

    if ($params != '')
      $active_group = $params;

    if ( ! isset($active_group) OR ! isset($db[$active_group]))
      show_error('You have specified an invalid database connection group.');

    $params = $db[$active_group];
  }
	elseif (is_string($params))
	{
		//* parse the URL from the DSN string
		// *  Database settings can be passed as discreet
		// *  parameters or as a data source name in the first
		// *  parameter. DSNs must have this prototype:
		// *  $dsn = 'driver://username:password@hostname/database';

		if (($dns = @parse_url($params)) === FALSE)
		{
			show_error('Invalid DB Connection String');
		}

		$params = array(
							'dbdriver'	=> $dns['scheme'],
							'hostname'	=> (isset($dns['host'])) ? rawurldecode($dns['host']) : '',
							'username'	=> (isset($dns['user'])) ? rawurldecode($dns['user']) : '',
							'password'	=> (isset($dns['pass'])) ? rawurldecode($dns['pass']) : '',
							'database'	=> (isset($dns['path'])) ? rawurldecode(substr($dns['path'], 1)) : ''
						);

		// were additional config items set?
		if (isset($dns['query']))
		{
			parse_str($dns['query'], $extra);

			foreach ($extra as $key => $val)
			{
				// booleans please
				if (strtoupper($val) == "TRUE")
				{
					$val = TRUE;
				}
				elseif (strtoupper($val) == "FALSE")
				{
					$val = FALSE;
				}

				$params[$key] = $val;
			}
		}
	}

  //echo "Creating new db instance<br>"; // DEBUG

	// No DB specified yet?  Beat them senseless...
	if ( ! isset($params['dbdriver']) OR $params['dbdriver'] == '')
	{
		show_error('You have not selected a database type to connect to.');
	}

	// Load the DB classes.  Note: Since the active record class is optional
	// we need to dynamically create a class that extends proper parent class
	// based on whether we're using the active record class or not.
	// Kudos to Paul for discovering this clever use of eval()

	if ($active_record_override !== NULL)
	{
		$active_record = $active_record_override;
	}

	require_once(BASEPATH.'database/DB_driver.php');

	if ( ! isset($active_record) OR $active_record == TRUE)
	{
		require_once(BASEPATH.'database/DB_active_rec.php');

		if ( ! class_exists('CI_DB'))
		{
			eval('class CI_DB extends CI_DB_active_record { }');
		}
	}
	else
	{
		if ( ! class_exists('CI_DB'))
		{
			eval('class CI_DB extends CI_DB_driver { }');
		}
	}

	require_once(BASEPATH.'database/drivers/'.$params['dbdriver'].'/'.$params['dbdriver'].'_driver.php');

	// Instantiate the DB adapter
	$driver = 'CI_DB_'.$params['dbdriver'].'_driver';
	$DB = new $driver($params);

  $CI->__instances[$strInstanceIdx] = $DB;

	if ($DB->autoinit == TRUE)
	{
		$DB->initialize();
	}

	if (isset($params['stricton']) && $params['stricton'] == TRUE)
	{
		$DB->query('SET SESSION sql_mode="STRICT_ALL_TABLES"');
	}

	return $DB;
}



/* End of file DB.php */
/* Location: ./system/database/DB.php */
