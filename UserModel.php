<?php
namespace app\core;

use app\core\db\DbModel;

/**
 *
 * Class UserModel
 *
 * @author ROMAN ISRAEL <cto@algorasoft.com>
 * @package app\core
 */

abstract Class UserModel extends DbModel {
    abstract public function getDisplayName(): string;
}