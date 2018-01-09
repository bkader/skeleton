<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Extending CodeIgniter CI_Input Class
 *
 * @package 	CodeIgniter
 * @category 	Core Extension
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */
class KB_Input extends CI_Input
{
	/**
	 * Fetch an item from the REQUEST array
	 *
	 * @param	mixed	$index		Index for item to be fetched from $_GET
	 * @param	bool	$xss_clean	Whether to apply XSS filtering
	 * @return	mixed
	 */
	public function request($index = null, $xss_clean = null)
	{
		return $this->_fetch_from_array($_REQUEST, $index, $xss_clean);
	}

}
