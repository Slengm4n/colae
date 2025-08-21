<?php

class Router
{
    private $routes = [];

    private function addRoute($method, $path, $handler)
    {
        $this->routes[strtoupper($method)][$path] = $handler;
    }

    public function get($path, $handler)
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post($path, $handler)
    {
        $this->addRoute('POST', $path, $handler);
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = '/' . trim($_GET['url'] ?? '', '/');

        $handler = $this->routes[$method][$path] ?? null;

        if ($handler) {
            if (is_callable($handler)) {
                call_user_func($handler);
            } elseif (is_array($handler) && class_exists($handler[0])) {
                $controller = new $handler[0]();
                $methodName = $handler[1];
                if (method_exists($controller, $methodName)) {
                    $controller->$methodName();
                } else {
                    $this->sendNotFound();
                }
            }
        } else {
            $this->sendNotFound();
        }
    }

    private function sendNotFound()
    {
        http_response_code(404);
        echo "<h1>404 - Página não encontrada</h1>";
    }
}
