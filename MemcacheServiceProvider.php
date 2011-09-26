<?php

namespace Rafal\MemcacheServiceProvider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class MemcacheServiceProvider implements ServiceProviderInterface {
    
    public function register(Application $app)
    {
        $app['memcache'] = $app->share(function() use ($app) {
            if (isset($app['memcache.wrapper'])) {
                $lib = $app['memcache.wrapper'] === false ? false : $app['memcache.wrapper'];
            } else {
                $lib = 'Rafal\MemcacheServiceProvider\MemcacheWrapper';
            }
            if (!isset($app['memcache.class'])) {
                $class = '\Memcache';
            } else {
                $class = $app['memcache.class'];
                if (!in_array($class = $app['memcache.class'], array('\Memcache', '\Memcached'))) {
                    throw new \Exception("Unknow class {$class}. Please set 'Memcache' or 'Memcached'");
                }
            }
            $memcacheInstance = new $class;
            $connections = isset($app['memcache.connections']) ? $app['memcache.connections'] : array(array('127.0.0.1', 11211));
            foreach ($connections as $connection) {
                call_user_func_array(array($memcacheInstance, 'addServer'), array_values($connection));
            }
            if ($lib !== false) {
                $memcache = new $lib($memcacheInstance);
            } else {
                $memcache = $memcacheInstance;
            }
            return $memcache;
        });
    }
}