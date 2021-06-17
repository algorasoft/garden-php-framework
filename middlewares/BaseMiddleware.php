<?php
namespace algorasoft\garden\middlewares;

/**
 *
 * Class BaseMiddleware
 *
 * @author ROMAN ISRAEL <cto@algorasoft.com>
 * @package algorasoft\garden\middlewares
 */

abstract class BaseMiddleware {
    abstract public function execute();
}