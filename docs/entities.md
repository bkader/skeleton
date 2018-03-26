# Entities

* [Definition](#definition)
* [Creating Entities](#creating-entities)
* [Updating Entities](#updating-entities)
* [Deleting Entities](#deleting-entities)
* [Restoring Entities](#restoring-entities)
* [Retrieving Entities](#retrieving-entities)
* [Bonus](#bonus)
* [More Details](#more-details)
* [IMPORTANT!](#important)

## Definition

All what's on the website is considered to be an **entity**. Users, groups, and objects are all entities. The reason behind this approach if to have real **Global Unique IDs** and unique usernames. This way, if you displaying the entity's page is done by simply going to "*site_url/__username__*".
In fact, if you take a look at **entities** table, you will see that there are two columns that determine the real type of an entity: **type** and **subtype**.
* **Type** tells on which table to retrieve the rest of the data.
* **subtype** tells only the real type of the entity.

For instance, an entity of type **user** is treated as a user where the rest of data is stores in **users** table, **group** in **groups** table and **object** in **objects** table. These are the only allowed types but you are free to assign any **subtype** you want while building your application (see respective documentations for more details).

## Creating Entities

If you take a peak at entities library, the **create** method, you will see that it checks four (**4**) things before creating the entity:
1. The method has received arguments (*array*).
2. The entity's *type* is set and is one of the three mentioned above.
3. The entity's *subtype* is set.
4. The entity's *username* is available.

So you make sure all these conditions are full-filled before proceeding.

In order to create a new entity, you may use the **create** method or its helper **add_entity** like so:

```php
// $guid is the new create entity's ID.
$guid = $this->kbcore->entities->create(array(
	'type'     => 'user',
	'subtype'  => 'administrator',
	'username' => 'bkader',
	'language' => 'arabic',
	'privacy'  => 1,
...
));
// Of its helper:
$guid = add_entity(...);
```
As you have certainly noticed, these method and function will always return the new created entity's **ID** IF created, otherwise they will return `FALSE`.
If the provided username is already in use, this method/function we generate a new one for it, appending a number to to.

## Updating Entities

There are two (**2**) method to update entities (+3 helpers). The **update** method targets a single entity and it uses its **ID** or **username** because they are the unique values on the table. The **update_by** method will target a single, mutiple or even all entities.  Example:
```php
/*
 * In order to update a single entity by its given ID,
 * simple pass the ID as the first argument, then an
 * array of what you want to update as the second
 * argument.
 */
$this->kbcore->entities->update($id, array(
	'username' => 'new_username', // An example only.
));
update_entity($id, ...); // The helper.

// To update a single, all or multiple entities:
$this->kbcore->entities->update_by(
	// The first argument (array) is WHERE clause.
	array('username', 'bkader'),
	// The second array is what to update.
	array('privacy' => 2, 'subtype' => 'administrator')
);
update_entity_by(...);	// Same argumetns.
update_entities(...);	// Same arguments.
```
**Note**: These method and functions can be used to target a single entity as well as long as you use unique values columns for the *WHERE* clause. Example:
```php
$this->kbcore->entities->update_by(
	// Where id=1
	array('id' => 1),
	// Change username.
	array('username' => 'new_username')
);
```
Also, the *WHERE* clause is arbitrary, so if you simply pass an array of data, all your entities will be updated (**$data** must always be the last OR unique argument).

## Deleting Entities

The difference between **delete** and **remove** is obvious. The first one marks the entity as **deleted** but keeps all its data on the database while the other one **erases** it completely from the database and walks through all other tables in order to remove all what's related to it.

In order to delete/remove a single entity, you can do:
```php
$this->kbcore->entities->delete($id); // ID or username.
$this->kbcore->entities->remove($id); // ID or username.
// Or you can user helpers:
delete_entity($id);
remove_entity($id);
```
To delete/remove a single, all or multiple entities by arbitrary WHERE clause, you can do like the following:
```php
$this->kbcore->entities->delete_by($field, $match);
$this->kbcore->entities->remove_by($field, $match);
// Or their respective helpers:
delete_entity_by(...); // Alias: delete_entities(...);
remove_entity_by(...); // Alias: remove_entities(...);
```
The **match** argument is optional in case **field** is an array. Let's see some examples (We will use **delete** only because it's done the same way for remove).
```php
// Delete an entity with username "bkader".
$this->kbcore->entities->delete_by('username', 'bkader');

// Delete multiple entities where ID in array.
$this->kbcore->entities->delete_by('id', array(1, 7, 13));

// Delete multiple entities by arbitrary WHERE clause.
$this->kbcore->entities->delete_by(array(
	'type'         => 'user',
	'enabled'      => 0,
	'created_at <' => (DAY_IN_SECONDS * 2), // Added constant.
));
```
In the last example, we are deleting all **users** accounts that have not been activated and that were created 2 days ago (It would be better to **remove** them instead don't you think?).

## Restoring Entities

Unfortunatly, entities that were **removed** they can **NO LONGER** be restored, they are permanently erased from database and all what's related to them to. But, those that were **deleted** or better, flagged as deleted, can be restored anytime using the examples below:
```php
// If you want to restore a single entity:
$this->kbcore->entities->restore($id); // ID or username.
// Or its helper:
restore_entity($id);

// In case you want to restore multiple entities:
$this->kbcore->entities->restore_by($field, $match);
// Or its helper:
restore_entity_by(...); // restore_entities(...);
```
**Note**: _restore_entity_by_ and _restore_entities_ are certainly used to restore multiple entities, but they can also be used to restore a single entity by arbitrary _WHERE_ clause. Example:

```php
/*
 * Did you figure out why it is targetting a single
 * row? Well, simply because usernames are unique :)
 * The same goes with IDs and even email addresses for
 * users.
 */
$this->kbcore->entities->restore_by('username', 'bkader');
```

## Retrieving Entities

Three (**3**) method and their helpers are available to retrieve entities.
In order to retrieve a single entity, you have two options:

```php
// #1: Retreiving the entity by its ID or username.
$this->kbcore->entities->get($id);
get_entity($id); // The helper.

// #2: Retrieve a single entity by arbitrary WHERE clause
$this->kbcore->entities->get_by($field, $match);
get_entity_by($field, $match); // The helper.

// #3: In case you want to retrieve multiple entities:
$this->kbcore->entities->get_many($field, $match);
get_entities($field, $match); // The helper.
```
If the method or function used in the example **#3** are used without any arguments, they will return array of all existing entities.
Let's see a more elaborated example:
```php
// This will retrieve all entities of type "user".
get_entities('type', 'user');

// This will retrieve all entities of type "user"
// and subtype "administrator".
get_entities(array(
	'type'    => 'user',
	'subtype' => 'administrator',
));

// Retrieve all users groups where privacy > 1
get_entities(array(
	'type'      => 'group',
	'subtype'   => 'users',
	'privacy >' => 1,
));
```
*Play with it the way you want*.

## Bonus

There are additional method that may be useful when developing your application.
```php
// To retrieve entities IDs only:
$ids = $this->kbcore->entities->get_all_ids($field, $match);
// Or the helper:
get_entities_ids($field, $match);

/*
 * In the example below, we are trying to get all users
 * IDs WHERE roles (subtypes) are "administrator" OR
 * "moderaotr" for example.
 */
get_entities_ids(
	'subtype',
	array('administrator', 'moderator')
);
// Use your imagination :D
```

## More Details

Let's us now talk in depth about **entities** an their table.

![Entities Table](table_entities.png)

If you check the table, the most important columns are:

- __parent_id__: This is useful if you want to make your entities hierarchical.
- __owner_id__: If a group or object is created by a user, it's a good practice to put his/her id there. Not only that, if for instane objects belong to a given group, this column is also useful to say that the group owns those objects ... etc ! *Use your imagination*.
- __type__: Entities types are important. There are three types of entities: **user**, **group** and **object**. To know more about them, please refer to their corresponding documentation.
- __subtype__: This is the column that plays the biggest role. All of your site's entities are divided into subtypes **YOU CHOOSE**. For instance, the provided **menus** module stores menus as **group** entities while using **menu** as the **subtype**. This module store menus items (links) as **object** entities while using **menu_item** as **subtype**... ect! *Use your imagination*.
- __username__: This is one of the unique columns (with ID). It is an optional column for certain entities that do not require usernames but are necessary for others (such as users).
- __language__: Even if it is an optional column, it comes handy if you want to make your website multilingual. For instance, if a user uses **french**, when he/she logs in, the site's language changes. If you store static pages for insteace and you want to translate them, you can store their languages there as well.
- __privacy__: This is as well an optional column with default value **2**. The idea behind this is to make entities access by privacy level. By default, we are using:
	- __-1__: For entities accessible to owners only.
	- __0__: For entities accessible to owners only. If you allow users to follow each other for instance or develop a friendship system between users, this can be used to display entities for entities in relation with the owner only.
	- __1__: For entities accessible to registered and logged in users.
	- __2__: For entities that are publicaly accessible.

Other columns, *enabled*, *deleted*, *created_at*, *updated_at* and *deleted_at* are automatically handled so you don't worry about them.
**Note**: The *deleted* column is the one used to **soft delete** entities. It is set to **1** after deletion and the *deleted_at* will hold the timestamp.

## IMPORTANT

All methods and functions are to be used in controllers. In case you want to use them in libraries, make sure to never use helpers because they will trigger an `undefined property: $kbcore` error.
