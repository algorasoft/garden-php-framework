<?php
namespace algorasoft\garden\form;
use algorasoft\garden\Model;

/**
 *
 * Class Form
 *
 * @author ROMAN ISRAEL <cto@algorasoft.com>
 * @package algorasoft\garden\form
 */

class Form {
    public static function begin($action, $method) {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }

    public static function end() {
        echo '</form>';
    }

    public function field(Model $model, $attribute) {
        return new InputField($model, $attribute);
    }
}