<?php
/**
 * Plugin Name: Laravel demos 
 * Description: Demos de sistema de pagos y worrkflow con Laravel.
 * Version: 1.0.0
 * Author: Luis Chavez
 * Text Domain: laravel-boilerplate
 */

// Prevenir acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Definir constantes del plugin
define('WP_LARAVEL_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('WP_LARAVEL_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WP_LARAVEL_PLUGIN_VERSION', '1.0.0');

// Cargar Composer autoloader
require_once WP_LARAVEL_PLUGIN_PATH . 'vendor/autoload.php';

// Inicializar el plugin
use WPLaravel\Core\Plugin;

// Activación y desactivación hooks
register_activation_hook(__FILE__, [Plugin::class, 'activate']);
register_deactivation_hook(__FILE__, [Plugin::class, 'deactivate']);

// Iniciar el plugin
add_action('plugins_loaded', function() {
    Plugin::getInstance()->init();
});
