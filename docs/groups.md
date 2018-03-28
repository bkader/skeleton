Groups are one of the three (**3**) available entities types. Every entity that is not a user or an object is considered a group. Groups are everything that **gathers**, for example: 

* A blog **category** is a group of posts.
* Users groups, are groups! TADA.
* A **gallery** of images, is a group.
* A **menu** in this skeleton is a group of links... etc.

I let you think of other groups, I just gave you examples :)

## Table Structure

![Groups Table](table_groups.png)

As you can see on the image above, the table contains only three columns:

* **guid**: Which holds groups **ID**s, used as a foreign key to get the rest from **entities** table.
* **name**: Holds groups names.
* **description** (*optional*): Holds groups descriptions if you want to.

## Creating Groups

The same way as creating **users** or **objects**, you can create groups by using the provided **create** method or its helper **add_group**. Example:
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
`This is the hard delete part, may be you should consider what to do before using the following methods.`

Groups can be completely removed from database, as well as all things related to them (metadata, variables ... etc). There are several methods and functions you may use, they are the same as the delete methods, simply remplace **delete** with **remove**.
```php
// Remove by its ID.
$this->kbcore->groups->remove($id);
remove_group($id);

// Arbitrary WHERE clause.
$this->kbcore->groups->remove_by($field, $match);
remove_group_by($field, $match);
remove_groups($field, $match);
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

## Counting Groups

In order to count groups, you can use the **count** method or its helper **count_groups**. They both accept two arguments used to filter groups before returning the count.
```php
$this->kbcore->groups->count($field, $match);
count_groups($field, $match);
```

---  

## IMPORTANT

All methods and functions are to be used in controllers. In case you want to use them in libraries, make sure to never use helpers because they may trigger an `undefined property: $kbcore` error.
