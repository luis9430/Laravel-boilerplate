<?php
// src/Hooks/HookManager.php
namespace WPLaravel\Hooks;

class HookManager
{
    protected $hooks = [
        ExampleHook::class,
    ];
    
    public function register()
    {
        foreach ($this->hooks as $hookClass) {
            $hook = new $hookClass();
            $hook->register();
        }
    }
}