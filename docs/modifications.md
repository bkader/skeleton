
# Modifications
We are following the standard project folder, you might see few available directories: **docs**, **license**, **public**, **src** and **tests**.  

## CodeIgniter:
Few modifications, enhancement and rewriting have been done to suit the need of the application. These are few to none changes but we have to mention them due to license agreement and so that you know what to do in case of a new CodeIgniter release.

### index.php:
On this file, we have first added the path to **src** folder which starts from line **#92** to line **#102**.
```php
/*
 *---------------------------------------------------------------
 * Path to skeleton folder.
 *---------------------------------------------------------------
 *
 * This folder contains all files that override or extend
 * CodeIgniter core classes and files.
 *
 */
	$skeleton_src = '_PATH_TO_SRC_DIR';
	$skeleton_path = "{$skeleton_src}/skeleton";
```
At line **#251** and line **#254** we have defined two useful constants:
```php
// Define the path to skeleton folder.
define('KBPATH', $skeleton_path.DIRECTORY_SEPARATOR);

// Define a constant representing DIRECTORY_SEPARATOR.
define('DS', DIRECTORY_SEPARATOR);
```
### CodeIgniter.php:
We have include our custom **constants.php** file in which you will find some useful constants. At like **#75**:
```php
	// Some useful constants are added.
	require_once(KBPATH.'config/constants.php');
```
From line **#218** to **#223** we have loaded our custom plugins class **CI_Plugins** that allows as to use a more advanced hooks system:
```php
/*
 * ------------------------------------------------------
 *  Instantiate the plugins class
 * ------------------------------------------------------
 */
	$PLG =& load_class('Plugins', 'libraries');
```
And because we have included this class, you will also find on this file:  

```php
$PLG->do_action('pre_system'); 					// Line #217
$PLG->do_action('pre_controller');				// Line #542
$PLG->do_action('post_controller_constructor'); // Line #560
$PLG->do_action('post_controller');				// Line #578
$PLG->do_action('post_system');					// Line #596
```
At lines **#427** to **#444** we have a little modification so controllers are loaded from the default folder *APPPATH/controllers* but also our custom folder *KBPATH/controllers*. Here is how those line were and below how they become:
```php
// Line #405 (original CodeIgiter.php):
if (empty($class) OR ! file_exists(APPPATH.'controllers/'.$RTR->directory.$class.'.php'))

// Line #405 (after) ... You will find it at #433:
if (empty($class))


// Line #411 (original CodeIgniter.php)
require_once(APPPATH.'controllers/'.$RTR->directory.$class.'.php');

// After, you will find it at line #433
if (file_exists(APPPATH.'controllers/'.$RTR->directory.$class.'.php'))
{
	require_once(APPPATH.'controllers/'.$RTR->directory.$class.'.php');
}
elseif (file_exists(KBPATH.'controllers/'.$RTR->directory.$class.'.php'))
{
	require_once(KBPATH.'controllers/'.$RTR->directory.$class.'.php');
}
else
{
	$e404 = TRUE;
}
```
### Common.php
The **load_class** function has been altered a litte bit. In fact we have added our custom path to class loading and we are loading our custom classes right after core classes are loaded in order to enhance or override behavior.  
At line **#155**:
```php
// Before
foreach (array(APPPATH, BASEPATH) as $path)

// After
foreach (array(APPPATH, KBPATH, BASEPATH) as $path)
```
From line ** #170** to line **#182**, here is where we load our custom classes to enhance or override behavior:
```php
/**
 * Load any existing class with our custom subclass prefix 'KB_',
 * we do this to allow the user to extend core classes with the
 * prefix set in application/config/config.php file.
 */
if (file_exists(KBPATH.$directory.'/KB_'.$class.'.php'))
{
	$name = 'KB_'.$class;
	if (class_exists($name, FALSE) === FALSE)
	{
		require_once(KBPATH.$directory.'/KB_'.$class.'.php');
	}
}
```
### Controller.php:
The only thing we have edited here is adding the config class to loader where it's loaded:
```php
// Line #78 (before):
$this->load =& load_class('Loader', 'core');

// After:
$this->load =& load_class('Loader', 'core', $this->config);
```
This modification is not really required, it was done to enhance the execution time only. But if you use it, it is good to edit the **Loader.php** file as well.  

