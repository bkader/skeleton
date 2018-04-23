Themes Development
===============

* [Folder Structure](#folder-structure)
* [Hooks and Functions](#hooks-and-functions)
    * [Handling View Files](#handling-view-files)
    * [Themes Translations](#themes-translations)
    * [Theme Menus](#theme-menus)
    * [Styles and Scripts Hooks](#styles-and-scripts-hooks)
    * [Meta Tags Hooks](#meta-tags-hooks)
    * [Additional Hooks](#additional-hooks)
    * [Additional Functions](#additional-functions)

Unlinke other templates and themes library, the provided theming library makes your themes completely independent from your application. By independent, we mean:  

* Themes can enqueue their own styles and scripts, you no longer have to do it on your controllers.
* You can manager your themes layouts and partial views right from your themes `functions.php` file. No need to set them on your application controllers.
* Themes are translatable. By simply setting where language files are located and adding language lines, you can use your translations anywhere in your views.

## Folder Structure

Even if you are free to set any structure you want, we recommend using the structure found in the provided **default** theme, this is not an obligation but a simple consistency, that's all!  

Here is the default's theme folder structure:  

```
- assets
    - css
    - js
    - fonts
    - img
- language
- templates
    - layouts
    - partials
```

As you guessed:  

* **assets** folder contains all your theme's scripts, styles, fonts and images.
* **language** folder contains all your language translations.
* **template** is where views, partials and layouts are located. This folder and sub-folders are protected from direct access by an automatically generated **.htaccess** file.

When developing your themes, two (**2**) files are required so your theme would be recognized and listed on the dashboard:

* **functions.php**: This file handles all hooks (actions and filters) for your theme (we talk about them below).
* **style.css**: The is the main theme stylesheet. Make sure to add required headers to it so the theme is recognized. It must be inside your theme's root directory.

```css
/**
 * Theme Name: Default
 * Theme URI: https://github.com/bkader/skeleton/tree/develop/public/content/themes
 * Description: The default theme that comes with the CodeIgniter Skeleton.
 * Version: 1.0.0
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Author: Kader Bouyakoub
 * Author URI: https://github.com/bkader/
 * Author Email: bkader@mail.com
 * Tags: codeigniter, skeleton, bkader, bootstrap, bootstrap3
 */
```

## Hooks and Functions

Because we are using a custom made **hooks** system that uses **actions** and **filters**, just like WordPress does, there are several hooks that you can use in order to develop your themes. Let's walk through all of them one by one and explain a bit what they do.

There are several checkers you may use to play with your theme. You will find them a lot on this page, so it is better if we tell you about them:

* `is_module` (*mixed*): checks if we are on a module if no argument passed. If you pass any argument, it checks if we are on that module. You may pass a string, an array, a comma-separated string ... etc. The same goes with: `is_controller` and `is_method`, you may guess what they are used for.
* `add_style` and `add_script`: these functions simply adds CSS and JS files to queue so they get use later on the final output.
* `add_inline_style` and `add_inline_script`: Unlike functions above them, these functions add `inline` styles or scripts. Don't worry, we will talk about them later, on their own section.
* `theme_url`, `theme_path`, `upload_url`, `upload_path`, `common_url` and `common_path`: these function `echo` URLs and paths to their respective folders: theme's folder, uploads folder and common files folder. If you want to return them, simply prepend `get_` to them. Example: `get_theme_url`.

### Handling View Files

Maybe the first thing that you should do it to tell the library where it should load your themes files, layouts, partials and views. To do so, simply use available hooks.

```php
/*
Let's suppose I have a theme called "whatever" and I want to tell
the library that:
    - Layouts are inside: templates/layouts/
    - Partials are inside: templates/layouts/
    - Views should be loaded from: templates/

Here is how it is done:
*/

// Layouts:
add_filter('theme_layouts_path', function($path) {
    
    // Change path:
    $path = get_theme_path('templates/layouts/');

    return $path; // <- ALWAYS return the path.

});

// Partials:
add_filter('theme_layouts_path', function($path) {

    // Change path:
    $path = get_theme_path('templates/partials/');

    return $path; // <- ALWAYS return the path.

});

// Views:
add_filter('theme_layouts_path', function($path) {

    // Change the path:
    $path = get_theme_path('templates/');

    return $path; // <- ALWAYS return the path.

});

```

Sometimes, the library cannot find the layout, partial or view inside the folder you specified. Simply because your forgot to create it, deleted it or the name is wrong. There are other filters than you can use in order the handle fall-backs. If files are not found, fall-back files are used. See below;

```php
// Layouts
add_filter('theme_layout_fallback', function($layout) {

    // Let's handle things:
    if ($layout == 'default') {
        $layout = 'default-fallback';
    }

    return $layout; // <- ALWAYS return the layout.

});

// Partials
add_filter('theme_partial_fallback', function($partial) {

    // Let's handle things:
    if ($partial == 'sidebar') {
        $partial = 'sidebar-fallback';
    }

    return $partial; // <- ALWAYS return the partial.

});

// Views
add_filter('theme_view_fallback', function($view) {

    // Let's handle things:
    if ($view == 'login') {
        $view = 'login-fallback';
    }

    return $view; // <- ALWAYS return the view.

});
```

On other template libraries, you have to load partial views on controllers (or views, I didn't test). With the provided theme library, themes handle their own partial views. Simply use the `enqueue_partials` action. Once done, partial views are cached and output only if you request them.  
If for instance I enqueue a **navbar.php** partial view, I can output it on a given view file or layout, using the `get_partial` function. Don't worry, even if you did not enqueue the partial, the library will output it if you request it anyways.

```php
// Let's suppose i want to add the navbar.php file.
add_action('enqueue_partials', function() {
    add_partial('navbar', $data, $name);
});

/*
To explain the code above:
    - 'navbar' is located in .../THEMENAME/templates/partials/.
    - $data is an array of whatever you want to pass the the view file.
    - $name is used if you want to give it a different name to avoid
      conflict.

Once this is done, wherever you want to display the navbar, use:
*/
echo get_partial('navbar'); // if you provided $name, use it instead.
```

Views are automatically guessed. For example, **welcome/index** is the view file of the controller **Welcome::index**.. You can override this, using the **theme_view** hook. This should be combined with provided checkers as well: **is_module**, **is_controller** and **is_method**.

```php
add_filter('theme_view', function($view) {
    
    // On "Test" controller, use "test-2" file:
    if (is_controller('test'))
    {
        return 'test-2';
    }

    // On both "Foo" and "Bar" controllers, use "haha" file:
    // if (is_controller('foo', 'bar') { <- This or :
    // if (is_controller(['foo', 'bar']) { <- This or :
    if (is_controller('foo, bar'))
    {
        return 'haha';
    }

    // On the "Turtle" module, use the "turtle" view:
    if (is_module('turtle'))
    {
        return 'turtle';
    }

    // On the "turtule" module, "egg" controller and "test" method, use "dummy" file:
    if (is_module('turtle') && is_controller('egg') && is_method('test'))
    {
        return 'dummy';
    }

    return $view; // <- ALWAYS return the view.
});
```

The same thing goes with layouts! Sometimes you want to use a given layout for a given module, controller or a method, the same thing as above, only the filter changes: `theme_layout`:

```php
add_filter('theme_layout', function($layout) {

    // On "users" module, use the "clean" layout:
    if (is_module('users'))
    {
        return 'clean';
    }

    // On the blog section, use layout with sidebar
    if (is_module('blog'))
    {
        return 'with-sidebar'; // Just an example.
    }

    return $layout; // <- ALWAYS return it.
});
```

### Themes Translations

As said earlier, themes can be translated. All you have to do is to add the **theme_translation** action in which you provide the path where translations should be loaded from:

```php
add_action('theme_translation', function($path) {
    $path = get_theme_path('language');
    return $path; // <- ALWAYS return the path.
});
```

Once that done, use CodeIgniter language helper or provided functions: **line**, **__** or **\_e**.  

You may provide a custom index for your language lines. If you don't, the theme folder name will be used instead. To define your own translation index, use the `theme_translation_index` filter like so:
```php
add_filter('theme_translation_index', function($index) {
    return 'my-custom-index';
});
// This way, you will access your theme's language lines like so:
echo line('my_line', 'my-custom-index');
// Instead of :
echo line('my_line', 'default'); // If "default" is the theme.
```

**NOTE**: **DONT** use CodeIgniter `lang` function because it does not come with optional index. You may want to use our provided functions: `line()`, `__()`or `_e()`. Example:

```php
_e('my_line', 'default'); // To echo the line.
echo line('my_line', 'default');
echo __('my_line', 'default');
```

### Theme Menus

To register theme's menus locations that can be used to assign menus to, you can use the **theme_menus** action combined with the **register_menu** function (this function is provided by the menus library). Here is an example:

```php
add_action('theme_menus', function() {
    /*
        To regiter a menu:
        register_menu($name, $description);

        To register multiple menus:
        register_menu(array('slug' => 'name', ... ));

        To translate menus names:
        register_menu(array('slug'  => 'lang:namg', ... ));

        Make sure to add names translations to themes
        language files.
    */

    // Example from the default theme:
    register_menu( array(
        'header-menu'  => 'lang:main_menu',     // Main menu (translated)
        'footer-menu'  => 'lang:footer_menu',   // Footer menu (translated)
        'sidebar-menu' => 'lang:sidebar_menu',  // Sidebar menu (translated)
    ) );
});
```

### after_theme_setup

This is the main action that you can use. With it you can everything in case you don't want to add multiple actions and filters. But as said earlier, it is better to use each action or filter to what it was meant to be used for.

Simply add the action like so:
```php
// The callback must exist in order to be called.
add_action('after_theme_setup', 'the_callback_to_use');
```

Here is an example on how to use it
```php
add_action('after_theme_setup', function() {
    // Adding StyleSheets.
    add_style('style', get_theme_url('assets/css/style.css'));

    // Adding Scripts.
    add_style('style', get_common_url('js/plugin.js'));
});
```

---  

### Styles and Scripts Hooks

There are several actions and hooks used to handles styles and scripts. The main two actions are: `enqueue_styles` and `enqueue_scripts`. These are used to enqueue assets (Note: These are actions). Here is how to use theme:

```php
// To enqueue StyleSheets:
add_action('enqueue_styles', function() {
    // Enqueue a file:
    add_style($handle, $file, $version, $prepend, $attrs);

    // An an inline CSS:
    $content =<<<EOT
<style type="text/css">
.text-test { color: red; }
</style>
EOT;
    add_inline_style($content, $handle);
});

// ------------------------------------------------------------

// To enqueue scripts:
add_action('enqueue_scripts', function() {
    // Enqueue a file:
    add_style($handle, $file, $version, $prepend, $attrs);

    // An an inline JS:
    $content =<<<EOT
<script type="text/javascript">
(function() {
    alert("Hello World!");
})();
EOT;
    add_inline_script($content, $handle);
});
```

Other filters are available and can be used to put staff `before` OR `after` styles or scripts. They both use the final **HTML** output as an argument, so you **must** treat it as a string and **MUST** return it at the end (Note: these are filters).  

You can use **before** to add things after, and **after** to add things **before**, but we thought it would be fancy to separate theme, don't you think?

Available filters are: `before_styles`, `after_styles`, `before_scripts` and `after_scripts`. The example below is using only `before_styles` to demonstrate how it should be done, the same thing is done with other filters:

```php
add_filter('before_styles', function($content) {
    // Add anything to it, before or after, as you wish.
    $added = '<style>.example { color: green; }</style>';
    $content = $added.$content;

    return $content; // <- IMPORTANT
});
```

### Alerts and Messages

The theme library comes with default alert template so that, even if you don't provided any, the alert is still available.  
In order to use your own (because we are using Bootstrap's), simple use the `alert_template` filter, it takes a string as argument. You can use it like so:

```php
// This is the HTML alert template.
add_filter('alert_template', function($template) {

    // Change the template the way you want, simply make
    // sure to add: {class} and {message} placeholders.
    $template =<<<EOT
    <div class="{class} alert-dismissable text-left" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {message}
    </div>
EOT;

    return $template; // <- ALWAYS return it.
});

// Or the JS alert template used for JavaScript.
add_filter('alert_template_js', function($template) {

    // Make sure to add {class} and {message} placeholders;
    // See the default template as an example:
    $template =<<<EOT
'<div class="{class} alert-dismissable text-left" role="alert">'
+'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
+'{message}'
+'</div>'
EOT;

    return $template; // <- ALWAYS return $template.

});
```

Now that you have set your own theme's alert template, you may want to change default classes using the `alert_classes` filter. It takes an array of available classes like so:

```php
add_filter('alert_classes', function($classes) {

    // Lets change theme using bootstrap:
    $classes['info']    = 'alert alert-info';
    $classes['error']   = 'alert alert-danger';
    $classes['warning'] = 'alert alert-warning';
    $classes['success'] = 'alert alert-success';
    
    return $classes; // <- ALWAYS return classes.

});
```

In order to set an alert message, you may use the `set_alert` function in your controllers, libraries or theme's files:

```php
// set_alert($message, $type);
// type: info, error, warning or success.
set_alert('This is the alert message!', 'error');

// To set multiple alerts:
set_alert(array(
    'error'   => 'This is the error message.',
    'success' => 'This is the success message.',
    // ... etc
));
```

If you want to display an alert in your views, you may use the `print_alert` functions:

```php
/*
print_alert($message, $type, $js, $echo);

    - $message (string):    the message to display.
    - $type (string):       the message's type (error, info, success or warning).
    - $js (bool):           whether to use the html or JS template.
    - $echo (boolean):      TRUE: echo, FALSE: return the output.
*/
echo print_alert('This is the message', 'info', false, false);

// OR
print_alert('This is the message', 'info');
```

All you have to do after is use the `the_alert()` function on your views. If an alert exists, il will be displayed, otherwise, if displays nothing.

### Meta Tags Hooks

These are the **&lt;meta&gt;** tags added to the &lt;head&gt; section. You can enqueue you meta tags on the `after_theme_setup` action, but we thought it would be wide to separate them and create a separate hook form them. You may use the `add_meta_tag` function en add as many tags as you want. Example: 

```php
// add_meta_tag($name, $content, $type, $attributes);
add_meta_tag('charset', 'UTF-8');
add_meta_tag('viewport', 'width=device-width, initial-scale=1');
add_meta_tag('title', 'Your Title');
add_meta_tag('canonical', 'https://github.com/bkader', 'rel');
```

You can directly output a meta tag on your **header.php** file if you want, using the `meta_tag` function like so:

```php
// meta_tag($name, $content, $type, $attributes);
echo meta_tag('charset', 'UTF-8');
echo meta_tag('viewport', 'width=device-width, initial-scale=1');
echo meta_tag('title', 'Your Title');
echo meta_tag('canonical', 'https://github.com/bkader', 'rel');
```

But as we said earlier, we prefer queuing everything before the final output. To do so, you may use the `enqueue_meta` action inside which you use the `add_meta_tag` function, like so:

```php
add_action('enqueue_meta', function() {
    add_meta_tag('charset', 'UTF-8');
    add_meta_tag('viewport', 'width=device-width, initial-scale=1');
    add_meta_tag('title', 'Your Title');
    add_meta_tag('canonical', 'https://github.com/bkader', 'rel');
});
```

This way, they will be held until the final output is requested. In fact, this is the best way for a better performance.  

There are two (**2**) more hooks (filters) that you may use, they do the same thing as `before_x` and `after_x` (**x**: styles, scripts or meta). So, they are used to print things **before** or **after** final meta tags output.

```php
add_filter('before_meta', function($output) {
    // Add whatever you want.
    $output = '<meta name="application-name" content="Skeleton" />'.$output; // Before
    return $output; // <- ALWAYS return it.
});

// Or the after:
add_filter('after_meta', function($output) {
    // Add whatever you want.
    $output .= '<meta name="application-name" content="Skeleton" />'; // After
    return $output; // <- ALWAYS return it.
});
```

### Additional Hooks

There are extra hooks you may use as well:

* `the_doctype`: as requested by **Shaun Pearce**, this filter allows you to dynamically change the `<!DOCTYPE>` declaration ([example #1](#example-1)).
* `html_class`: this filter is used to set classes to the &lt;html&gt; tag ([example #2](#example-2)).
* `language_attributes`: this filter is used to add anything to the **lang** attributes of the &lt;html&gt; tag ([example #3](#example-3)).
* `the_charset`: this filter alters the &lt;meta charset=""&gt; tag the way you want ([example #4](#example-4)).
* `the_title`: If you want to alter the page title, you may use this hook ([example #5](#example-5)).
* `extra_head`: this filter is used to add anything right before the closing &lt;/head&gt; tag ([example #6](#example-6)).
* `body_class`: this filter is used to set classes to the &lt;body&gt; tag ([example #7](#example-7)).
* `the_content`: this filter is used to alter the final view content, it takes a string as argument ([example #8](#example-8)).
* `the_output`: this filter targets the final layout output, excluding `header` and `footer` parts.
* `theme_images`: this action is used to define default images thumbnails sizes generated by the media manager ([example #9](#example-9)).

#### Example #1
Let's say I want to change the default `<!DOCTYPE html>` tag to use whatever I want. This is how I should do it:

```php
add_filter('the_doctype', function($doctype) {
    return 'MY_OWN_DOCTYPE';
});
```

#### Example #2
Let's say I want to apply a custom class for my &lt;html&gt; tag depending on the section I am on. Here is how it can be achieved.

```php
// The function takes an array of classes are argument.
add_filter('html_class', function($classes) {

    // Let's add some classes.
    if (is_module('users')) {
        $classes[] = 'on-users-module'; // Example only
    }

    if (is_controller('test')) {
        $classes[] = 'on-test-controller'; // Example only
    }

    if (is_method('index')) {
        $classes[] = 'on-index-method'; // Example only
    }

    return $classes; // <- ALWAYS return $classes.
});
```

#### Example #3

Even if it's not required, sometimes we want to alter the **lang** attributes of the &lt;html&gt; tag. To do so, you may use the filter `language_attributes` like so:

```php
// THe function takes an array SO it returns an array.
add_filter('language_attributes', function($attributes) {

    // Just add something:
    if (langinfo('code') == 'en') {
        $attributes[] = 'en-US';
    }

    return $attributes; // <- ALWAYS return $attributes.

});
```

#### Example #4

```php
// The function takes an array as argument.
add_filter('the_charset', function($charsets) {

    // Add whatever you want:
    $charsets[] = 'blablabla';

    return $charsets; // <- ALWAYS return $charsets.
});
```

#### Example #5

If you want to do anything to the page's title, you may use the `the_title` filters like so:

```php
// The function takes an array as argument.
add_filter('the_title', function($title) {

    // Add whatever you want:
    $title[] = 'blablabla';

    return $title; // <- ALWAYS return $title.
});
```

#### Example #6

The `extra_head` filter is used to add anything you want right before the closing `</head>`. You can use it print extra styles, scripts or use our provided function `add_ie9_support`. Let's see:

```php
// add_filter('extra_head', function(str $output) { ... });
// Let's add extra style.
add_filter('extra_head', function($output) {

    $style = '<style>.text-red { color: red; } </style>';

    $output = $style.$output; // or: $output .= $style;

    return $output; // <- ALWAYS return $output;

});

/*
The provided function "add_ie9_support" adds support for older
browsers (ie), see the output below.
*/
add_filter('extra_head', function($output) {

    /*
        The second argument of the function is a boolean set
        to TRUE by default to load them using CDN, if set to 
        FALSE, it will load local files found inside common/js
        folder.
    */
    add_ie9_support($output, FALSE);

    return $output; // <- ALWAYS return $output;

});

/*
This outputs:

<!--[if lt IE 9]>
<script type="text/javascript" src="[URL to html5shiv]"></script>
<script type="text/javascript" src="[URL to respond]"></script>
<![endif]-->
</head> // As you see, it's put before the closing tag.
*/

```

#### Example #7

Sometimes we want to apply a custom class to the &lt;body&gt; tag. The `body_class` filter allows you to do that. Let's see an example:

```php
// The function takes an array as argument.
add_filter('body_class', function($classes) {

    if (is_module('users')) {
        $classes[] = 'on-users-module';
    }

    if (is_controller('users')) {
        $classes[] = 'on-users-controller';
    }

    if (is_method('login, register, recover, reset')) {
        $classes[] = 'authentication';
    }

    return $classes; // <- ALWAYS return $classes;

});
```

#### Example #8

The filter `the_content` is used to alter the final output of the view file. The function takes a string as argument, so you may use it like so:

```php
add_filter('the_content', function($content) {

    /*
        Do anything with the $content as long as you return it
        at the end. For example, you can append/preprend an ad
        banner or anything you want.
    */

    return $content; // <- ALWAYS return the content.

});
```

#### Example #9

To automatically generate images thumbnails once uploaded using the medias manager module, make sure to define sizes using the `theme_images` action inside which you can use the `add_image_size` function. This function uses four (**4**) arguments: name, width, height, crop (`bool`).

```php
add_action('theme_images', function() {

    // The 4th argument is set to crop the image or not.
    add_image_size( 'post', 220, 180, true );
    add_image_size( 'avatar', 100, 100, true );

});
```

### Additional Functions

There are other functions you may use. Let's see some of theme:

#### theme_set_var & theme_get_var

The **theme_set_var** is to set a variable, and **theme_get_var** is to retrieve it. The first function sets variables that you may use on your views.
```php
// This third argument is a boolean, if set to true the variable will be global.
theme_set_var('site_name', 'New Site Name'); // Example only.

// To retrieve a variable.
$site_name = theme_get_var('site_name'); // Example only.
```

#### langinfo

This function returns details about the currently used language. It returns the full array of language details if no argument is passed OR the requested key does not exist. Otherwise, it returns the request key value of course.

```php
return langinfo();          // Retuns an array.
return langinfo('name');    // Return the name: English, Français...
```

#### remove_x & replace_x

Replace **x** with **style** or **script**. Sometimes, you want to remove/replace enqueued styles or scripts. Make sure to enqueued them and provided a `$handle` so you can target them. For example:

```php
// Let's remove jQuery, which is automatically enqueued:
remove_script('jquery'); // Use it inside a hook (i.e: enqueue_scripts);

// replace_script($handle, $file, $version);
// Let's use theme's provided jQuery instead of the default one:
replace_script('jquery', get_theme_url('assets/js/jquery.min.js'));

// Or simply:
replace_script('jquery', 'assets/js/jquery.min.js');
```

#### get_header & get_footer

In case I didn't mention it, it is possible to override default library's **header** and **footer** templates by creating those files in you theme's root folder: **header.php** and **footer.php**. Don't worry, even if you don't have them, there will always be a header and a footer for you.  

The `get_header` and `get_footer` functions are optional, but you can use them if you have a different files names. For example: **header-foo.php** or **footer-bar.php**. Simply do:

```php
get_header('header-foo'); // Without argument the default header is loaded.
get_footer('footer-bar'); // Without argument the default footer is loaded.
```

### Dashboard Hooks

All of previously mentioned filters and actions are meant to be used on the front-end. Lots of them have equivalent for the dashboard by simply adding the `admin_` part somewhere. Here is a list of filters and equivalent for dashboard (**x** will refer to styles, scripts or meta):

* `theme_layout` &rarr; `admin_layout`
* `theme_view` &rarr; `admin_view`
* `the_title` &rarr; `admin_title`
* `before_x` &rarr; `before_admin_x`
* `enqueue_x` &rarr; `enqueue_admin_x`
* `print_x` &rarr; `print_admin_x`
* `google_analytics` &rarr; `admin_google_analytics`
* `extra_head` &rarr; `admin_head`
* `html_class` &rarr; `admin_html_class`
* `body_class` &rarr; `admin_body_class`
* `language_attributes` &rarr; `admin_language_attributes`
* `the_charet` &rarr; `admin_charet`b
