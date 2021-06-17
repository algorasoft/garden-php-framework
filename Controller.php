<?php
namespace app\core;

use app\core\middlewares\BaseMiddleware;

/**
 *
 * Class Controller
 *
 * @author ROMAN ISRAEL <cto@algorasoft.com>
 * @package app\core
 */

Class Controller {

    public string $layout = 'main';
    public string $action = '';
    /**
     * @var \app\core\middlewares\BaseMiddleware[]
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