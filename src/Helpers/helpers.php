<?php

// src/Helpers/helpers.php


if (!function_exists('wp_laravel')) {
    function wp_laravel()
    {
        return \WPLaravel\Core\Plugin::getInstance();
    }
}

if (!function_exists('wp_laravel_config')) {
    function wp_laravel_config($key, $default = null)
    {
        $config = [
            'plugin.name' => 'WP Laravel Boilerplate',
            'plugin.version' => WP_LARAVEL_PLUGIN_VERSION,
            'plugin.text_domain' => 'wp-laravel-boilerplate',
            'cache.enabled' => true,
            'cache.expiration' => 3600,
            'api.version' => 'v1',
            'api.namespace' => 'wp-laravel',
        ];
        
        return $config[$key] ?? $default;
    }
}

if (!function_exists('wp_laravel_view')) {
    function wp_laravel_view($view, $data = [])
    {
        $container = \WPLaravel\Core\Plugin::getInstance()->getContainer();
        return $container->make('view')->make($view, $data)->render();
    }
}

if (!function_exists('wp_laravel_asset')) {
    function wp_laravel_asset($path)
    {
        return WP_LARAVEL_PLUGIN_URL . 'assets/' . ltrim($path, '/');
    }
}