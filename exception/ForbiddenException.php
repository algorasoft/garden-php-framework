<?php
namespace algorasoft\garden\exception;

/**
 *
 * Class ForbiddenException
 *
 * @author ROMAN ISRAEL <cto@algorasoft.com>
 * @package algorasoft\garden\exception
 */

class ForbiddenException extends \Exception {
    protected $message = 'You don\'t have permission to access this page';
    protected $code    = 403;
}