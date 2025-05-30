<?php

// src/Traits/Singleton.php
namespace WPLaravel\Traits;

trait Singleton
{
    private static $instance = null;
    
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }
        
        return self::$instance;
    }
    
    private function __construct()
    {
        $this->init();
    }
    
    private function __clone() {}
    
    private function __wakeup() {}
    
    protected function init() {}
}
