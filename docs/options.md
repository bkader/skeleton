# Options

* [What are options?](#what-are-options)
* [Creating Options](#creating-options)
* [Updating Options](#updating-options)
* [Deleting Options](#deleting-options)
* [Retrieving Options](#retrieving-options)
* [IMPORTANT!](#important)

## What are options?
Options are simply site settings stored in **options** table. Even if this table is empty, options are still found and they are stored inside *skeleton/config/defaults.php* file.
![Options Table](table_options.png)

## Creating Options
In order to create new options, you can do like in the example below:
```php
// $data here is an array of data to insert.
$this->kbcore->options->create($data);

// Similar method but with lots of arguments:
$this->bkcore->add_item(
	$name,
	$value = null,
	$tab = '',
	$field_type = 'text',
	$options = '',
	$required = true
);
// Or the helper:
add_option(...); // Same arguments.
```

If you want to display the option on the administration panel, make sure to complete all arguments and edit the corresponding controller and view to display it. Example:
```php
$this->kbcore->options->create(
	'allow_registration',	// The option's name.
	true,					// The options's value.
	'users',				// On which tab to display.
	'dropdown',				// Type of the form input (select).
	array(					// Available dropdown options
		'true' => 'Yes',	// Or: 'lang:yes' to translate.
		'false' => 'No',	// Or 'lang:no' to translate.
	),
	true					// Make the field required
);
```
To display it, go to *skeleton/modules/settings/controllers/Admin.php* and edit the section you have choose as **tab** (or add a new one and don't forget to add the view and edit other views so they include the link to it).

## Updating Options
Several methods are available in order to update a single or multiple options. Let me explain with few examples:
```php
/*
 * To update a single option by its name, use it as
 * the first argument. THe second argument should be
 * an array of whatever you want to update (value,
 * tab, field_type, options or required).
 */
$this->kbcore->options->update($name, $data);

/*
 * In case you want to only update the value of the
 * option, you may use to the method above, but there
 * is another method that use can use to achieve this.
 */
$this->kbcore->options->set_item($name, $new_value);
set_option($name, $new_value); // The helper.
```

## Deleting Options
You may delete a single, all or multiple options by arbitrary WHERE clause. See examples below:
```php
// Delete a single option by its name.
$this->kbcore->options->delete($name);
delete_option($name); // The helper.

/*
 * The method below may be used to delete a single,
 * all, or multiple options by arbitrary WHERE clause.
 */
$this->kbcore->options->delete_by($field, $match);
delete_option_by($field, $match);
delete_options($field, $match);
```
## Retrieving Options
It is possible to retrieve a single, all or multiple options by arbitrary WHERE clause. See examples below:
```php
// Retrieve a single option by its name.
$this->kbcore->options->get($name);

// Retrieve a single option by arbitrary WHERE clause.
$this->kbcore->options->get_by($field, $name);

// Retrieve multiple options by arbitrary WHERE clause.
$this->kbcore->options->get_many($field, $name);

// Retrieve ALL options.
$this->kbcore->options->get_all($limit, $offset);

/*
 * The method below returns the option's value if
 * found, otherwise, it returns the second argument
 * if set (use as the default returned value).
 */
$this->kbcore->item($name, $default);
get_option($name, $default); // The helper.
```
## IMPORTANT
All methods and functions are to be used in controllers. In case you want to use them in libraries, make sure to never use helpers because they will trigger an `undefined property: $kbcore` error.
