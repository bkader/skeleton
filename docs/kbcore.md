# Kbcore Library

**Kbcore Library** is the main library that handles almost everything on the applications. It has several drivers that you can use (see: entities, groups, users, metadata, variables, options ... etc).  
Despite having some methods you may use, all it does is loading everything that the application needs (libraries, helpers, config ... etc).

## Methods
Available methods to be used are limited. After all, this is not intended to be often used, its drivers are but not it. Here are methods available:

**set_meta**

This method takes an object or an array as argument and uses it in order to generate all needed **meta** tags output on the head section. Example:
```php
/*
 * Let's suppose I created a controller that displays
 * static pages stored in the database. When getting
 * the page, I get its object/array, so I can use the
 * method on my controller like so:
 */
$page = $this->pages->get($slug); // Example only.
$this->kbcore->set_meta($page); // That's all.
```

**send_email**

This method is used to send an email, it's kind of a shortcut only. It will handles email configuration and everything before sending the email. You can use it like so:
```php
// Simple way:
$this->kbcore->send_email($to, $subject, $message, $cc, $bcc);
// Example:
$this->kbcore->send_email(
	'bkader@mail.com',
	'Hello There',
	'This is the mssage'
);

// You can use a view as an email message (html):
$this->kbcore->send_email(
	'bkader@mail.com',
	'Hello There',
	$this->load->view('emails/test', $data, true)
);
```

**where**

Available since version **1.3.0**, this is the main method that generates the WHERE clause for any used library or model. Simply call it before executing queries.  

```php
// Start with it.
$this->kbcore->where($field, $match, $mlimit, $offset);

// Then continue with query builder.
$result = $this->db->get('your_table');

// In case be chainable:
$result = $this->kbcore
	->where($field, $match, $limit, $offset)
	->get('your_table');
```

**find**

Also available since version **1.3.0**, unlike the `where` method, this one is used for search purposes because it uses `LIKE` for building queries.

```php
// Start with it.
$this->kbcore->find($field, $match, $mlimit, $offset, $type);

// Then continue with query builder.
$result = $this->db->get('your_table');

// In case be chainable:
$result = $this->kbcore
	->find($field, $match, $limit, $offset)
	->get('your_table');
```

**NOTE**: Make sure to use **type** ONLY if you are searching for entities (users, groups or objects). Don't use it for anything else.

## In Depth

Both `where` and `find` method accept complex queries building. Nothing is better than example to explain. We are targeting users, and because the **Kbcore_users** library getters use the `where` method to generate the query. The `Kbcore_users::find()` on the other hand, uses `find`.

```php
// Get all users of rank "premium":
$users = get_users('subtype', 'premium');

// If you want to limit the result (to 10 for instance):
$users = get_users('subtype', 'premium', 10);

// Get users of rank "premium" but ignore known IDs.
$users = get_users(array(
	'subtype' => 'premium',
	'!id'     => array(1, 11, 111),
));

// Get users where username is user1 or user2
$users = get_users(array(
	'username'    => 'user1',
	'or:username' => 'user2',
));

/**
 * Let's suppose we have registered users of different companies,
 * but both companies names have "ian" somewhere in their names.
 * NOTE: companies are stored in metadata table.
 */
$users = find_users('company', 'ian');
```

If you noticed, we used `or:_field_` to generate the `OR WHERE`. Here all available options:

* `or:!_field_`: used to generate the `OR WHERE _field_ NOT IN(...)`.
* `or:_field_`: used to generate the `OR WHERE _field_ IN(...)` for arrays or `OR WHERE _field_` for single value.
* `!_field_`: used to generate the `WHERE _field_ NOT IN(...)`.

For any other option, please CodeIgniter options:

* `_field_ !=`
* `_field_ <=` or `_field_ <`
* `_field_ >=` or `_field_ >`
