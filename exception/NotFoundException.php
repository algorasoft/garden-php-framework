<?php
namespace algorasoft\garden\exception;

/**
 *
 * Class ForbiddenException
 *
 * @author ROMAN ISRAEL <cto@algorasoft.com>
 * @package algorasoft\garden\exception
 */

class NotFoundException extends \Exception {
    protected $message = 'Page not found';
    protected $code    = 404;
}