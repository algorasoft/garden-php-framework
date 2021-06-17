<?php
namespace algorasoft\garden;

/**
 *
 * Class Response
 *
 * @author ROMAN ISRAEL <cto@algorasoft.com>
 * @package algorasoft\garden
 */

Class Response {

    public function setStatusCode(int $code) {
        http_response_code($code);
    }

    public function redirect(string $url) {
        header("Location: " . $url);
    }

}