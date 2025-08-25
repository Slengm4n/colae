<?php

class Router
{
    private $routes = [];

    public function get($path, $handler)
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post($path, $handler)
    {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute($method, $path, $handler)
    {
        $this->routes[strtoupper($method)][$path] = $handler;
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        // Lê a URI corretamente, sem depender de $_GET['url']
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Remove a pasta base do projeto da URI
        $basePath = '/colae';
        if (strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        if (strlen($uri) > 1) {
            $uri = rtrim($uri, '/');
        }

        if (empty($uri)) {
            $uri = '/';
        }


        if (isset($this->routes[$method][$uri])) {
            $this->executeHandler($this->routes[$method][$uri]);
            return;
        }


        // Lógica para encontrar a rota, incluindo parâmetros dinâmicos
        foreach ($this->routes[$method] as $routePath => $handler) {
            if (strpos($routePath, '{') !== false) {
                $pattern = preg_replace('/\\{([a-zA-Z0-9_]+)\\}/', '(?P<$1>[^/]+)', $routePath);
                $pattern = '#^' . $pattern . '$#';

                if (preg_match($pattern, $uri, $matches)) {
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    $this->executeHandler($handler, $params);
                    return;
                }
            }
        }

        $this->sendNotFound();
    }

    private function executeHandler($handler, $params = [])
    {
        if (is_callable($handler)) {
            call_user_func_array($handler, $params);
        } elseif (is_array($handler) && class_exists($handler[0])) {
            $controller = new $handler[0]();
            $methodName = $handler[1];
            if (method_exists($controller, $methodName)) {
                call_user_func_array([$controller, $methodName], $params);
            } else {
                $this->sendNotFound();
            }
        } else {
            $this->sendNotFound();
        }
    }

    private function sendNotFound()
    {
        http_response_code(404);
        echo "<h1>404 - Página não encontrada pelo Roteador</h1>";
    }
}
