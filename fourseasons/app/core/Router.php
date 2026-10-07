<?php

declare(strict_types=1);

namespace App\Core;

final class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    public function post(string $path, array $handler): void
    {
        $this->add('POST', $path, $handler);
    }

    private function add(string $method, string $path, array $handler): void
    {
        $this->routes[] = [$method, trim($path, '/'), $handler];
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = $this->normalize($uri);
        foreach ($this->routes as [$m, $path, $handler]) {
            $pattern = preg_replace('#\{([a-zA-Z_]+)\}#', '(?P<$1>[^/]+)', $path);
            $pattern = '#^' . $pattern . '$#';
            if ($m === strtoupper($method) && preg_match($pattern, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $this->invoke($handler, $params);
                return;
            }
        }
        http_response_code(404);
        if (class_exists(\App\Controllers\ErrorController::class)) {
            (new \App\Controllers\ErrorController())->notFound();
            return;
        }
        echo '404';
    }

    private function invoke(array $handler, array $params): void
    {
        [$class, $action] = $handler;
        $controller = new $class();
        $controller->$action(...array_values($params));
    }

    private function normalize(string $uri): string
    {
        if ($uri === '') {
            $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
            $script = dirname($_SERVER['SCRIPT_NAME'] ?? '');
            if ($script !== '/' && $script !== '\\' && str_starts_with($path, $script)) {
                $path = substr($path, strlen($script));
            }
            $uri = $path;
        }
        $uri = trim($uri, '/');
        if (str_starts_with($uri, 'index.php')) {
            $uri = trim(substr($uri, 9), '/');
        }
        return $uri;
    }
}
