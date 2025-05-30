<?php
// src/Middleware/MiddlewareInterface.php
namespace WPLaravel\Middleware;

interface MiddlewareInterface
{
    public function handle($request, $next);
}
