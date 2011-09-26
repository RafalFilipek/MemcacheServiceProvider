Memcache Service Provider
=========================
Memcache Service Provider provides easy integration with Memcache - nothing less nothing more.


Installation (clone)
------------
    cd /path/to/your/project
    git clone git://github.com/RafalFilipek/MemcacheServiceProvider.git vendor/rafal/src/Rafal/MemcacheServiceProvider

Installation (submodule)
------------------------
    cd /path/to/your/project
    git submodule add git://github.com/RafalFilipek/MemcacheServiceProvider.git vendor/rafal/src/Rafal/MemcacheServiceProvider

Registering
-----------
    $app['autoloader']->registerNamespace('Rafal', __DIR__.'/vendor/rafal/src');
    $app->register(new Rafal\MemcacheServiceProvider\MemcacheServiceProvider());

Options
-------
* ```memcache.class``` - `\Memcache` or `\Memcached`. Default `\Memcache`
* ```memcache.wrapper``` - Your custom Memcache wrapper. Default `Rafal\MemcacheServiceProvider\MemcacheWrapper`
* ```memcache.connections``` - list of memcache connnections provided as array of connection. Each connections should be defined like `array('127.0.0.1', 11211)`.

Example
-------
Lets say you have DoctrineServiceProvider enabled and you want to fetch some data from User table.

    $app['autoloader']->registerNamespace('Rafal', __DIR__.'/vendor/rafal/src');
    $app->register(new Rafal\MemcacheServiceProvider\MemcacheServiceProvider());
    $app['memcache']->get('user.7', function() use($app) { 
        return $app['db']->fetchAssoc('SELECT * FROM Users WHERE id = 7')
    });
    $app['memcache']->set('some.data', array('some' => 'data')));
    $app['memcache']->delete('some.data');

As you can see ```get``` method allows you to pass as a second argument function which will be executed if data are not exists in memcache. This functionality is provided by ```MemcacheWrapper```.

License
-------
Memcache Service Provider is licensed under the MIT license.