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
 * Copyright (c) 2018, Kader Bouyakoub <bkader@mail.com>
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
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @copyright	Copyright (c) 2018, Kader Bouyakoub <bkader@mail.com>
 * @license 	http://opensource.org/licenses/MIT	MIT License
 * @link 		https://goo.gl/wGXHO9
 * @since 		2.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Bootstrap File.
 *
 * This file registers Skeleton classes to they can easily loaded/extended.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Autoloader
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */

/**
 * Array of our classes.
 * @var array
 */
$classes = array(
	// Core classes.
	'Admin_Controller'   => KBPATH.'core/Admin_Controller.php',
	'AJAX_Controller'    => KBPATH.'core/AJAX_Controller.php',
	'KB_Controller'      => KBPATH.'core/KB_Controller.php',
	'KB_Config'          => KBPATH.'core/KB_Config.php',
	'KB_Hooks'           => KBPATH.'core/KB_Hooks.php',
	'KB_Input'           => KBPATH.'core/KB_Input.php',
	'KB_Lang'            => KBPATH.'core/KB_Lang.php',
	'KB_Loader'          => KBPATH.'core/KB_Loader.php',
	'KB_Model'           => KBPATH.'core/KB_Model.php',
	'KB_Security'        => KBPATH.'core/KB_Security.php',
	'KB_Router'          => KBPATH.'core/KB_Router.php',
	'Process_Controller' => KBPATH.'core/Process_Controller.php',
	'User_Controller'    => KBPATH.'core/User_Controller.php',
	'API_Controller'     => KBPATH.'core/API_Controller.php',

	// Libraries.
	'Bcrypt'             => KBPATH.'libraries/Bcrypt.php',
	'Format'             => KBPATH.'libraries/Format.php',
	'Hash'               => KBPATH.'libraries/Hash.php',
	'Jquery_validation'  => KBPATH.'libraries/Jquery_validation.php',
	'KB_Form_validation' => KBPATH.'libraries/KB_Form_validation.php',
	'KB_Image_lib'       => KBPATH.'libraries/KB_Image_lib.php',
	'KB_Pagination'      => KBPATH.'libraries/KB_Pagination.php',
	'KB_Table'           => KBPATH.'libraries/KB_Table.php',
	'KB_Upload'          => KBPATH.'libraries/KB_Upload.php',
	'Theme'              => KBPATH.'libraries/Theme.php',

	// Main Skeleton Libraries.
	'Kbcore'            => KBPATH.'libraries/Kbcore/Kbcore.php',
	'CRUD_interface'    => KBPATH.'libraries/Kbcore/CRUD_interface.php',
	'Kbcore_activities' => KBPATH.'libraries/Kbcore/drivers/Kbcore_activities.php',
	'Kbcore_entities'   => KBPATH.'libraries/Kbcore/drivers/Kbcore_entities.php',
	'Kbcore_groups'     => KBPATH.'libraries/Kbcore/drivers/Kbcore_groups.php',
	'Kbcore_media'      => KBPATH.'libraries/Kbcore/drivers/Kbcore_media.php',
	'Kbcore_menus'      => KBPATH.'libraries/Kbcore/drivers/Kbcore_menus.php',
	'Kbcore_metadata'   => KBPATH.'libraries/Kbcore/drivers/Kbcore_metadata.php',
	'Kbcore_objects'    => KBPATH.'libraries/Kbcore/drivers/Kbcore_objects.php',
	'Kbcore_options'    => KBPATH.'libraries/Kbcore/drivers/Kbcore_options.php',
	'Kbcore_plugins'    => KBPATH.'libraries/Kbcore/drivers/Kbcore_plugins.php',
	'Kbcore_relations'  => KBPATH.'libraries/Kbcore/drivers/Kbcore_relations.php',
	'Kbcore_users'      => KBPATH.'libraries/Kbcore/drivers/Kbcore_users.php',
	'Kbcore_variables'  => KBPATH.'libraries/Kbcore/drivers/Kbcore_variables.php',
);

// Register our classes.
spl_autoload_register(function($class) use ($classes) {
	if (isset($classes[$class])) {
		require_once($classes[$class]);
	}
});

/**
 * Because this file is the first one to be loaded, we make sure
 * to load our needed resources here.
 */
require_once(KBPATH.'third_party/compat/include_with_vars.php');
require_once(KBPATH.'third_party/compat/print_d.php');
require_once(KBPATH.'third_party/compat/str_to_bool.php');
require_once(KBPATH.'third_party/compat/is_serialized.php');
require_once(KBPATH.'third_party/compat/is_json.php');
require_once(KBPATH.'third_party/compat/bool_or_serialize.php');
require_once(KBPATH.'third_party/Plugins/Plugins.php');
require_once(KBPATH.'third_party/Route/Route.php');

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 */
require_once BASEPATH.'core/CodeIgniter.php';
