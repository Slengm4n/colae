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
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remove a pasta base (BASE_URL) da URI da requisição
        $uri = '/'; // Valor padrão para a raiz
        if (strpos($requestUri, BASE_URL) === 0) {
            $uri = substr($requestUri, strlen(BASE_URL));
        }

        // Garante que a URI comece com uma barra e não termine com uma (a menos que seja a raiz)
        if (empty($uri) || $uri[0] !== '/') {
            $uri = '/' . $uri;
        }
        if (strlen($uri) > 1) {
            $uri = rtrim($uri, '/');
        }

        // Descomente as linhas abaixo para depurar e ver exatamente qual URI o roteador está a tentar encontrar
        // echo "Método: " . $method . "<br>";
        // echo "URI Processada: " . $uri;
        // echo "<pre>";
        // print_r($this->routes[$method]);
        // echo "</pre>";
        // die();

        // Procura uma correspondência exata primeiro
        if (isset($this->routes[$method][$uri])) {
            $this->executeHandler($this->routes[$method][$uri]);
            return;
        }

        // Se não encontrou, procura por rotas com parâmetros dinâmicos (ex: /editar/{id})
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

        // Se nada correspondeu, envia o 404
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
                $this->sendNotFound("Método '{$methodName}' não encontrado no controller '{$handler[0]}'.");
            }
        } else {
            $this->sendNotFound("Handler da rota não é válido.");
        }
    }

    private function sendNotFound($message = "Página não encontrada pelo Roteador")
    {
        http_response_code(404);
        echo "<h1>404 - {$message}</h1>";
    }
}
