# Custom Files

Several files were added to ensure the application stays on the flow.

* **Core Classes**:
	* [KB_Config.php](#kb_configphp)
	* [KB_Controller.php](#kb_controllerphp)
	* [KB_Hooks.php](#kb_hooksphp)
	* [KB_Input.php](#kb_inputphp)
	* [KB_Lang.php](#kb_langphp)
	* [KB_Loader.php](#kb_loaderphp)
	* [KB_Model.php](#kb_modelphp)
	* [KB_Router.php](#kb_routerphp)
	* [User_Controller.php](#user_controllerphp)
	* [Admin_Controller.php](#admin_controllerphp)
* **Libraries**:
	* [KB_Form_validation.php](#kb_form_validationphp)
	* [KB_Table.php](#kb_tablephp)
	* [Bcrypt.php](#bcryptphp)
	* [Format.php](#formatphp)
	* [Hash.php](#hashphp)
	* [Plugins.php](#pluginsphp)
	* [Route.php](#routephp)
	* [Theme.php](#themephp)

## KB_Config.php

At the very top of this file, we have included some of our collected custom helpers to suit our needs. So from line **#44** up to line **#48** you will find the following:

```php
require_once(KBPATH.'core/compat/print_d.php');
require_once(KBPATH.'core/compat/str_to_bool.php');
require_once(KBPATH.'core/compat/is_serialized.php');
require_once(KBPATH.'core/compat/is_json.php');
require_once(KBPATH.'core/compat/bool_or_serialize.php');
```

In the class constructor, we have added our custom path constant **KBPATH** to configurations path. So config files can be in your application folder or in the custom one. See below:

```php
public function __construct()
{
	// Our our custom config path.
	$this->_config_paths[] = KBPATH;

	// Now we call parent's constructor.
	parent::__construct();
}
```

The `set_item` is overridden on line **#89**. We are simply adding an index when setting a config item.

```php
public function set_item($item, $value = null, $index = '')
{
	if ($index == '')
	{
		$this->config[$item] = $value;
	}
	else
	{
		$this->config[$index][$item] = $value;
	}
}
```

A new method has been added, `lang` that without arguments will return the currently used language. If you pass arguments to it, it will returns the language details you want. At line **#109**:

```php
public function lang()
{
	return call_user_func_array(
		array(get_instance()->lang, 'lang'),
		func_get_args()
	);
}
```

Here is how you can use it:

```php
echo $this->config->lang(); // Outputs: "english"
print_r($this->config->lang('name', 'code', 'foler');
// Outputs: Array ( [name] => English [code] => en )
// OR as an array:
print_r($this->config->lang(array('name', 'code', 'foler')));

// And to get all language details:
print_r($this->config->lang(TRUE);
// Outputs:
// Array ( [name] => English [name_en] => English [folder] => english [locale] => en-US [direction] => ltr [code] => en [flag] => us )
```

**Note**: A method with the same name can be found in **KB_Lang.php** file. In fact, the one in **KB_Config.php** uses it.

## KB_Controller.php

If you want to fully use the skeleton, your controllers must extend this class. It contains several useful methods:

**prep_form**:
This method is a shortcut to use CodeIgniter Form validation. Here is an example of how to use it in your controller:

```php
$this->prep_form(array(
	// Field:
	array(
		'field' => 'username',
		'label' => 'Username',
		'rules' => 'required|min_length5]',
	),
));
// As you can see, we are passing validation rules as argument.
```

There are also too useful methods: `create_csrf`and `check_csrf`. The first one creates the CSRF token and the second one checks it. Here is an example of how to use them:

```php
// Create the hidden input before passing to view:
$data['hidden'] = $this->create_csrf();

// Then in your view file:
echo form_open($url, $attributes, $hidden);

// After the form is submitted, you may check the CSRf like so:
if ( ! $this->check_csrf())
{
	// Your action.
}
```

**NOTE**: Because the CSRF token is store as a flash session, it is possible to see the `check_csrf` returning `FALSE` in case you one multiple browser tabs.

If your controllers contain methods that required AJAX requests, you only need to add them to the **$ajax_methods** property.

```php
class Yours extends KB_Controller
{
	protected $ajax_methods = array('the_method');
}

// Or on your constructor.
class Yours extends KB_Controller
{
	public function __construct()
	{
		$this->ajax_methods[] = 'the_method';
		parent::__construct();
	}

	// Your method should only set header and message
	// and returns nothing.
	public function the_method()
	{
		// After your actions.
		$this->response->header = 200;
		$this->response->message = 'Your message here';
	}
}
```

... the rest will be added soon.

## KB_Hooks.php

This class is used so hooks from Skeleton folder can be used as well.

## KB_Input.php

Four (**4**) methods have been added to this class.
### 1. request

This method fetches an item from the `$_REQUEST` array.

```php
echo $this->input->request('action'); // Example only.
```

Arguments:  

- index (_string_): Index for item to be fetched from $_REQUEST.
- xss_clean (_boolean_): Whether to apply XSS filtering.

### 2. protocol

This method returns the protocol that the request was made with.

### 3. referrer

Returns the protocol that the request was made with.
Arguments:

- default (_string_): What to return if no referrer is found.
- xss_clean (_boolean_): Whether to apply XSS filtering.

### 4. query_string

Returns the query string. that's all.
Arguments:

- default (_string_): What to return if nothing found.
- xss_clean (_boolean_): Whether to apply XSS filtering.

## KB_Lang.php

The default behavior of **Lang** class has been changed a bit as well.
When loading a language file, the **fallback** language is loaded first (Default: english), then the requested file is loaded ad keys are changed. This way even if a line is not translated into the language you want to use, it will still be available in the fallback language (english).

**IMPORTANT**: Make sure to have your language files in the fallback language first, otherwise this will trigger the error of the not found file.

The `line` method has been overridden as well. It accepts a second argument which is the **index**. This is useful if your language lines are in a multidimensional array. Also used when translating **themes**. Example:

```php
// In a language file:
$lang['button'] = array(
	'login'  => 'Sign In',
	'logout' => 'Sign out',
);

// This will trigger the array to string conversion error:
echo $this->lang->line('button');
// This will not even find the line:
echo $this->lang->line('login'); // Outputs: FIXME('login').

// The correct way:
echo $this->lang->line('login', 'button');
```

If the language line is not found, you will see `FIXME('line')` . This can be changed and use inflector if you want. From line **#268** to **#270**:

```php
// (function_exists('humanize')) OR get_instance()->load->helper('inflector'); // <- UNCOMMENT THIS
// $value = humanize($line); // <- UNCOMMENT THIS
$value = "FIXME('{$line}')"; // <- COMMENT THIS

// Default not-found line:
echo $this->lang->line('hello_world');
// Outpus: "FIXME('hello_world)".
// If changed it outputs: "Hello World".
```

Another method was added `lang`. What it does is explained above (**KB_Config.php** file).

At the bottom of the file, the `lang` function was taken from the language helper and put there so it can be available even if the helper is not loaded.

Three additional functions were added:
- `line`: that uses the class method with **line** and **index** as arguments.
- `__`: this is an alias, you can use it or not.
- `_e`: This function will echo the line instead of returning it. This is useful in views. See the example below:

```php
echo lang('login'); 			// Outputs: "FIXME('login')".
echo line('login', 'button');	// Outputs: "Sign In".
echo __('login', 'button');	// Outputs: "Sign In".

// In your views:
_e('login', 'button');
```

## KB_Loader.php

This class overrides some of default **Loader** class behavior in order to use **HVMC** structure. In was inspired from [Jens Segers extension](https://github.com/jenssegers/codeigniter-hmvc-modules), take a look at the repository to know more.
You may find out that some of original methods were removed because they were kind of unnecessary and because we made deeper checks by editing `_ci_load` and `_ci_load_stock_library` methods.

## KB_Model.php

Because, again, we believe is simplicity, we are using an modified version of [Jamie Rumbelow](https://github.com/jamierumbelow/codeigniter-base-model)'s Base Model. Few methods have been added to it but we will leave this for **Models** sections.

## KB_Router.php

Because we are using **HMVC** structure, we had to do some changes on default **Router** class behavior. This was as said above, inspired from **Jens Segers** extension but with some modifications.
The new thing about this is that you can have routes folder in your application, or skeleton folder (_APPPATH/routes/_) in which you can put separate routing files that will be included before routes are set.

At the very top of the this file, will you see that we are including a **Route.php** file. This allow us define routes statically. This was inspired from [Bonfire](https://github.com/ci-bonfire/Bonfire/blob/develop/bonfire/libraries/Route.php)'s. Make sure to **ALWAYS** keep the following line at the end of your main routes file (_APPPATH/config/routes.php_):

```php
$route = Route::map($route);
```

Example of using static routing:

```php
Route::any('test', 'test/index');				// Any request.
Route::get('view/(:num)', 'whatever/view/$1');	// GET requests.
Route::post('...');
Route::put('...');
Route::delete('...');
// ... etc
```

Other methods are available too. For example:

```php
// To retrieve the full path to module's directory:
$this->router->module_path('module_name');

// To retrieve locations where modules are:
$this->router->modules_locations();
```

Modules may have a **manifest.json** file that holds informations about the module. And to get those details, you can use the other added method:

```php
$details = $this->router->module_details('menus');
// We will talk more about this in "modules" section.
```

## User_Controller.php

Controllers extending this class require a logged in users.

## Admin_Controller.php

This controller is used for the administration area of the site. All controllers extending it require a logged in user of **administrator** rank.
There are two (**2**) method that you can use when you extending this controller:

* `load_jquery_ui`: As it says, it only loads jQuery UI assets.
* `add_sortable_list`: It make a list sortable using jQuery UI (please check the code to see how it works - Or check menus module).

As said earlier, so we don't touch a lot core classes, we created our own custom ones in order to enhance or override some behaviors and so we can integrate an **HMVC** structure.

## KB_Form_validation.php

This file was created in order to add some useful stuff to CodeIgniter form validation library. Here are few filters you may use:

* `alpha_extra`: Allow alpha-numeric characters with periods, underscores, spaces and dashes.
* `unique_username`: it is used to check username uniqueness.
* `unique_email`: it is used to check email addresses uniqueness.
* `user_exists`: checks if the user exists in database.
* `check_credentials`: check user's credentials on login page.
* `current_password`: checks the current user's password.

Default behavior of the filters listed below was changed in order to use parameters stored in configuration. See the example after them.

* `min_length`, `max_length` and `exact_length`.
* `greater_than`, `greater_than_equal_to`, `less_than` and `less_than_equal_to`

```php
// Let's suppose we set in a config file usernames min and max length to 5-32
$config['username_min'] = 5;
$config['username_max'] = 32;

// We usually do:
$this->form_validation->set_rules('username', 'Username', 'min_length[5]|max_length[32]');

// With this modified, you can do:
$this->form_validation->set_rules('username', 'Username', 'min_length[username_min|max_length[username_max]');
```

## KB_Table.php

The table library is still the same, nothing that may mess Codeigniter was added.  

We have added the **table.php** configuration file that you can edit to suit your needs, and we have added the `table_tag` filter that plugins, themes or any part if your application may use to alter these settings.

We have added few tags to the table:  

* **tfoot_open** and **tfoot_close** that creates table footer opening and closing tags: `<tfoot>` and `</tfoot>`.
* **footer_row_start** and **footer_row_end**: by default they are `<tr>` and `</tr>`.
* **footer_cell_start** and **footer_cell_end**: by default they are `<td>` and `</td>`.

If you build a plugin or theme that needs table tags to be changed, proceed like so:

```php
// It takes an array as argument.
add_filter('table_tags', function($tags) {
	// Edit them the way you want. Example:
	$args['table_open'] = '<table class="table table-hover">';

	// Then make sure to ALWAYS return the array.
	return $tags;
});
```

## Bcrypt.php

There is nothing we can about this, it is only used to hash and check passwords. It is better if you use the provided custom library [Hash.php](#hashphp).

## Format.php

This library helps convert between various formats such us XML, JSON, JSON ...

## Hash.php

Hashes, encrypts/decrypts strings and generates random strings.

## Plugins.php

This is the file behind our custom WordPress-like hooks system ([Wiki](https://github.com/bkader/skeleton/wiki/Hooks-System)).

## Route.php

Provides enhanced routing capabilities to CodeIgniter.

## Theme.php

This is the magical library that allow you to make create amazing app-independent themes.
