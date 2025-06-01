<?php

namespace App\Router;

class Router
{

    private $routes = [];

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

                    return $this->getController($route['callback'], $params);
                } 
            }
        }
        

        throw new \Exception("Route not found", 404);
    }

    public function getController($callback, $params) {
       
        [$controller, $method] = explode('@', $callback);

        $controller = "App\\Controllers\\{$controller}";
        if (!class_exists($controller)) {
            throw new \Exception("Controller not found: {$controller}", 404);
        }

        $controllerInstance = new $controller();
        if (!method_exists($controllerInstance, $method)) {
            throw new \Exception("Method not found: {$method} in {$controller}", 404);
        }

        if (empty($params)) {
            return $controllerInstance->$method();
        } else {
            return $controllerInstance->$method(...array_values($params));
        }
    }
}
