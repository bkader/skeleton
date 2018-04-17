Custom Libraries
==============

Several libraries were added to ensure the application stays on the flow.

* [KB_Form_validation.php](#kb_form_validationphp)
* [KB_Table.php](#kb_tablephp)
* [Bcrypt.php](#bcryptphp)
* [Format.php](#formatphp)
* [Hash.php](#hashphp)
* [Plugins.php](#pluginsphp)
* [Route.php](#routephp)
* [Theme.php](#themephp)

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
