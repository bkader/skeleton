Custom Helpers
==============

CodeIgniter helpers are great, but that are some cool functions that we would love to have. Here is a list of custom helpers we have added:

* [admin_helper.php](#admin_helperphp)
* [KB_array_helper.php](#kb_array_helperphp)
* [KB_directory_helper.php](#kb_directory_helperphp)
* [KB_file_helper.php](#kb_file_helperphp)
* [KB_form_helper.php](#kb_form_helperphp)
* [KB_html_helper.php](#kb_html_helperphp)
* [KB_security_helper.php](#kb_security_helperphp)
* [KB_string_helper.php](#kb_string_helperphp)
* [KB_url_helper.php](#kb_url_helperphp)

## admin_helper.php

This helper is loaded once on the dashboard section. It contains only one function for the moment but we will create other if needed.

`label_condition`: displays a Bootstrap label component depending of the provided condition status.

```php
$cond = true;
echo label_condition($cond, 'lang:active', 'lang:inactive'); // Yes, it handles translations.
```

## KB_array_helper.php

Few functions have been added and more to come if needed:

* `array_keys_exist`: Takes an array of keys and make sure they all exist in the array.
* `keys_in_array`: Takes an array of keys and check in at least one of them is present..

```php
array_keys_exist($keys, $array);
keys_in_array($keys, $array);
```

## KB_directory_helper.php

We added only two functions but, if needed, we may add more in the future:

* `directory_delete`: Delete all directory's files and subdirectories.
* `directory_files`: Returns a list of all files in the selected directory and all its subdirectories up to 100 levels deep.

## KB_file_helper.php

For the sake for security and functionality, we have added several functions:

* `validate_file`: validates a file name and path against an allowed set of rules.
* `check_file_md5`: Calculates the MD5 of the selected file then compares it to the expected value.
* `get_file_data`: Retrieve metadata from the selected file. It is used to retrieve themes and plugins details and any thing you may developer in the future.
* `unzip_file`: (thank your WordPress) this function is used by themes and plugins modules to upload ZIP archives and install files. If you develop something that may use this function.

The `unzip_file` is automatic and should be used. In fact, it only checks if the `ZipArchive` to use it via the `_unzip_file_ziparchive` function. If the class does not exists, if will use a third party library `PclZip` via the `_unzip_file_pclzip` function.

## KB_form_helper.php

It contains only three functions new functions created for the purpose of Skeleton project, and two more to extend CodeIgniter functions.

* `print_input`: Prints a form input with possibility to add extra attributes instead of using array_merge on views.
* `validation_errors_list`: Return form validation errors in custom HTML list. Default: unordered list.
* `_translate`: Used by `print_input`, This function simply attempts to translate a string if it finds "lang:" at the start of it.

Functions that extend CodeIgniter are:

* `safe_form_open`: Function for creating the opening portion of the form, but with a secured action using "safe_url" from KB_url_helper.
* `safe_form_open_multipart`: Function for creating the opening portion of the form, but with "multipart/form-data" and a secured action using "safe_url".

## KB_html_helper.php

It contains three functions:

* `img`: that simply inverts $attributes and $index_page of the original CodeIgniter `img` function.
* `html_tag`: it generates any type of HTML tags within your PHP code.
* `build_list` (**experimental**): created to be used later for the menu builder, it is right there for the moment until we fully develop it. It takes and array and built a `<ul>` list.

## KB_security_helper.php

* `sanitize`: Sanitizes the given string using `strip_slashes` and `xss_clean` functions.
* `generate_safe_token`: Generates the safe token token used by other function that start with `safe_`.

## KB_string_helper.php

* `readable_random_string`: it does the same thing as Codeigniter `random_string` function, except that the result is a human-readable random string.
* `mask_string`: yes, it mask a given string. For instance, you want to hide email addresses and keep only few characters at the beginning and the end, you can use it:

```php
echo mask_string('myemail@address.com', 2, 2, '*');
// Outputs: my***************om
```

## KB_url_helper.php

For the sake of this project, several functions were added and some were added to override CodeIgniter functions:

* `anchor`: override default function in order to translate `$title` if it starts with `lang:...`. Example: `echo anchor('uri', 'lang:home');`
* `anchor_popup`: same as the one above it, it override default function to automatically translate titles.
* `current_url`: overrides CodeIgniter default function so we can add `$_GET` parameters.

* `trace_url` and `trace_anchor`: they simply append a `$_GET` parameter to URLs so you can use them for tracking purposes. Outputs something like `..com/whetever?trk=form_btn`.
* `safe_url` and `safe_anchor`: use a lot in the project for security purposes, their URLs contain extra `$_GET` parameters `token` and `ts` that you can check on the next request for security using the `check_safe_url` function.

For the other functions, we will use **x** that will refer to : **admin**, **ajax**, **process** and **api**.

* `x_url` and `x_anchor`.
* `safe_x_url` and `safe_x_anchor`.

The last function is `build_safe_url` used to generate tokens for function with `safe_` at the beginning.
