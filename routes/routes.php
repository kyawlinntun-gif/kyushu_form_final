<?php
class Router
{
    private $routes = [];
    // Register a GET route
    public function get($uri, $callback)
    {
        $this->addRoute('GET', $uri, $callback);
    }
    // Register a POST route
    public function post($uri, $callback)
    {
        $this->addRoute('POST', $uri, $callback);
    }
    // Helper to register routes
    private function addRoute($method, $uri, $callback)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'callback' => $callback
        ];
    }
    // Dispatch the route
    public function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['uri'] === $uri) {
                // Call the callback for the route
                echo call_user_func($route['callback']);
                return;
            }
        }
        // Return a 404 if no route matches
        echo "404 Not Found";
    }
    public function redirect($uri)
    {
        // Redirect the user to a different URI and stop further script execution
            header("Location: $uri");
            exit;
        }
    }
