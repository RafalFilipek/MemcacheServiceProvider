<?php

namespace Rafal\MemcacheServiceProvider;

class MemcacheWrapper {
    
    protected $memcache;

    public function __construct($memcache)
    {
        $this->memcache = $memcache;
    }

    public function get($id, \Closure $fallback = null)
    {
        $result = $this->memcache->get($id);
        if ($result === false && $fallback instanceof \Closure) {
            $result = $fallback();
            $this->memcache->set($id, $result);
        }
        return $result;
    }

    public function set($id, $data, $expiration = 0)
    {
        return $this->memcache->set($id, $data, $expiration);
    }

    public function delete($id, $time = 0)
    {
        return $this->memcache->delete($id, $time);
    }

    public function flush()
    {
        return $this->memcache->flush();
    }
}