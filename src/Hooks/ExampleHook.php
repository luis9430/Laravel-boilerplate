<?php

// src/Hooks/ExampleHook.php
namespace WPLaravel\Hooks;

class ExampleHook
{
    public function register()
    {
        // Actions
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminScripts']);
        
        // Filters
        add_filter('the_content', [$this, 'filterContent']);
        
        // Shortcodes
        add_shortcode('wp_laravel_example', [$this, 'exampleShortcode']);
    }
    
    public function enqueueScripts()
    {
        wp_enqueue_script(
            'wp-laravel-frontend',
            WP_LARAVEL_PLUGIN_URL . 'assets/js/frontend.js',
            ['jquery'],
            WP_LARAVEL_PLUGIN_VERSION,
            true
        );
        
        wp_localize_script('wp-laravel-frontend', 'wpLaravel', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wp_laravel_nonce'),
            'apiUrl' => home_url('/wp-json/wp-laravel/v1/')
        ]);
        
        wp_enqueue_style(
            'wp-laravel-frontend',
            WP_LARAVEL_PLUGIN_URL . 'assets/css/frontend.css',
            [],
            WP_LARAVEL_PLUGIN_VERSION
        );
    }
    
    public function enqueueAdminScripts($hook)
    {
        if (strpos($hook, 'wp-laravel') === false) {
            return;
        }
        
        wp_enqueue_script(
            'wp-laravel-admin',
            WP_LARAVEL_PLUGIN_URL . 'assets/js/admin.js',
            ['jquery', 'wp-api'],
            WP_LARAVEL_PLUGIN_VERSION,
            true
        );
        
        wp_enqueue_style(
            'wp-laravel-admin',
            WP_LARAVEL_PLUGIN_URL . 'assets/css/admin.css',
            [],
            WP_LARAVEL_PLUGIN_VERSION
        );
    }
    
    public function filterContent($content)
    {
        if (is_singular('wp_laravel_example')) {
            $content .= '<div class="wp-laravel-meta">';
            $content .= get_post_meta(get_the_ID(), '_example_meta_key', true);
            $content .= '</div>';
        }
        
        return $content;
    }
    
    public function exampleShortcode($atts)
    {
        $atts = shortcode_atts([
            'id' => '',
            'class' => 'wp-laravel-example'
        ], $atts);
        
        $output = '<div class="' . esc_attr($atts['class']) . '">';
        $output .= 'Example Shortcode Content';
        $output .= '</div>';
        
        return $output;
    }
}
