<?php

// src/Cache/CacheManager.php
namespace WPLaravel\Cache;

class CacheManager
{
    protected $prefix = 'wp_laravel_';
    protected $defaultExpiration = 3600; // 1 hora
    
    public function get($key, $default = null)
    {
        $value = get_transient($this->prefix . $key);
        
        return $value !== false ? $value : $default;
    }
    
    public function set($key, $value, $expiration = null)
    {
        $expiration = $expiration ?? $this->defaultExpiration;
        
        return set_transient($this->prefix . $key, $value, $expiration);
    }
    
    public function delete($key)
    {
        return delete_transient($this->prefix . $key);
    }
    
    public function flush()
    {
        global $wpdb;
        
        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s",
                '_transient_' . $this->prefix . '%'
            )
        );
        
        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s",
                '_transient_timeout_' . $this->prefix . '%'
            )
        );
    }
    
    public function remember($key, $callback, $expiration = null)
    {
        $value = $this->get($key);
        
        if ($value === null) {
            $value = $callback();
            $this->set($key, $value, $expiration);
        }
        
        return $value;
    }
}
