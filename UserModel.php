<?php
namespace algorasoft\garden;

use algorasoft\garden\db\DbModel;

/**
 *
 * Class UserModel
 *
 * @author ROMAN ISRAEL <cto@algorasoft.com>
 * @package algorasoft\garden
 */

abstract Class UserModel extends DbModel {
    abstract public function getDisplayName(): string;
}