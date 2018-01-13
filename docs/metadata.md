
# Metadata
As their name means, these are additional informations about an existing entity. The difference between them and **variables** is that these are kind of permanent informations that do get updated but not as often as variables do.  

## How yo use?  
There are four (**4**) important methods (or functions if you want) that you can use:  
* **create()** (or *add_meta()*);
* **update()** (or *update_meta()*);
* **get()** (or *get_meta()*);
* **delete()** (or *delete_meta()).

There is another method available that you can use but we will leave it for later.  

### Creating metadata.  
After creating the entity you want (user, group or object), you can (MUST) use its ID to create metadata for it. In your controllers, you can use:  

    // To create a single metadata.
    $this->app->metadata->create($guid, $name, $value);
    // Or you can use the function:
    add_meta($guid, $name, $value);
    // $guid here is the entity's ID.
If you want to create multiple metadata for the selected entity, you only need to pass an associative array as the second parameter like so:

    $this->app->metadata->create($guid, array(
        'phone' => '0123456789',
        'company' => 'Company Name',
        'location' => 'Algeria',
        'address', // (1)
        'website', // (2)
    ), $value);
    // "address" and "website" have not values, so they will be
    // created by but they will use the third argument ($value) 
    // as a value. Default: NULL

### Update Metadata.
To update a metadata, you can use either the **update** method or the **update_meta** function. So in your controllers, you can do like the following:  

    // To update a single metadata.
    $this->app->metadata->update($guid, $name, $value);
    // Or use the helper function:
    update_meta($guid, $name, $value)
To update multiple metadata, pass an array as the second parameter like so:

    $this->app->metadata->update($guid, array(
        'phone' => '0987654321',
        'company' => 'New Company',
        'address', // <- Same as create, it will use $value
        'website' => 'https://www.ianhub.com/'
    ), $value);
    // Or use the helper function:
    update_meta(...)

**NOTE**: This method or its helper will not only update the selected metadata but they will create it if it does not exists. So you can use it to create metadata as well.

### Deleting Metadata.
In order to delete metadata, you can use the method **delete** or the helper **delete_meta**. So in your controllers, you may have:

    // Delete a single metadata.
    $this->app>metadata($guid, $name);
    // Or if you use the helper:
    delete_meta($guid, $name);
To delete multiple metadata, you have two options, pass an array as the second parameter, or cascade parameters like the example below:

    // Let's say I want to delete "phone" and "company".
    // Option 1:
    $this->app->metadata->delete($guid, ['phone', 'company']);
    // Option 2:
    $this->app->metadata->delete($guid, 'phone', 'company');
    
    // You can use the helper function:
    delete_meta(...); // The same as above.
### Retrieving Metadata.
You can retrieve metadata by using the **get** method or the **get_meta** function. Theses functions accept three (**3**) arguments:  
* **$guid**: (*int*) which is the entity's ID.
* **$name**: (*string*) if empty, you will get all metadata for that entity; if you pass a string, you will get the selected metadata.
* **$single**: (*boolean*) this is useful in cas you want to retrieve the value of metadata directly instead of retrieving the whole object.

So in your controllers, you would have:

    // The following code will retrieve the phone object from
    // database if found, otherwise it returns NULL.
    $meta = $this->app->metadata->get($guid, 'phone');
    // Or:
    $meta = get_meta($guid, 'phone');
    
    // In this case, to retrieve the phone number you do:
    $phone = $meta->value; // Outputs: '0123456789' if found.
If you want to retrieve the value instead of the object, you can do:  

    $phone = $this->app->metadata->get($guid, 'phone', TRUE);
    // Or:
    $phone = get_meta($guid, 'phone', TRUE);
    
    // Here, $phone = '0123456789'.

If you want to retrieve all metadata of the selected entity, just use its ID and ignore other arguments:

    $metadata = $this->app->metadata->get($guid);
    // Or
    $metadata = get_meta($guid);

### What is the other method/function?
Sometimes users, objects or groups are deleted from **entities** table. And because they no longer exist, it is kind of useless to keep their metadata, this is why the **purge** method or **purge_meta** function were added.  
These funtions will simply delete ALL metadata of entity's that do not exist. That's all. To use them:

    $this->app->metadata->purge();
    // OR
    purge_meta();
## IMPORTANT:
All methods and functions are to be used inside controllers. In case you want to use them inside libraries, make sure to never use helpers because they will trigger and `undefined property: $app`  error.
