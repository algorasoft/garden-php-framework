<?php
namespace algorasoft\garden\middlewares;

use algorasoft\garden\Application;
use algorasoft\garden\Controller;
use algorasoft\garden\exception\ForbiddenException;

/**
 *
 * Class AuthMiddleware
 *
 * @author ROMAN ISRAEL <cto@algorasoft.com>
 * @package algorasoft\garden\middlewares
 */

class AuthMiddleware extends BaseMiddleware {
    public array $actions = [];

    /**
     * AuthMiddleware constructor
     *
     * @param array $actions
     *
     */
    public function __construct(array $actions = []) {
        $this->actions = $actions;
    }

    public function execute() {
        if (Application::isGuest()) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                throw new ForbiddenException();
            }
        }
    }
}