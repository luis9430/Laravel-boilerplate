<?php

// src/Events/EventManager.php
namespace WPLaravel\Events;

use Illuminate\Events\Dispatcher;

class EventManager
{
    protected $dispatcher;
    
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    
    public function dispatch($event, $payload = [])
    {
        return $this->dispatcher->dispatch($event, $payload);
    }
    
    public function listen($events, $listener)
    {
        return $this->dispatcher->listen($events, $listener);
    }
    
    public function subscribe($subscriber)
    {
        return $this->dispatcher->subscribe($subscriber);
    }
}