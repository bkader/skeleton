# Groups

Groups are one of the three (**3**) available entities types. Every entity that is not a user or an object is considered a group. Groups are everything that **gathers**, for example: 

* A blog **category** is a group of posts.
* Users groups, are groups! TADA.
* A **gallery** of images, is a group.
* A **menu** in this skeleton is a group of links... etc.

I let you think of other groups, I just gave you examples :)

* [Table Structure](#table-structure)
* [Creating Groups](#creating-groups)
* [Retrieving Groups](#retrieving-groups)
* [Searching Groups](#searching-groups)
* [Updating Groups](#updating-groups)
* [Deleting Groups](#deleting-groups)
* [Restoring Groups](#restoring-groups)
* [Counting Groups](#counting-groups)
* [IMPORTANT!](#important)

## Table Structure

![Groups Table](table_groups.png)

As you can see on the image above, the table contains only three columns:

* **guid**: Which holds groups **ID**s, used as a foreign key to get the rest from **entities** table.
* **name**: Holds groups names.
* **description** (*optional*): Holds groups descriptions if you want to.

## Creating Groups

The same way as creating **users** or **objects**, you can create groups by using the provided `create` method or its helper `add_group`. Example:

```php
/*
 * To create a group, pass an array of group's details
 * to the "create" method. Anythin that can be found
 * on "entities" and "groups" table are inserted to
 * them. Any additional arguments will be treated as
 * metadata and will be inserted into the "metadata"
 * table once the group is created.
 */
$this->kbcore->groups->create($data);
// Or you can use the helper:
add_group($data);
```

## Retrieveing Groups

Retrieving groups is easy. It can be done using a group's ID for single group retrieving, or arbitrary WHERE clause for a single or multiple groups retrieving. Examples:

```php
// Retrieve a single group by its ID.
$this->kbcore->groups->get($id);
get_group($id); // The helper.

// Retrieve a single group by arbitrary WHERE clause.
$this->kbcore->groups->get_by($field, $match);
get_group_by($field, $match); // The helper.

// To retrieve all or multiple groups by WHERE clause
$this->kbcore->groups->get_many($field, $match, $limit, $offset);
get_groups($field, $match, $limit, $offset);

// To retrieve all groups
$this->kbcore->groups->get_all($limit, $offset);
get_all_groups($limit, $offset);
```

As of version **1.3.x**, retrieved groups are instances of **KB_Group** object that you can use to retrieve or update details. Let's see how to retrieve details, the update part will be talked about in the [update section](#updating-groups).

```php
// To retrieve a group:
$group = get_group($param); // ID, username or WHERE clause.

// To retrieve data:
echo $group->username;	// Stored in "entities" table.
echo $group->name;		// Stored in "groups" table.
echo $group->something;	// Stored in "metadata" table.
```

## Searching Groups

As of version **1.3.x**, it is possible to search for groups using the `find` method or its helper `find_groups`. Let's see how you can use it and some examples:

```php
// How to use:
$groups = $this->kbcore->groups->find($field, $match, $limit, $offset);
$groups = find_groups($field, $match, $limit, $offset);

// Ordinary use:
$groups = find_groups('subtype', 'menu');  // Subype LIKE %menu%
$groups = find_groups('username', 'ian');     // Username LIKE %ian%

// Extended
$groups = find_groups(array(
	'subtype'  => 'menu_item',	// Subtype LIKE %menu_item%
	'location' => 'header',     // Have meta "location" and its LIKE %header%
));
```

## Updating Groups

You can update a single or multiple groups depending on the method or function you use. Let me explain in example:

```php
/*
 * To update a single group by its ID, pass its known
 * ID as the first argument, then an array of whatever
 * you want to update as the second argument.
 */
$this->kbcore->groups->update($id, $data);
// Or use the helper:
update_group($id, $data);

/*
 * To update a single, all or multiple groups by
 * arbitrary WHERE clause, use the "update_by"
 * method or its helpers: "update_group_by" or
 * "update_groups".
 */
 $this->kbcore->groups->update_by(
	// The first argument is the WHERE clause.
	 array('name' => 'goupname'),
	 // The second is the array of what to update.
	 array('description' => 'New description.')
 );
 // Or use helpers:
 update_group_by(...);	// Same arguments.
 update_groups(...);	// Same arguments.
```

As of version **1.3.x**, retrieved groups as instances of **KB_Group** objects. As mentioned in the [creating groups](#creating-groups) section, in order to update a group, here is what you may want to do:

```php
// Retrieve the group (example ID 99) :
$group = get_group(99);

// To directly update somthing:
$group->update('name', 'New Name'); // TRUE if updated, else false.
$group->update('description', 'New group description');

// To queue things before update:
$group->name = 'New Name'; // #1
$group->set('name', 'New Name'); // #2

// Then save them:
$group->save(); // TRUE if updated, else false.
```

**NOTE**: if you use the `set` method or directly set a detail, changes **WILL NOT** be stored in database unless to use the `save` method after. The `update` method on the other hand, will directly store the change in database.

## Deleting Groups

Part of groups data are stored in **entities** table which has **soft_delete** enabled. It means that they will not be deleted from database but only hidden from access.
When building your application up, think of what should your featured do, delete or remove.

To delete groups, you have multiple choices:

```php
// Delete a single group by its ID:
$this->kbcore->groups->delete($id);
delete_group($id);

// To delete a single, all or multiple groups:
$this->kbcore->groups->delete_by($field, $match);
delete_group_by($field, $match);
delete_groups($field, $match);
```

Deleting multiple groups accept various arguments combination. Below are some examples on how to do it:

```php
// Delete multiple groups by IDs:
delete_groups('id', array(1, 12, 23));

// Delete by their IDs and subtypes:
delete_groups(array(
	'subtype' => 'groups_subtypes',
	'id'      => array(1, 12, 23, 34),
));
```

**NOTE** This is the hard delete part, may be you should consider what to do before using the following methods.

Groups can be completely removed from database, as well as all things related to them (metadata, variables ... etc). There are several methods and functions you may use, they are the same as the delete methods, simply remplace `delete` with `remove`.

```php
// Remove by its ID.
$this->kbcore->groups->remove($id);
remove_group($id);

// Arbitrary WHERE clause.
$this->kbcore->groups->remove_by($field, $match);
remove_group_by($field, $match);
remove_groups($field, $match);
```

## Restoring Groups

Only **soft-deleted** groups can be restored! Not **removed** ones, these ones are completely erased. To restore groups you do like the example below:

```php
// Restore a single group by ID.
$this->kbcore->>groups->restore($id);
// Or you can use the helper:
restore_group($id);

// To restore multiple groups.
$this->kbcore->>groups->restore_by($field, $match);
// Or group can use helpers:
restore_group_by($field, $match);
restore_groups($field, $match);
```

## Counting Groups

In order to count groups, you can use the **count** method or its helper **count_groups**. They both accept two arguments used to filter groups before returning the count.
```php
$this->kbcore->groups->count($field, $match);
count_groups($field, $match);
```

---  

## IMPORTANT

All methods and functions are to be used in controllers. In case you want to use them in libraries, make sure to never use helpers because they may trigger an `undefined property: $kbcore` error.
