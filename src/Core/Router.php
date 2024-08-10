<?php

namespace App\Core;

class Router
{
    private $routes = [];

    public function add($path, $callback, $method = 'GET', $middleware = [])
    {
        // Convertir parámetros de ruta a expresiones regulares
        $path = preg_replace('/\{([a-z]+)\}/', '(?P<$1>[^/]+)', $path);
        $path = '#^' . $path . '$#';
        $this->routes[$method][$path] = ['callback' => $callback, 'middleware' => $middleware];
    }

    public function dispatch()
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes[$method] as $pattern => $route) {
            if (preg_match($pattern, $url, $matches)) {
                $params = array_intersect_key($matches, array_flip(array_filter(array_keys($matches), 'is_string')));

                foreach ($route['middleware'] as $middleware) {
                    $middlewareInstance = new $middleware;
                    if (!$middlewareInstance->handle()) {
                        return;  // Stop further execution if middleware fails
                    }
                }

                $callback = $route['callback'];
                if (is_callable($callback)) {
                    call_user_func_array($callback, $params);
                } else if (is_string($callback)) {
                    $this->callControllerWithParams($callback, $params);
                }
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    private function callControllerWithParams($callback, $params)
    {
        list($controller, $method) = explode('@', $callback);
        $controller = "App\\Controllers\\$controller";
        if (class_exists($controller)) {
            $controllerObject = new $controller();
            if (method_exists($controllerObject, $method)) {
                call_user_func_array([$controllerObject, $method], $params);
            } else {
                http_response_code(404);
                echo "404 Method Not Found";
            }
        } else {
            http_response_code(404);
            echo "404 Controller Not Found";
        }
    }
}
