Plugins Class
===============

A new hook system has been added to CodeIgniter. Because it is exacly like **WordPress**, re-writing a whole documentation for it would be silly. This is why we invite you to read about it on <a href="https://codex.wordpress.org/Plugin_API/Hooks" target="_blank">WordPress Codex</a>. You will find below a list of available hooks system functions, with links to WordPress documentation to learn more about it.

## How To Use

All you have to do is implement **actions** and **filters** as you develop your applications. Once that done, plugins and themes, or even applications files (libraries, controller, helpers) can use them to do whatever they are made to do. Here is an example of how to use theme.

```php
# Let's suppose I have an array of data that I want to 
# let themes/plugins/files to do anything to it. All I 
# have to do is to pass it to the filter :).
$array = array(
    'one'   => 'Un',
    'two'   => 'Deux',
    'three' => 'Trois',
);

# Then:
$array = apply_filters('custom_filter', $array); # That' all.
```

Then, when developing your application, tell your themes or plugins developers about the **custom_filter** and what it takes as argument (*array*), so when they are developing their things, they only need to do like so:

```php
add_filter('custom_filter', function($array) {

    # They do whatever they want with it, then return it.

    return $array; # <- This should always be returned.

});
```

The same thing goes with **actions**, except than they often take no arguments and return nothing (*not always*).

```php
# Register the hook within the application:
do_action('custom_action');

# After telling developers about it, they can do :
add_action('custom_action', function() {
    # Whatever they want.
});
```

## Available Hooks

Here is a list of function you may use:  

**Filters**:  

* <a href="https://developer.wordpress.org/reference/functions/add_filter/" target="_blank">add_filter</a>
* <a href="https://developer.wordpress.org/reference/functions/has_filter/" target="_blank">has_filter</a>
* <a href="https://developer.wordpress.org/reference/functions/apply_filters/" target="_blank">apply_filters</a>
* <a href="https://developer.wordpress.org/reference/functions/apply_filters_ref_array/" target="_blank">apply_filters_ref_array</a>
* <a href="https://developer.wordpress.org/reference/functions/remove_filter/" target="_blank">remove_filter</a>
* <a href="https://developer.wordpress.org/reference/functions/remove_all_filters/" target="_blank">remove_all_filters</a>
* <a href="https://developer.wordpress.org/reference/functions/current_filter/" target="_blank">current_filter</a>
* <a href="https://developer.wordpress.org/reference/functions/doing_filter/" target="_blank">doing_filter</a>

**Actions**:  

* <a href="https://developer.wordpress.org/reference/functions/add_action/" target="_blank">add_action</a>
* <a href="https://developer.wordpress.org/reference/functions/has_action/" target="_blank">has_action</a>
* <a href="https://developer.wordpress.org/reference/functions/do_action/" target="_blank">do_action</a>
* <a href="https://codex.wordpress.org/Function_Reference/do_action_ref_array/" target="_blank">do_action_ref_array</a>
* <a href="https://developer.wordpress.org/reference/functions/remove_action/" target="_blank">remove_action</a>
* <a href="https://developer.wordpress.org/reference/functions/current_action/" target="_blank">current_action</a>
* <a href="https://developer.wordpress.org/reference/functions/doing_action/" target="_blank">doing_action</a>
* <a href="https://developer.wordpress.org/reference/functions/did_action/" target="_blank">did_action</a>
