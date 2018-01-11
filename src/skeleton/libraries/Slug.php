<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Slug Class
 *
 * A library to generate slugs after checking a table row.
 *
 * @package 	CodeIgniter
 * @subpackage 	Libraries
 * @category 	Libraries
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */
class Slug
{
	/**
	 * The name of the table
	 *
	 * @var string
	 */
	public $table = '';

	/**
	 * The primary id field in the table
	 *
	 * @var string
	 */
	public $id = 'id';

	/**
	 * The URI Field in the table
	 *
	 * @var string
	 */
	public $field = 'uri';

	/**
	 * The title field in the table
	 *
	 * @var string
	 */
	public $title = 'title';

	/**
	 * The replacement (Either underscore or dash)
	 *
	 * @var string
	 */
	public $replacement = 'dash';

	// ------------------------------------------------------------------------

	/**
	 * Setup all vars
	 *
	 * @param array $config
	 * @return void
	 */
	public function __construct($config = array())
	{
		$this->set_config($config);
		log_message('info', 'Slug Class Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Manually Set Config
	 *
	 * Pass an array of config vars to override previous setup
	 *
	 * @param   array
	 * @return  void
	 */
	public function set_config($config = array())
	{
		if ( ! empty($config))
		{
			foreach ($config as $key => $value)
			{
				$this->{$key} = $value;
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Create a uri string
	 *
	 * This wraps into the _check_uri method to take a character
	 * string and convert into ascii characters.
	 *
	 * @param   mixed (string or array)
	 * @param   int
	 * @uses    Slug::_check_uri()
	 * @uses    Slug::create_slug()
	 * @return  string
	 */
	public function create_uri($data = '', $id = '')
	{
		if (empty($data))
		{
			return false;
		}

		if (is_array($data))
		{
			if ( ! empty($data[$this->field]))
			{
				return $this->_check_uri($this->create_slug($data[$this->field]), $id);
			}
			elseif ( ! empty($data[$this->title]))
			{
				return $this->_check_uri($this->create_slug($data[$this->title]), $id);
			}
		}
		elseif (is_string($data))
		{
			return $this->_check_uri($this->create_slug($data), $id);
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Create Slug
	 *
	 * Returns a string with all spaces converted to underscores (by default), accented
	 * characters converted to non-accented characters, and non word characters removed.
	 *
	 * @param   string $string the string you want to slug
	 * @param   string $replacement will replace keys in map
	 * @return  string
	 */
	public function create_slug($string)
	{
		$CI =& get_instance();
		$CI->load->helper(array('url', 'text', 'string'));
		$string = strtolower(url_title(convert_accented_characters($string), $this->replacement));

		return (empty($this->_get_replacement()))
			? $string
			: reduce_multiples($string, $this->_get_replacement(), true);
	}

	// ------------------------------------------------------------------------

	/**
	 * Check URI
	 *
	 * Checks other items for the same uri and if something else has it
	 * change the name to "name-1".
	 *
	 * @param   string $uri
	 * @param   int $id
	 * @param   int $count
	 * @return  string
	 */
	private function _check_uri($uri, $id = false, $count = 0)
	{
		$CI =& get_instance();
		$new_uri = ($count > 0) ? $uri.$this->_get_replacement().$count : $uri;

		// Setup the query
		$CI->db->select($this->field)->where($this->field, $new_uri);

		if ($id)
		{
			$CI->db->where($this->id.' !=', $id);
		}

		return ($CI->db->count_all_results($this->table) > 0)
			? $this->_check_uri($uri, $id, ++$count)
			: $new_uri;
	}

	// ------------------------------------------------------------------------

	/**
	 * Get the replacement type
	 *
	 * Either a dash or underscore generated off the term.
	 *
	 * @return string
	 */
	private function _get_replacement()
	{
		switch ($this->replacement)
		{
			case 'dash':
			case '-':
				return '-';
				break;

			case 'underscore':
			case '_':
				return '_';
				break;

			default:
				return $this->replacement;
				break;
		}
	}
}
