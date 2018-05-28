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
 * @since 		2.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('minify_html'))
{
	/**
	 * minify_html
	 *
	 * This function is useful if you want to compress the final output.
	 * To use it, simply enable hooks and add the following lines to
	 * your application hooks.php file.
	 *
	 * @example
	 *
	 *		$hook['display_override'][] = array(
	 *			'class' => '',
	 *			'function' => 'minify_html',
	 *			'filename' => 'minify_html.php',
	 *			'filepath' => 'hooks'
	 *		);
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @param 	none
	 * @return 	void
	 */
	function minify_html()
	{
        $CI =& get_instance();
        $buffer = $CI->output->get_output();

        if (false === strpos($CI->uri->uri_string(), 'admin/load/'))
        {
	        $re = '%            # Collapse ws everywhere but in blacklisted elements.
	            (?>             # Match all whitespans other than single space.
	              [^\S ]\s*     # Either one [\t\r\n\f\v] and zero or more ws,
	            | \s{2,}        # or two or more consecutive-any-whitespace.
	            ) # Note: The remaining regex consumes no text at all...
	            (?=             # Ensure we are not in a blacklist tag.
	              (?:           # Begin (unnecessary) group.
	                (?:         # Zero or more of...
	                  [^<]++    # Either one or more non-"<"
	                | <         # or a < starting a non-blacklist tag.
	                            # Skip Script and Style Tags
	                  (?!/?(?:textarea|pre|script|style)\b)
	                )*+         # (This could be "unroll-the-loop"ified.)
	              )             # End (unnecessary) group.
	              (?:           # Begin alternation group.
	                <           # Either a blacklist start tag.
	                            # Dont foget the closing tags 
	                (?>textarea|pre|script|style)\b
	              | \z          # or end of file.
	              )             # End alternation group.
	            )  # If we made it here, we are not in a blacklist tag.
	            %ix';
	        $buffer = preg_replace($re, '', $buffer);
        }

        $CI->output->set_output($buffer);
        $CI->output->_display();
    }
}
