<?php
/**
 * CodeIgniter Skeleton
 *
 * A ready-to-use CodeIgniter skeleton  with tons of new features
 * and a whole new concept of hooks (actions and filters) as well
 * as a ready-to-use and application-free theme and plugins system.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2018, Kader Bouyakoub <bkader[at]mail[dot]com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package 	CodeIgniter
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @copyright	Copyright (c) 2018, Kader Bouyakoub <bkader[at]mail[dot]com>
 * @license 	http://opensource.org/licenses/MIT	MIT License
 * @link 		https://goo.gl/wGXHO9
 * @since 		1.5.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Jquery_validation Class
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Libraries
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.5.0
 * @version 	2.0.0
 */
class Jquery_validation {

	/**
	 * Instance of CI object.
	 * @var object
	 */
	private $_ci;

	/**
	 * Array of CI rules.
	 * @var array
	 */
	private $_ci_rules;

	/**
	 * Array of rules to use with jQuery validation.
	 * @var array
	 */
	private $_rules;

	/**
	 * Array of messages attached to each form field.
	 * @var array
	 */
	private $_messages;

	/**
	 * Array of CI rules and their equivalent on jQuery rules.
	 * @var array
	 */
	private $_js_rules = array(
		'alpha'                 => 'lettersonly',
		'alpha_dash'            => 'nowhitespace',
		'alpha_numeric'         => 'alphanumeric',
		'differs'               => 'notEqualTo',
		'exact_length'          => 'exactlength',
		'greater_than'          => 'min',
		'greater_than_equal_to' => 'min',
		'integer'               => 'integer',
		'is_natural'            => 'integer',
		'less_than'             => 'max',
		'less_than_equal_to'    => 'max',
		'matches'               => 'equalTo',
		'max_length'            => 'maxlength',
		'min_length'            => 'minlength',
		'numeric'               => 'digits',
		'regex_match'           => 'pattern',
		'required'              => 'required',
		'valid_email'           => 'email',
		'valid_url'             => 'url',
	);

	// ------------------------------------------------------------------------

	/**
	 * __construct
	 *
	 * Simply so we can hold the CI object.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.5.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function __construct()
	{
		$this->_ci =& get_instance();
	}

	// ------------------------------------------------------------------------

	/**
	 * run
	 *
	 * Uses the "_output" method to build the final script and return it
	 * for later use.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.5.0
	 *
	 * @access 	public
	 * @param 	string 	$form 			The form to target (jQuery selector).
	 * @param 	string 	$filter 		String appended to filters names.
	 * @return 	string
	 */
	public function run($form = null, $filter = null)
	{
		return $this->_output($form, $filter);
	}

	// ------------------------------------------------------------------------

