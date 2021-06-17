<?php
namespace algorasoft\garden;

use algorasoft\garden\exception\NotFoundException;

/**
 *
 * Class Router
 *
 * @author ROMAN ISRAEL <cto@algorasoft.com>
 * @package algorasoft\garden
 */

Class Router {
    public Request $request;
    public Response $response;
    protected array $routes = [];

    /**
     * Router Constructor
     *
     * @param algorasoft\garden\Request $request
     * @param algorasoft\garden\Response $response
     */

    public function __construct(Request $request, Response $response) {
        $this->request  = $request;
        $this->response = $response;
    }

    public function get($path, $callback) {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve() {
        $path     = $this->request->getPath();
        $method   = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if (false === $callback) {
            throw new NotFoundException();
        }
        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }
        if (is_array($callback)) {
            /** @var \algorasoft\garden\Controller $controller */
            $controller                   = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action           = $callback[1];
            $callback[0]                  = $controller;

            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }
        return call_user_func($callback, $this->request, $this->response);
    }
}