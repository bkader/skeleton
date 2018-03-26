# Kbcore Library

This is the main library that handles almost everything on the applications. It has several drivers that you can use (see: entities, groups, users, metadata, variables, options ... etc).

## What does it do?
Well, it loads everything that the application needs (libraries, helpers, config ... etc).

## Methods
Available methods to be used are limited. After all, this is not attended to be used at all, its drivers are to be used, not this library. However, here are methods available:

### set_meta
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

### send_email
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