	/**
	 * set_rules
	 *
	 * Method for settings rules for jQuery validation just like setting rules
	 * for CodeIgniter form validation.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.5.0
	 *
	 * @access 	public
	 * @param 	array
	 * @return 	Jquery_validation
	 */
	public function set_rules($rules = array()) 
	{
		$json_rules = array();

		if ( ! empty($rules))
		{
			$this->_ci_rules = $rules;
			foreach ($rules as $i => $single)
			{
				// Explode CI rules.
				$exp_rules = explode('|', $single['rules']);

				foreach ($exp_rules as $index => $rule)
				{
					if (preg_match("/(.*?)\[(.*)\]/", $rule, $match) 
						&& false !== $this->_valid_rule($match[1]))
					{
						$json_rules[$single['field']][$this->_js_rule($match[1])] = (in_array($match[1], array('matches', 'differs')))
							? '[name='.$match[2].']'
							: $match[2];
					}
					elseif ( ! preg_match("/callback\_/", $rule) 
						&& false !== $this->_valid_rule($rule))
					{
						$json_rules[$single['field']][$this->_js_rule($rule)] = true;
					}
				}
			}
		}

		$this->_rules = json_encode($json_rules);
		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * set_messages
	 *
	 * Method for setting custom error messages on each rule for the jQuery
	 * validation plugin.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.5.0
	 *
	 * @access 	public
	 * @param 	array
	 * @return 	Jquery_validation
	 */
	public function set_messages($messages = array()) 
	{
		$_messages = array();

		if ( ! empty($messages))
		{
			// We check and convert CI rules to jQuery rules.
			foreach ($messages as $field => $msgs)
			{
				foreach ($msgs as $rule => $msg)
				{
					// Only if available.
					if (true === $this->_valid_rule($rule))
					{
						$_messages[$field][$this->_js_rule($rule)] = $msg;
					}
				}
			}
		}
		
		$this->_messages = $_messages;
		return $this;
	}

	// ------------------------------------------------------------------------
	// Private methods.
	// ------------------------------------------------------------------------

	/**
	 * _set_messages
	 *
	 * Method for generating validation messages if none were provided.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.5.0
	 *
	 * @access 	private
	 * @param 	none
	 * @return 	string
	 */
	private function _set_messages()
	{
		// Prepare the array of validation rules.
		$messages = array();

		if ( ! empty($this->_rules))
		{
			$this->_ci->load->language('form_validation');

			$_rules = json_decode($this->_rules);

			foreach ($_rules as $key => $rules)
			{
				$field = $this->_get_field_name($key);
				
				foreach ($rules as $rule => $param)
				{
					// Remove the selector when using equalTo.
					if (in_array($rule, array('equalTo', 'notEqualTo')) 
						&& (false !== strpos($param, '[name=')))
					{
						$param = rtrim(str_replace('[name=', '', $param), ']');
						$param = $this->_get_field_name($param);
					}

					if (false === ($line = $this->_get_field_error($key, $rule)))
					{
						$line = $this->_ci->lang->line('form_validation_'.$this->_ci_rule($rule));
					}
					
					$line = (false !== strpos($line, '%s'))
						? sprint($line, $field, $param)
						: str_replace(array('{field}', '{param}'), array($field, $param), $line);

					$messages[$key][$rule] = $line;
				}
			}
		}

		(is_array($this->_messages)) OR $this->_messages = (array) $this->_messages;
		$this->_messages = array_replace_recursive($messages, $this->_messages);
	}

	// ------------------------------------------------------------------------

	/**
	 * _valid_rule
	 *
	 * Method for checking whether the CI rule has an equivalent for jQuery.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.5.0
	 *
	 * @access 	private
	 * @param 	string 	$rule 	The CI rule to check.
	 * @return 	bool 	true if the equivalent if found, else false.
	 */
	private function _valid_rule($rule) 
	{
		return (false !== in_array($rule, array_keys($this->_js_rules)));
	}

	// ------------------------------------------------------------------------

	/**
	 * _js_rule
	 *
	 * Method for returning the jQuery rule from CI rule.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.5.0
	 *
	 * @access 	private
	 * @param 	string
	 * @return 	string
	 */
	private function _js_rule($rule)
	{
		return (isset($this->_js_rules[$rule])) ? $this->_js_rules[$rule] : null;
	}

	// ------------------------------------------------------------------------

	/**
	 * _ci_rule
	 *
	 * Method for returning the CI rule from jQuery rule.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.5.0
	 *
	 * @access 	private
	 * @param 	string
	 * @return 	string
	 */
	private function _ci_rule($rule)
	{
		return array_search($rule, $this->_js_rules);
	}

	// ------------------------------------------------------------------------

	/**
	 * _get_field_name
	 *
	 * Method for getting the field name from the rules array
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.5.0
	 *
	 * @access 	private
	 * @param 	string
	 * @return 	string
	 */
	private function _get_field_name($field)
	{
		// Initial name.
		$name = $field;

		if ( ! empty($this->_ci_rules))
		{
			foreach ($this->_ci_rules as $single)
			{
				// Found? Set it.
				if (isset($single['label']) && $field === $single['field'])
				{
					$name = $single['label'];
					break;
				}
			}
		}

		// Does the field name need to be translated?
		if (sscanf($name, 'lang:%s', $line) === 1)
		{
			$name = $this->_ci->lang->line($line);
		}

		// Return the final result.
		return $name;
	}

	// ------------------------------------------------------------------------

	/**
	 * _get_field_error
	 *
	 * Method for returning the custom field error.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.5.0
	 *
	 * @access 	private
	 * @param 	string 	$field 	The field to check.
	 * @param 	string 	$rule 	The rule to get the error for.
	 * @return 	string
	 */
	private function _get_field_error($field, $rule)
	{
		// Initial error.
		$error = false;
		
		if ( ! empty($this->_ci_rules))
		{
			foreach ($this->_ci_rules as $single)
			{
				// Found any? Set it and stop the loop.
				if ($field === $single['field'] && isset($single['errors'][$rule]))
				{
					$error = $single['errors'][$rule];
					break;
				}
			}
		}

		// Does the error need to be translated?
		if (sscanf($error, 'lang:%s', $line) === 1)
		{
			$error = $this->_ci->lang->line($line);
		}

		// Return the final result.
		return $error;
	}

	// ------------------------------------------------------------------------

	/**
	 * _output
	 *
	 * Method for building the final jQuery validation string.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.5.0
	 *
	 * @access 	private
	 * @param 	string 	$form 		The jQuery select for the form.
	 * @param 	string 	$filter 	String appended to applied filters.
	 * @return 	string
	 */
	private function _output($form = null, $filter = null)
	{
		empty($form) && $form = 'form';

		// Allow only ID and class selectors.
		if (false === strpos($form, '.') && false === strpos($form, '#'))
		{
			return;
		}

		empty($filter) OR $filter = '-'.$filter;

		// Default jQuery validate params.

		/**
		 * Callback for handling the actual submit when the form is valid.
		 * Default: native form submit.
		 * @see 	https://jqueryvalidation.org/validate/#submithandler
		 * @var 	string (function)
		 */
		$jqv_submitHandler = null;

		/**
		 * Callback for custom code when an invalid form is submitted.
		 * @see 	https://jqueryvalidation.org/validate/#submithandler
		 * @var 	string (function)
		 */
		$jqv_invalidHandler = null;

		/**
		 * Elements to ignore when validating, simply filtering them out.
		 * Default: ":hidden".
		 * @see 	https://jqueryvalidation.org/validate/#submithandler
		 * @var 	string (selector)
		 */
		$jqv_ignore = null;

		/**
		 * Key/value pairs defining custom rules.
		 * @see 	https://jqueryvalidation.org/validate/#rules
		 * @var 	array (object)
		 */
		$jqv_rules = $this->_rules;

		/**
		 * Key/value pairs defining custom messages.
		 * @see 	https://jqueryvalidation.org/validate/#messages
		 * @var 	string (JSON encode array).
		 */
		$this->_set_messages();
		$jqv_messages = json_encode($this->_messages);

		/**
		 * Specify grouping of error messages. A group consists of an 
		 * arbitrary group name as the key and a space separated list of 
		 * element names as the value.
		 * @see 	https://jqueryvalidation.org/validate/#groups
		 * @var 	array (object)
		 */
		$jqv_groups = array();

		/**
		 * Prepares/transforms the elements value for validation.
		 * @see 	https://jqueryvalidation.org/validate/#normalizer
		 * @var 	string (function)
		 */
		$jqv_normalizer = null;

		/**
		 * Validate the form on submit. Set to false to use only other 
		 * events for validation.
		 * @see 	https://jqueryvalidation.org/validate/#onsubmit
		 * @var 	boolean or string (function)
		 */
		$jqv_onsubmit = true;

		/**
		 * Validate elements (except checkboxes/radio buttons) on blur.
		 * @see 	https://jqueryvalidation.org/validate/#onfocusout
		 * @var 	boolean or string (function)
		 */
		$jqv_onfocusout = null;

		/**
		 * Validate elements on keyup. As long as the field is not marked 
		 * as invalid, nothing happens.
		 * @see 	https://jqueryvalidation.org/validate/#onkeyup
		 * @var 	boolean or string (function)
		 */
		$jqv_onkeyup = null;

		/**
		 * Validate checkboxes, radio buttons, and select elements on click.
		 * Set to false to disable.
		 * @see 	https://jqueryvalidation.org/validate/#onclick
		 * @var 	boolean or string (function)
		 */
		$jqv_onclick = null;

		/**
		 * Focus the last active or first invalid element on submit via 
		 * validator.focusInvalid(). Default: true.
		 * @see 	https://jqueryvalidation.org/validate/#focusinvalid
		 * @var 	boolean
		 */
		$jqv_focusInvalid = true;

		/**
		 * If enabled, removes the errorClass from the invalid elements and 
		 * hides all error messages whenever the element is focused.
		 * @see 	https://jqueryvalidation.org/validate/#focuscleanup
		 * @var 	boolean
		 */
		$jqv_focusCleanup = false;

		/**
		 * Use this class to create error labels, to look for existing error 
		 * labels and to add it to invalid elements. Default: "error".
		 * @see 	https://jqueryvalidation.org/validate/#errorclass
		 * @var 	string
		 */
		$jqv_errorClass = 'is-invalid';

		/**
		 * This class is added to an element after it was validated and 
		 * considered valid. Default: "valid".
		 * @see 	https://jqueryvalidation.org/validate/#errorclass
		 * @var 	string
		 */
		$jqv_validClass = 'is-valid';

		/**
		 * Use this element type to create error messages and to look
		 * for existing error messages. Default: "label".
		 * @see 	https://jqueryvalidation.org/validate/#errorelement
		 * @var  	string
		 */
		$jqv_errorElement = 'div';

		/**
		 * Wrap error labels with the specified element. Useful in combination with 
		 * errorLabelContainer to create a list of error messages. Default: "window".
		 * @see 	https://jqueryvalidation.org/validate/#wrapper
		 * @var 	string
		 */
		$jqv_wrapper = 'window';

		/**
		 * Hide and show this container when validating.
		 * @see 	https://jqueryvalidation.org/validate/#errorlabelcontainer
		 * @var 	string (selector)
		 */
		$jqv_errorLabelContainer = null;

		/**
		 * Hide and show this container when validating.
		 * @see 	https://jqueryvalidation.org/validate/#errorcontainer
		 * @var 	string (selector)
		 */
		$jqv_errorContainer = null;

		/**
		 * A custom message display handler. Gets the map of errors as the first 
		 * argument and an array of errors as the second, called in the context of 
		 * the validator object.
		 * @see 	https://jqueryvalidation.org/validate/#showerrors
		 * @var 	string (function)
		 */
		$jqv_showErrors = null;

		/**
		 * Customize placement of created error labels.
		 * First argument: The created error label as a jQuery object.
		 * Second argument: The invalid element as a jQuery object.
		 * @see 	https://jqueryvalidation.org/validate/#errorplacement
		 * @var 	string (function)
		 */
		$jqv_errorPlacement = 'function (error, element) { error.addClass("invalid-feedback"); element.parents(".form-group").find(".invalid-feedback").remove(); if (element.prop("type") === "checkbox") { error.insertAfter(element.parent("label")); } else { error.insertAfter(element); } }';

		/**
		 * If specified, the error label is displayed to show a valid element.
		 * @see 	https://jqueryvalidation.org/validate/#success
		 * @var 	string (string or function)
		 */
		$jqv_success = null;

		/**
		 * How to highlight invalid fields. Override to decide which fields 
		 * and how to highlight. Default: adds errorClass to element.
		 * @see 	https://jqueryvalidation.org/validate/#highlight
		 * @var 	string (function)
		 */
		$jqv_highlight = 'function (element, errorClass, validClass) { $(element).addClass("is-invalid").removeClass("is-valid"); }';
		
		/**
		 * Called to revert changes made by option highlight, same arguments as highlight.
		 * @see 	https://jqueryvalidation.org/validate/#unhighlight
		 * @var 	string (function)
		 */
		$jqv_unhighlight = 'function (element, errorClass, validClass) { $(element).addClass("is-valid").removeClass("is-invalid"); }';

		/**
		 * Set to skip reading messages from the title attribute, helps to avoid 
		 * issues with Google Toolbar. Default: false for compatibility.
		 * @see 	https://jqueryvalidation.org/validate/#ignoretitle
		 * @var 	boolean
		 */
		$jqv_ignoreTitle  = false;

		/**
		 * Filters are ignored on the dashboard.
		 * @since 	2.0.0
		 */
		if (true !== $this->_ci->router->is_admin())
		{
			$jqv_submitHandler       = apply_filters('jquery_validate_submitHandler'.$filter, $jqv_submitHandler);
			$jqv_invalidHandler      = apply_filters('jquery_validate_invalidHandler'.$filter, $jqv_invalidHandler);
			$jqv_ignore              = apply_filters('jquery_validate_ignore'.$filter, $jqv_ignore);
			$jqv_groups              = apply_filters('jquery_validate_groups'.$filter, $jqv_groups);
			$jqv_normalizer          = apply_filters('jquery_validate_normalizer'.$filter, $jqv_normalizer);
			$jqv_onsubmit            = apply_filters('jquery_validate_onsubmit'.$filter, $jqv_onsubmit);
			$jqv_onfocusout          = apply_filters('jquery_validate_onfocusout'.$filter, $jqv_onfocusout);
			$jqv_onkeyup             = apply_filters('jquery_validate_onkeyup'.$filter, $jqv_onkeyup);
			$jqv_onclick             = apply_filters('jquery_validate_onclick'.$filter, $jqv_onclick);
			$jqv_focusInvalid        = apply_filters('jquery_validate_focusInvalid'.$filter, $jqv_focusInvalid);
			$jqv_focusCleanup        = apply_filters('jquery_validate_focusCleanup'.$filter, $jqv_focusCleanup);
			$jqv_errorClass          = apply_filters('jquery_validate_errorClass'.$filter, $jqv_errorClass);
			$jqv_validClass          = apply_filters('jquery_validate_validClass'.$filter, $jqv_validClass);
			$jqv_errorElement        = apply_filters('jquery_validate_errorElement'.$filter, $jqv_errorElement);
			$jqv_wrapper             = apply_filters('jquery_validate_wrapper'.$filter, $jqv_wrapper);
			$jqv_errorLabelContainer = apply_filters('jquery_validate_errorLabelContainer'.$filter, $jqv_errorLabelContainer);
			$jqv_errorContainer      = apply_filters('jquery_validate_errorContainer'.$filter, $jqv_errorContainer);
			$jqv_showErrors          = apply_filters('jquery_validate_showErrors'.$filter, $jqv_showErrors);
			$jqv_errorPlacement      = apply_filters('jquery_validate_errorPlacement'.$filter, $jqv_errorPlacement);
			$jqv_success             = apply_filters('jquery_validate_success'.$filter, $jqv_success);
			$jqv_highlight           = apply_filters('jquery_validate_highlight'.$filter, $jqv_highlight);
			$jqv_unhighlight         = apply_filters('jquery_validate_unhighlight'.$filter, $jqv_unhighlight);
			$jqv_ignoreTitle         = apply_filters('jquery_validate_ignoreTitle'.$filter, $jqv_ignoreTitle);
		}

		// Prepare the final output.
		$output = '<script type="text/javascript">';
		$output .= '$(document).ready(function () {';
		$output .= 'var $form = $("'.$form.'");';

		/**
		 * We proceed to validation only if the form is found.
		 * @since 	2.0.0
		 */
		$output .= ' if (typeof $form === "undefined" || !$form.length) { return false; }';

		$output .= ' $form.validate({';

		// We start by adding rules and messages.
		$output .= 'rules: '.$jqv_rules;
		$output .= ', messages: '.$jqv_messages;

		if (null !== $jqv_submitHandler)
		{
			$output .= ', submitHandler: '.$jqv_submitHandler;
		}
		if (null !== $jqv_invalidHandler)
		{
			$output .= ', invalidHandler: '.$jqv_invalidHandler;
		}
		if (null !== $jqv_ignore)
		{
			$output .= ', ignore: "'.$jqv_ignore.'"';
		}

		empty($jqv_groups) OR $output .= ', groups: '.json_encode($jqv_groups);
		(null !== $jqv_normalizer) && $output .= ', normalizer: '.$jqv_normalizer;

		if (true !== $jqv_onsubmit)
		{
			(is_bool($jqv_onsubmit)) && $jqv_onsubmit = json_encode($jqv_onsubmit);
			$output .= ', onsubmit: '.$jqv_onsubmit;
		}

		if (null !== $jqv_onfocusout)
		{
			(is_bool($jqv_onfocusout)) && $jqv_onfocusout = json_encode($jqv_onfocusout);
			$output .= ', onfocusout: '.$jqv_onfocusout;
		}

		if (null !== $jqv_onkeyup)
		{
			(is_bool($jqv_onkeyup)) && $jqv_onkeyup = json_encode($jqv_onkeyup);
			$output .= ', onkeyup: '.$jqv_onkeyup;
		}

		if (null !== $jqv_onclick)
		{
			(is_bool($jqv_onclick)) && $jqv_onclick = json_encode($jqv_onclick);
			$output .= ', onclick: '.$jqv_onclick;
		}

		if (true !== $jqv_focusInvalid)
		{
			(is_bool($jqv_focusInvalid)) && $jqv_focusInvalid = json_encode($jqv_focusInvalid);
			$output .= ', focusInvalid: '.$jqv_focusInvalid;
		}

		if (false !== $jqv_focusCleanup)
		{
			(is_bool($jqv_focusCleanup)) && $jqv_focusCleanup = json_encode($jqv_focusCleanup);
			$output .= ', focusCleanup: '.$jqv_focusCleanup;
		}

		empty($jqv_errorClass) OR $output .= ', errorClass: "'.$jqv_errorClass.'"';
		empty($jqv_validClass) OR $output .= ', validClass: "'.$jqv_validClass.'"';
		empty($jqv_errorElement) OR $output .= ', errorElement: "'.$jqv_errorElement.'"';
		empty($jqv_wrapper) OR $output .= ', wrapper: "'.$jqv_wrapper.'"';
		empty($jqv_errorLabelContainer) OR $output .= ', errorLabelContainer: "'.$jqv_errorLabelContainer.'"';
		empty($jqv_errorContainer) OR $output .= ', errorContainer: "'.$jqv_errorContainer.'"';
		empty($jqv_showErrors) OR $output .= ', showErrors: '.$jqv_showErrors;
		empty($jqv_errorPlacement) OR $output .= ', errorPlacement: '.$jqv_errorPlacement;
		empty($jqv_success) OR $output .= ', success: '.$jqv_success;
		empty($jqv_highlight) OR $output .= ', highlight: '.$jqv_highlight;
		empty($jqv_unhighlight) OR $output .= ', unhighlight: '.$jqv_unhighlight;

		(false !== $jqv_ignoreTitle) && $output .= ', ignoreTitle: '.json_encode($jqv_ignoreTitle);

		// Close the JS string then return it.
		$output .= '})});</script>';
		return $output;
	}

}
