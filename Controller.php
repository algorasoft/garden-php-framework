<?php
namespace algorasoft\garden;

use algorasoft\garden\middlewares\BaseMiddleware;

/**
 *
 * Class Controller
 *
 * @author ROMAN ISRAEL <cto@algorasoft.com>
 * @package algorasoft\garden
 */

Class Controller {

    public string $layout = 'main';
    public string $action = '';
    /**
     * @var \algorasoft\garden\middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [];

    public function render($view, $params = []) {
        return Application::$app->view->renderView($view, $params);
    }

    public function setLayout(string $layout) {
        $this->layout = $layout;
    }

    public function registerMiddleware(BaseMiddleware $middleware) {
        $this->middlewares[] = $middleware;
    }

    public function getMiddlewares(): array{
        return $this->middlewares;
    }

}