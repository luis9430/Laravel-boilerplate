<?php 

// src/Middleware/AuthMiddleware.php
namespace WPLaravel\Middleware;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle($request, $next)
    {
        if (!is_user_logged_in()) {
            wp_die('Unauthorized access', 'Unauthorized', ['response' => 401]);
        }
        
        return $next($request);
    }
}