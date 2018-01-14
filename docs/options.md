# Options

* [What are options?](#markdown-header-what-are-options)  
* [Creating Options](#markdown-header-creating-options)
* [Updating Options](#markdown-header-updating-options)
* [Deleting Options](#markdown-header-deleting-options)
* [Retrieving Options](#markdown-header-retrieving-options)
* [IMPORTANT!](#markdown-header-important)  

## What are options?
Options are simply site settings stored in **options** table. Even if this table is empty, options are still found and they are stored inside *skeleton/config/defaults.php* file.  

### Creating Options:
In order to create new options, you can do like in the example below: 

	$this->app->options->create($name, $value);
	// Or the helper:
	add_option($name, $value);

If you want to display the option on the administration panel, make sure to complete all arguments and edit the corresponding controller and view to display it. Example:

	$this->app->options->create(
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

To display it, go to *skeleton/modules/settings/controllers/Admin.php* and edit the section you have choose as **tab** (or add a new one and don't forget to add the view and edit other views so they include the link to it).

### Updating Options:
To update an option, you can use the **set_item** method or its helper **set_option**, like so:

	$this->app->options->set_item($name, $new_value);
	// Or the helper:
	set_option($name, $new_value);
**Note**: These functions will create the item if it does not exist. So you can use it to add options as well BUT, you cannot add extra arguments: **tab**, **field_type**, **options** and **required**.

### Deleting Options:
To delete a single option, you can use in your controllers:

	$this->app->options->delete($name);
	// Or the helper:
	delete_option($name); // i.e: delete_option('site_name');

To delete multiple options, you can use the following:  

	$this->app->options->delete_by($field, $match);
	// Or the helper:
	delete_option_by(...); // Alias: delete_options(...);

### Retrieving Options:
If you want to retrieve a single options, you can do like the following:  

	$this->app->options->get($name); // Returns an object if found.

	// The method below returns the value if found, else $default.
	$this->app->options->item($name, $default);
	// Or its helper:
	get_option($name, $default);

If you want to retrieve multiple options, you do do like so:

	$this->app->options->get_many($field, $match);
	// Or the helper:
	get_options($field, $match);

## IMPORTANT:
All methods and functions are to be used in controllers. In case you want to use them in libraries, make sure to never use helpers because they will trigger an `undefined property: $app` error.
