<?php 

// src/Controllers/BaseController.php
namespace WPLaravel\Controllers;

use Illuminate\Container\Container;

abstract class BaseController
{
    protected $container;
    
    public function __construct()
    {
        $this->container = Container::getInstance();
    }
    
    protected function view($view, $data = [])
    {
        return $this->container->make('view')->make($view, $data)->render();
    }
    
    protected function json($data, $status = 200)
    {
        wp_send_json($data, $status);
    }
}