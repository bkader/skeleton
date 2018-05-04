Static Routes
===============
Inspired by <a href="https://github.com/jamierumbelow/pigeon" target="_blank">Pigeon</a> and <a href="https://laravel.com/docs/5.6/routing" target="_blank">Laravel's routing system</a> and based on both <a href="https://github.com/Patroklo/codeigniter-static-laravel-routes" target="_blank">@Patroklo's</a> and <a href="https://cibonfire.com/docs/developer/routes" target="_blank">Bonfire's</a> libraries, this class was added to this project to give more flexibility and let Codeigniter work with static routes as simmilar to the Laravel routing as possible.

## Routing

You can use all available methods to define your routes. The final result will be automatically generated.

### Basic Usage

Basic methods are the following:

```php
// we use "test" and the controller example.
Route::get('test',            'test/index');
Route::post('test/(:any)',    'test/create/$1');
Route::put('test/(:any)',     'test/update/$1');
Route::delete('test/(:any)',  'test/delete/$1');
Route::head('test/(:any)',    'test/index');
Route::patch('test/(:any)',   'test/update/$1');
Route::options('test/(:any)', 'test/load/$1');
```

For a more generic routing no matter what HTTP method is, you can use:

```php
Route::any('test', 'test/index');
```

### Named Routes

Named routes are a useful way to avoid calling the route again an again. All you have to do is to name the route you want, then wherever you want to use it, call it.

```php
// To name a route.
Route::any('test', 'test/index', array('as' => 'test'));

// To retrieve it:
echo Route::named('test'); // Or
redirect(Route::named('test'));
```

### Route Groups

This allows you to add a prefix to all routes inside of it. Useful for defining context routes, the admin area for example.

```php
Route::prefix('admin', function() {
    Route::any('test', 'test/admin/index');
});
```

Here is another way to define groups:

```php
Route::any('admin', 'admin/index', array('as' => 'admin'), function() {
    Route::any('test', 'test/admin/index');
});
// Or
Route::any('admin', 'admin/index', function() {
    Route::any('test', 'test/admin/index');
});
```

### RESTful Routes.

Using the `resources` method will automatically generate all RESTful-like routes for you:

```
Route::resources('users');
// Outputs:
GET     /users             index       displaying a list of users
GET     /users/new         add         return an HTML form for creating a user
GET     /users/{id}        view        display a specific user
GET     /users/{id}/edit   edit        return the HTML form for editing a single user
POST    /users             create      create a new user
PUT     /users/{id}        update      update a specific user
DELETE  /users/{id}        delete      delete a specific user
```

### Contexts

To automatically generate automatic routes, you can also use the `context` method.

```
Route::context('users')
// Output:
users/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)       $1/users/$2/$3/$4/$5/$6
users/(:any)/(:any)/(:any)/(:any)/(:any)              $1/users/$2/$3/$4/$5
users/(:any)/(:any)/(:any)/(:any)                     $1/users/$2/$3/$4
users/(:any)/(:any)/(:any)                            $1/users/$2/$3
users/(:any)/(:any)                                   $1/users/$2
users/(:any)                                          $1/users
```

### Blocking Routes

Sometimes we want to block direct access to a routed area. To do so, use the `block` method:

```php
Route::block('users');
```

### Generating Routes

In order to routes to be generated, make sure to add at the very bottom of the `application/config/routes.php` (and only this file):

```php
$route = Route::map($route);
```
