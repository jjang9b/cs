<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * MySQLi Result Class
 *
 * This class extends the parent result class: CI_DB_result
 *
 * @category	Database
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 */
class CI_DB_mysqli_result extends CI_DB_result {

	/**
	 * Number of rows in the result set
	 *
	 * @access	public
	 * @return	integer
	 */
	function num_rows()
	{
    @mysqli_stmt_store_result($this->prepare_statement);
		return @mysqli_stmt_num_rows($this->prepare_statement);
	}

	// --------------------------------------------------------------------

	/**
	 * Number of fields in the result set
	 *
	 * @access	public
	 * @return	integer
	 */
	function num_fields()
	{
		return @mysqli_stmt_field_count($this->prepare_statement);
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch Field Names
	 *
	 * Generates an array of column names
	 *
	 * @access	public
	 * @return	array
	 */
	function list_fields()
	{
    return $this->_get_field_name();
	}

	// --------------------------------------------------------------------

	/**
	 * Field data
	 *
	 * Generates an array of objects containing field meta-data
	 *
	 * @access	public
	 * @return	array
	 */
	function field_data()
	{
		$retval = array();

    if($this->prepare_statement)
    {
      if ($result_metadata = mysqli_stmt_result_metadata($this->prepare_statement))
      {
        $field_info_all = mysqli_fetch_fields($result_metadata);
        
        if (isset($field_info_all) && is_array($field_info_all))
        {
          /*
              [0] => stdClass Object
                        (
                      [name] => usn
                      [orgname] => usn
                      [table] => member
                      [orgtable] => member
                      [def] => 
                      [db] => test
                      [catalog] => def
                      [max_length] => 0
                      [length] => 10
                      [charsetnr] => 63
                      [flags] => 49699
                      [type] => 3
                      [decimals] => 0
                    ) 
          */

          // ### field_info->type ###
          //   3    -    Int
          //  10    -    Date
          // 246    -    Decimal
          // 252    -    Text
          // 253    -    VarChar
          // 254    -    Boolean

          // ### field_info->flags ###
          // NOT_NULL_FLAG          1         // Field can't be NULL
          // PRI_KEY_FLAG           2         // Field is part of a primary key
          // UNIQUE_KEY_FLAG        4         // Field is part of a unique key
          // MULTIPLE_KEY_FLAG      8         // Field is part of a key
          // BLOB_FLAG             16         // Field is a blob
          // UNSIGNED_FLAG         32         // Field is unsigned
          // ZEROFILL_FLAG         64         // Field is zerofill
          // BINARY_FLAG          128         // Field is binary
          // ENUM_FLAG            256         // field is an enum
          // AUTO_INCREMENT_FLAG  512         // field is a autoincrement field
          // TIMESTAMP_FLAG      1024         // Field is a timestamp
          foreach ($field_info_all as $field_info)
          {
            $F = new stdClass();
            $F->name = $field_info->name;
            $F->type = $field_info->type;
            $F->default = $field_info->def;
            $F->max_length = $field_info->length;
            $F->primary_key = ( $field_info->flags & 2 ? 1 : 0 );
            $F->flags = $field_info->flags; // added 

            $retval[] = $F;
          }
        }
      }
    }

		return $retval;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Free the result
	 *
	 * @return	null
	 */
	function free_result()
	{
    if ($this->prepare_statement !== false)
		{
			mysqli_stmt_free_result($this->prepare_statement);
			$this->prepare_statement = FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Data Seek
	 *
	 * Moves the internal pointer to the desired offset.  We call
	 * this internally before fetching results to make sure the
	 * result set starts at zero
	 *
	 * @access	private
	 * @return	array
	 */
	function _data_seek($n = 0)
	{
		return mysqli_stmt_data_seek($this->prepare_statement, $n);
	}

	// --------------------------------------------------------------------

	/**
	 * Result - associative array
	 *
	 * Returns the result set as an array
	 *
	 * @access	private
	 * @return	array
	 */
	function _fetch_assoc()
	{
    $result = array();
    if(isset($this->prepare_statement))
    {
      $field_names = $this->_get_field_name();

      $bind_result = array();
      $bind_param = array($this->prepare_statement);
      foreach ($field_names as $cur_field_name)
      {
        $bind_result[$cur_field_name] = '';
        $bind_param[$cur_field_name] = &$bind_result[$cur_field_name];
      }

      call_user_func_array('mysqli_stmt_bind_result', $bind_param);

      $i = 0;
      while (mysqli_stmt_fetch($this->prepare_statement))
      {
        $result[$i] = array(); // diff line
        foreach ($bind_result as $key => $val)
        {
          $result[$i][$key] = $val; // diff line
        }
        $i++;
      }
    }
    else
    {
      //echo 'not prepared!';
    }

    return $result;
	}

	// --------------------------------------------------------------------

  function _get_field_name()
  {
    if (isset($this->field_names))
      return $this->field_names;

    if($this->prepare_statement)
    {
      if ($result_metadata = mysqli_stmt_result_metadata($this->prepare_statement))
      {
        $field_names = mysqli_fetch_fields($result_metadata);
        
        if (isset($field_names) && is_array($field_names))
        {
          $this->field_names = array();
          foreach ($field_names as $cur_field_name)
            $this->field_names[] = $cur_field_name->name;

          return $this->field_names;
        }
      }
    }

    return array();
  }

	/**
	 * Result - object
	 *
	 * Returns the result set as an object
	 *
	 * @access	private
	 * @return	object
	 */
	function _fetch_object()
	{
    $result = array();
    if(isset($this->prepare_statement))
    {
      $field_names = $this->_get_field_name();

      $bind_result = array();
      $bind_param = array($this->prepare_statement);
      foreach ($field_names as $cur_field_name)
      {
        $bind_result[$cur_field_name] = '';
        $bind_param[$cur_field_name] = &$bind_result[$cur_field_name];
      }

      call_user_func_array('mysqli_stmt_bind_result', $bind_param);

      $i = 0;
      while (mysqli_stmt_fetch($this->prepare_statement))
      {
        $result[$i] = new \stdClass;
        foreach ($bind_result as $key => $val)
        {
          $result[$i]->{$key} = $val;
        }
        $i++;
      }
    }
    else
    {
      //echo 'not prepared!';
    }

    return $result;
	}

	public function result_object()
	{
		if (count($this->result_object) > 0)
		{
			return $this->result_object;
		}

    /*
		// In the event that query caching is on the result_id variable
		// will return FALSE since there isn't a valid SQL resource so
		// we'll simply return an empty array.
		if ($this->result_id === FALSE OR $this->num_rows() == 0)
		{
			return array();
		}
    */

		$this->_data_seek(0);
		$this->result_object = $this->_fetch_object();

		return $this->result_object;
	}

	public function result_array()
	{
		if (count($this->result_array) > 0)
		{
			return $this->result_array;
		}

    /*
		// In the event that query caching is on the result_id variable
		// will return FALSE since there isn't a valid SQL resource so
		// we'll simply return an empty array.
		if ($this->result_id === FALSE OR $this->num_rows() == 0)
		{
			return array();
		}
    */

		$this->_data_seek(0);
		$this->result_array = $this->_fetch_assoc();

		return $this->result_array;
	}

}

/* End of file mysqli_result.php */
/* Location: ./system/database/drivers/mysqli/mysqli_result.php */
