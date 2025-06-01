<?php
// src/Hooks/ExampleHook.php
namespace WPLaravel\Hooks;

use WPLaravel\Controllers\ExampleController; 
use WPLaravel\Core\Plugin;

class ExampleHook
{
    public function register()
    {
        // Actions
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminScripts']);

    }
    
    public function enqueueScripts()
    {
        wp_enqueue_script(
            'wp-laravel-frontend',
            WP_LARAVEL_PLUGIN_URL . 'assets/dist/js/frontend.min.js', // Asumiendo que tienes un frontend.min.js compilado
            ['jquery'],
            WP_LARAVEL_PLUGIN_VERSION,
            true
        );
        
        wp_localize_script('wp-laravel-frontend', 'wpLaravelFrontendData', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wp_laravel_frontend_nonce'), // Un nonce diferente si es necesario
            'apiUrl' => home_url('/wp-json/wp-laravel/v1/')
        ]);
        
        wp_enqueue_style(
            'wp-laravel-frontend-styles', 
            WP_LARAVEL_PLUGIN_URL . 'assets/dist/css/frontend.min.css', 
            [],
            WP_LARAVEL_PLUGIN_VERSION
        );
    }
    
    public function enqueueAdminScripts($hook_suffix) // Parámetro correcto es $hook_suffix
    {
        
        if ($hook_suffix !== 'toplevel_page_wp-laravel') {
            return;
        }
        
        wp_enqueue_script(
            'wp-laravel-admin', 
            WP_LARAVEL_PLUGIN_URL . 'assets/dist/js/admin.min.js', 
            ['jquery', 'wp-api'], 
            WP_LARAVEL_PLUGIN_VERSION,
            true 
        );
        
        $exampleController = new ExampleController(); 
        
        $initialAdminData = []; 
        if (method_exists($exampleController, 'getInitialDataForAdminPage')) {
            $initialAdminData = $exampleController->getInitialDataForAdminPage();
        }

        // Datos a localizar para admin.js
        $localizedData = array_merge(
            [
                'ajaxUrl'     => admin_url('admin-ajax.php'),
                'apiNonce'    => wp_create_nonce('wp_rest'), // Nonce para la REST API de WP
                'pluginApiUrl'=> home_url('/wp-json/wp-laravel/v1/'), // URL base de tu API REST personalizada
                // Puedes añadir más datos globales aquí si es necesario
            ], 
            $initialAdminData // Los datos específicos que preparaste para Preact
        );
        
        wp_localize_script(
            'wp-laravel-admin',    
            'wpLaravelAdminData',  
            $localizedData    
        );
        
        wp_enqueue_style(
            'wp-laravel-admin-styles', 
            WP_LARAVEL_PLUGIN_URL . 'assets/dist/css/admin.min.css', 
            [],
            WP_LARAVEL_PLUGIN_VERSION
        );
    }   
}