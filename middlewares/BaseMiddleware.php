<?php
namespace app\core\middlewares;

/**
 *
 * Class BaseMiddleware
 *
 * @author ROMAN ISRAEL <cto@algorasoft.com>
 * @package app\core\middlewares
 */

abstract class BaseMiddleware {
    abstract public function execute();
}