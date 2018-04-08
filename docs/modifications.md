# CodeIgniter Modifications

We are following the standard project folder, you might see few available directories: **docs**, **license**, **public**, **src** and **tests**.

Few modifications, enhancement and rewriting have been done to suit the need of the application. These are few to none changes but we have to mention them due to license agreement and so that you know what to do in case of a new CodeIgniter release.

* [index.php](#indexphp)
* [CodeIgniter.php](#codeigniterphp)
* [Common.php](#commonphp)

## index.php

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

## CodeIgniter.php

From line **#60** to line **#66**, we simply added the Skeleton version constant (since v**1.3.3**).

```php
/**
 * Skeleton Version
 *
 * @var	string
 *
 */
	const KB_VERSION = '1.3.3';
```

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
$PLG->do_action('pre_controller');				// Line #542
$PLG->do_action('post_controller_constructor');	// Line #560
$PLG->do_action('post_controller');				// Line #578
$PLG->do_action('post_system');					// Line #596
```

At lines **#429** to **#450** we have a little modification so controllers are loaded from the default folder *APPPATH/controllers* but also our custom folder *KBPATH/controllers*. Here is how those line were and below how they become:

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

## Common.php

The **load_class** function has been altered a little bit. In fact we have added our custom path to class loading and we are loading our custom classes right after core classes are loaded in order to enhance or override behavior.
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
