<?php

namespace Origumi\Framework\Router;

class Router
{
    /**
     * Stored Routes
     */
    private static array $routes;

    /**
     * Add route to array
     */
    public static function addRoute(string $url, string $controller, string $action): void
    {
        self::$routes[$url] = [
            'controller' => $controller,
            'action' => $action,
        ];
    }

    /**
     * Dispatch Routes
     */
    public function dispatch(string $requestUri = null): bool
    {
        if (! $requestUri) {
            $requestUri = $_SERVER['REQUEST_URI'];
        }
        foreach (self::$routes as $url => $route) {
            if (preg_match($url.'/', $requestUri, $matches)) {
                $controller = new $route['controller'];
                $action = $route['action'];
                $controller->$action($matches);

                return true;
            }
        }

        return false;
    }
}
