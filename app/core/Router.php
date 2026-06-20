<?php
/**
 * AutoHub LK — Simple Router
 *
 * Routes map URL patterns to Controller@method.
 * Supports named params: /vehicles/{id}
 */

class Router
{
    private array $routes = [];

    public function get(string $pattern, string $handler): void
    {
        $this->addRoute('GET', $pattern, $handler);
    }

    public function post(string $pattern, string $handler): void
    {
        $this->addRoute('POST', $pattern, $handler);
    }

    public function any(string $pattern, string $handler): void
    {
        $this->addRoute('ANY', $pattern, $handler);
    }

    private function addRoute(string $method, string $pattern, string $handler): void
    {
        $this->routes[] = [
            'method'  => $method,
            'pattern' => $pattern,
            'handler' => $handler,
        ];
    }

    public function dispatch(string $url, string $requestMethod): void
    {
        $url = '/' . trim($url, '/');

        foreach ($this->routes as $route) {
            if ($route['method'] !== 'ANY' && $route['method'] !== strtoupper($requestMethod)) {
                continue;
            }

            $pattern = $route['pattern'];

            // Convert {param} placeholders to named capture groups
            $regex = preg_replace('/\{([a-zA-Z_]+)\}/', '(?P<$1>[^/]+)', $pattern);
            $regex = '#^' . $regex . '$#';

            if (preg_match($regex, $url, $matches)) {
                // Extract named params
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                [$controllerName, $method] = explode('@', $route['handler']);

                $controllerFile = APP_ROOT . '/app/controllers/' . $controllerName . '.php';
                if (!file_exists($controllerFile)) {
                    http_response_code(500);
                    die('Controller not found: ' . htmlspecialchars($controllerName));
                }
                require_once $controllerFile;

                if (!class_exists($controllerName)) {
                    http_response_code(500);
                    die('Controller class not found: ' . htmlspecialchars($controllerName));
                }

                $controller = new $controllerName();

                if (!method_exists($controller, $method)) {
                    http_response_code(500);
                    die('Method not found: ' . htmlspecialchars($method));
                }

                call_user_func_array([$controller, $method], $params);
                return;
            }
        }

        // No route matched — 404
        http_response_code(404);
        require_once APP_ROOT . '/app/controllers/HomeController.php';
        $c = new HomeController();
        $c->notFound();
    }
}
