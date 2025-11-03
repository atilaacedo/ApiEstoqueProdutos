<?php

namespace App\Router;

class Router
{

    private $routes = [];

    private $request = null;
    
    public function addRoute($method, $path, $callback)
    {
        $regexPath = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[^/]+)', API_PATH . $path);
      
        $this->routes[] = [
            'method' => $method,
            'path' => API_PATH .  $path,
            'regex_path' => '/^' . str_replace('/', '\/', $regexPath) . '$/',
            'callback' => $callback
        ];

    }


    public function dispatch($method, $path)
    {

        $path = rtrim($path, '/');
    
        foreach ($this->routes as $route) {
            if ($route['method'] === $method ) {
                if(preg_match($route['regex_path'], $path, $matches)){
                  
                    $params = [];
                    foreach ($matches as $key => $value) {
                        if (is_string($key)) {
                            $params[$key] = $value;
                        }
                    }
                    if($method === 'POST' || $method === 'PUT'){
                        $this->request['data'] = $this->getJsonPostData();
                    }
                    $this->request['params'] = $params;
                    

                    return $this->getController($route['callback'], $this->request);
                } 
            }
        }
        

        throw new \Exception("Route not found", 404);
    }

    public function getController($callback, $request) {
       
        [$controller, $method] = explode('@', $callback);

        $controller = "App\\Controllers\\{$controller}";
        if (!class_exists($controller)) {
            throw new \Exception("Controller not found: {$controller}", 404);
        }

        $controllerInstance = new $controller();
        if (!method_exists($controllerInstance, $method)) {
            throw new \Exception("Method not found: {$method} in {$controller}", 404);
        }

        return $controllerInstance->$method($request);
    }

    public function getJsonPostData() {

    if (!isset($_SERVER['CONTENT_TYPE']) || strpos($_SERVER['CONTENT_TYPE'], 'application/json') === false) {
        return ['error' => 'Content-Type must be application/json'];
    }

    $jsonData = file_get_contents('php://input');

    $data = json_decode($jsonData, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return ['error' => 'Invalid JSON: ' . json_last_error_msg()];
    }

    return $data;
}
}
