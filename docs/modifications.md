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

* At line **#75** we included our custom `constants.php` file that holds some useful constants including the Skeleton version `KB_VERSION`. 
```php
// Some useful constants are added.
require_once(KBPATH.'config/constants.php');
```
* Lines from **#405** up to **#411** we replace by our custom check. In the modified file you will find them from **#408** up to **#425**.

```php
// 405-411 | Original file:
if (empty($class) OR ! file_exists(APPPATH.'controllers/'.$RTR->directory.$class.'.php'))
{
    $e404 = TRUE;
}
else
{
    require_once(APPPATH.'controllers/'.$RTR->directory.$class.'.php');

// 408-425 | Modified file:
if (empty($class))
{
    $e404 = TRUE;
}
else
{
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
