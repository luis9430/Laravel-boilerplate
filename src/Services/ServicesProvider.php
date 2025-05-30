<?php

namespace WPLaravel\Services;

abstract class ServiceProvider
{
    protected $container;
    
    public function __construct($container)
    {
        $this->container = $container;
    }
    
    abstract public function register();
    
    abstract public function boot();
}