<?php
// src/Controllers/ExampleController.php
namespace WPLaravel\Controllers;

use WPLaravel\Models\Example;
use WP_User; // Para el tipado de wp_get_current_user()

class ExampleController extends BaseController
{
    public function index()
    {
        return $this->view('examples.index', [
            'pageTitle' => __('Panel de Administración Preact', 'wp-laravel-boilerplate')
        ]);
    }

    /**
     * Obtiene los datos iniciales necesarios para la aplicación Preact.
     * @return array
     */
    public function getInitialDataForAdminPage(): array
    {
        $currentUser = wp_get_current_user();
        $userName = ($currentUser instanceof WP_User && $currentUser->ID !== 0) ? $currentUser->display_name : __('Invitado', 'wp-laravel-boilerplate');
        $userId = ($currentUser instanceof WP_User && $currentUser->ID !== 0) ? $currentUser->ID : null;

        // Datos de WooCommerce (ejemplo básico)
        $woocommerceData = [
            'is_active' => class_exists('WooCommerce'), // Verifica si WooCommerce está activo
            'currency_symbol' => class_exists('WooCommerce') ? get_woocommerce_currency_symbol() : '$',
            // Para una prueba real de conteo de productos, necesitarías una consulta.
            // Por ahora, un placeholder o un conteo simple si WC está activo.
            'product_count' => 0, 
        ];

        if ($woocommerceData['is_active']) {
            $product_query = new \WP_Query(['post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => -1]);
            $woocommerceData['product_count'] = $product_query->found_posts;
        }

        return [
            'currentUser' => [
                'name' => $userName,
                'id' => $userId,
            ],
            'pluginInfo' => [
                'name' => wp_laravel_config('plugin.name', 'Mi Plugin WP Laravel'),
                'version' => WP_LARAVEL_PLUGIN_VERSION,
            ],
            'woocommerce' => $woocommerceData,
            // Puedes añadir más datos iniciales aquí
            // 'initialExamples' => Example::active()->take(3)->get()->toArray(),
        ];
    }

    // ... (tus métodos store() y show() pueden permanecer si los usas para otras cosas)
}