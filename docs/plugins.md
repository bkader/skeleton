
Plugins Development
===============

Plugins is another cool thing added alongside CodeIgniter. If you are not familiar with this term, you are invited to look for it on the internet. Major **CMS** has integrated plugins system (see **WordPress** plugins).  

## Creating Plugins

To create your first plugin, here are step you need to follow:

1. Create your plugin's folder within the **content/plugins/** directory. The folder's name should be a **slug** representation of your plugin's name. For example, the **Hello world** example plugin's folder is name **helloworld**.
2. Create the main plugin's file (**php file**) with same name as the folder. For example, the **Hello World** plugin's main file is: **content/plugins/helloworld.php**.
3. <del>Make sure to create the **manifest.json** (*json*) file within the plugin's folder. This file is required for the plugin to be recognized and listed. See below what this file should contain</del>.

The **manifest.json** is no longer needed. Simply add required headers to your main plugin file like so:

```php
/**
 * Plugin Name: Cache Assets
 * Description: This plugins combines all your CSS and JS files into a single CSS file and a single JS file reduce http requests and cache assets. This file is then cached for a period you choose.
 * Version: 0.3.0
 * License: MIT
 * License URI: http://opensource.org/licenses/MIT
 * Author: Kader Bouyakoub
 * Author URI: https://github.com/bkader
 * Author Email: bkader@mail.com
 * Tags: skeleton, cache, assets
 * Language Folder: langs
 */
```

## Plugins Hooks

There are three (**3**) main actions you may use when creating your plugin (**x** is your plugin's slug):

1. `plugin_install_x`: triggered upon plugin's installation process.
2. `plugin_activate_x`: triggered upon plugin's activation.
3. `plugin_deactivate_x`: triggered upon plugin's deactivation.

Let's suppose I have a plugin called **Hello World** of which the folder is name **helloworld**. Here is how these actions can be used:

```php
# Anonymous function:
add_action('plugin_install_helloworld', function() {
    // Do your magic.
});

# Defined function:
add_action('plugin_activate_helloworld', 'hello_world_activate');
if ( ! function_exists('hello_world_activate'))
{
    function hello_world_activate()
    {
        // Do your magic.
    }
}

# Within a class.
class Hello_world
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        add_action('plugin_install_helloworld',    array($this, 'install'));
        add_action('plugin_activate_helloworld',   array($this, 'activate'));
        add_action('plugin_deactivate_helloworld', array($this, 'deactivate'));
    }

    /**
     * Triggered upon plugin's installation.
     */
    public function install() { // DO YOUR MAGIC. }

    /**
     * Triggered upon plugin's activation.
     */
    public function activate() { // DO YOUR MAGIC. }

    /**
     * Triggered upon plugin's deactivation.
     */
    public function deactivate() { // DO YOUR MAGIC. }
}

# Then we initialize the class:
$hello_world = new Hello_world();
```

## Plugins Settings

If you wish to add a settings page to your plugin, simply add the `plugin_settings_x` action, where **x** stands for your plugin's slug.  

```php
# same plugin: Hello World.
add_action('plugin_settings_helloworld', function() {
    # Output your settings page (HTML).
});
```

If you wish to use CodeIgniter featured (libraries, models ... etc) or provided skeleton libraries, make sure to call the `$KB` global variable within your functions or methods.

```php
// This function uses CodeIgniter features:
function test()
{
    global $KB;

    # Load helpers, libraries and models:
    $KB->ci->load->helper('dummy');
    $KB->ci->load->library('form_validation'); # <- You can use form validation ;)
    $KB->ci->load->model('anything');
}

# To use the Skeleton libraries:
function test2()
{
    global $KB;

    # Entities, users, metadata ... etc:
    $KB->entities->get(1);
    $KB->users->get_by('username', 'bkader');
    $KB->metadata->get_meta(1, 'company', TRUE);
}
```

## How To Use?

When developing your application, make sure to do actions and apply filters wherever your want themes/plugins to act.  
Even if there are no filter or actions, just put them for later use.

Example

```php
// Example of array I want themes/plugins to use:
$array = array('one', 'two', 'three');
$array = apply_filters('my_custom_filter', $array);

// Plugins/themes will simply need to add the filter:
add_filter('my_custom_filter', function($array) {
    // Add something or alter.
    array_push($array, 'four');
    return $array;
});

// The final result will be:
$array = array('one', 'two', 'three', 'four');
```

To learn more about this system, you can refer to WordPress documentation.
