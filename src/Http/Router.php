<?php

// src/Http/Router.php
namespace WPLaravel\Http;

use WPLaravel\Controllers\ExampleController;
use WPLaravel\Api\ExampleApiController;

class Router
{
    public function register()
    {
        // Registrar rutas AJAX
        add_action('wp_ajax_wp_laravel_example_store', [$this, 'handleExampleStore']);
        add_action('wp_ajax_nopriv_wp_laravel_example_store', [$this, 'handleExampleStore']);
        
        // Registrar rutas REST API
        add_action('rest_api_init', [$this, 'registerRestRoutes']);
        
        // Registrar rutas admin
        add_action('admin_menu', [$this, 'registerAdminMenus']);
    }
    
    public function handleExampleStore()
    {
        $controller = new ExampleController();
        $controller->store();
    }
    
    public function registerRestRoutes()
    {
        register_rest_route('wp-laravel/v1', '/examples', [
            [
                'methods' => 'GET',
                'callback' => [new ExampleApiController(), 'index'],
                'permission_callback' => '__return_true',
            ],
            [
                'methods' => 'POST',
                'callback' => [new ExampleApiController(), 'create'],
                'permission_callback' => function() {
                    return current_user_can('edit_posts');
                },
            ],
        ]);
        
        register_rest_route('wp-laravel/v1', '/examples/(?P<id>\d+)', [
            [
                'methods' => 'GET',
                'callback' => [new ExampleApiController(), 'show'],
                'permission_callback' => '__return_true',
            ],
            [
                'methods' => 'PUT',
                'callback' => [new ExampleApiController(), 'update'],
                'permission_callback' => function() {
                    return current_user_can('edit_posts');
                },
            ],
            [
                'methods' => 'DELETE',
                'callback' => [new ExampleApiController(), 'delete'],
                'permission_callback' => function() {
                    return current_user_can('delete_posts');
                },
            ],
        ]);
    }
    
    public function registerAdminMenus()
    {
        add_menu_page(
            'WP Laravel',
            'WP Laravel',
            'manage_options',
            'wp-laravel',
            [$this, 'renderAdminPage'],
            'dashicons-admin-generic',
            30
        );
    }
    
    public function renderAdminPage()
    {
        $controller = new ExampleController();
        echo $controller->index();
    }
}