### Loader.php:
Because of the modification we did to **Controller.php** file, the class constructor has been changed:  
```php
// Before:
public function __construct()
{
	$this->_ci_ob_level = ob_get_level();
	$this->_ci_classes =& is_loaded();

	log_message('info', 'Loader Class Initialized');
}

// After:
public function __construct(CI_Config $config)
{
	$this->config =& $config;
	$this->_ci_ob_level = ob_get_level();
	$this->_ci_classes =& is_loaded();

	log_message('info', 'Loader Class Initialized');
}
```
After this, wherever the `config_item(...)` it is used, it was changed to `$this->config->item(...)`.

## Custom Classes:
As said earlier, so we don't touch a lot core classes, we created our own custom ones in order to enhance or override some behaviors and so we can integrate an **HMVC** structure.

### KB_Config.php:
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

### KB_Lang.php:
The default behavior of **Lang** class has been changed a bit as well.  
When loading a language file, the **fallback** language is loaded first (Default: english), then the requested file is loaded ad keys are changed. This way even if a line is not translated into the language you want to use, it will still be available in the fallback language (english).  

**IMPORTANT**: Make sure to have your language files in the fallback language first, otherwise this will trigger the error of the not found file.  

The **line** method has been overridden as well. It accepts a second argument which is the **index**. This is useful if your language lines are in a multidimensional array. Also used when translating **themes**. Example:
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
Another method was added **lang**. What it does is explained above (**KB_Config.php** file).  

At the bottom of the file, the **lang** function was taken from the language helper and put there so it can be available even if the helper is not loaded.  

Three additional functions were added:  
- **line**: that uses the class method with **line** and **index** as arguments.
- **__**: this is an alias, you can use it or not.
- **_e**: This function will echo the line instead of returning it. This is useful in views. See the example below:
```php
echo lang('login'); 			// Outputs: "FIXME('login')".
echo line('login', 'button');	// Outputs: "Sign In".
echo __('login', 'button');	// Outputs: "Sign In".

// In your views:
_e('login', 'button');
```

### KB_Input.php:
Four (**4**) methods have been added to this class.  
#### 1. request:
This method fetches an item from the **$_REQUEST** array.
```php
echo $this->input->request('action'); // Example only.
```
Arguments:
- index (_string_): Index for item to be fetched from $_REQUEST.
- xss_clean (_boolean_): Whether to apply XSS filtering.

#### 2. protocol:
This method returns the protocol that the request was made with.
#### 3. referrer:
Returns the protocol that the request was made with.  
Arguments:

- default (_string_): What to return if no referrer is found.
- xss_clean (_boolean_): Whether to apply XSS filtering.

#### 4. query_string:
Returns the query string. that's all.  
Arguments:

- default (_string_): What to return if nothing found.
- xss_clean (_boolean_): Whether to apply XSS filtering.

### KB_Loader.php:
This class overrides some of default **Loader** class behavior in order to use **HVMC** structure. In was inspired from [Jens Segers extension](https://github.com/jenssegers/codeigniter-hmvc-modules), take a look at the repository to know more.  
You may find out that some of original methods were removed because they were kind of unnecessary and because we made deeper checks by editing **_ci_load** and **_ci_load_stock_library** methods.

### KB_Router.php:
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
There are more methods but you will find them on the documentation dedicated to routing.

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

### KB_Model.php:
Because, again, we believe is simplicity, we are using an modified version of [Jamie Rumbelow](https://github.com/jamierumbelow/codeigniter-base-model)'s Base Model. Few methods have been added to it but we will leave this for **Models** sections.
