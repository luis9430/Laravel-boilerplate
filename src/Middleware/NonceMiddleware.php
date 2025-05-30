<?php 

// src/Middleware/NonceMiddleware.php
namespace WPLaravel\Middleware;

class NonceMiddleware implements MiddlewareInterface
{
    public function handle($request, $next)
    {
        $nonce = $request['nonce'] ?? $_REQUEST['_wpnonce'] ?? '';
        
        if (!wp_verify_nonce($nonce, 'wp_laravel_nonce')) {
            wp_die('Security check failed', 'Security Error', ['response' => 403]);
        }
        
        return $next($request);
    }
}
