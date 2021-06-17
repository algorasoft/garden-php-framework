<?php
namespace app\core\exception;

/**
 *
 * Class ForbiddenException
 *
 * @author ROMAN ISRAEL <cto@algorasoft.com>
 * @package app\core\exception
 */

class NotFoundException extends \Exception {
    protected $message = 'Page not found';
    protected $code    = 404;
}