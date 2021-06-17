<?php
namespace algorasoft\garden\db;

use algorasoft\garden\Application;

/**
 *
 * Class Database
 *
 * @author ROMAN ISRAEL <cto@algorasoft.com>
 * @package algorasoft\garden
 */

class Database {

    public \PDO $pdo;
    /**
     * Database Constructor
     *
     */
    public function __construct(array $config) {
        $dsn      = $config['dsn'] ?? '';
        $user     = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations() {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations     = [];
        $files             = \scandir(Application::$rootDir . '/migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);

        foreach ($toApplyMigrations as $migration) {
            if ('.' === $migration || '..' === $migration) {
                continue;
            }

            require_once Application::$rootDir . '/migrations/' . $migration;
            $className = \pathinfo($migration, PATHINFO_FILENAME);
            $instance  = new $className();
            $this->log("Applying migration $migration");
            $instance->up();
            $this->log("Applied migration $migration");
            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log('All migrations are applied');
        }
    }

    public function createMigrationsTable() {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations(
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration varchar(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;");
    }

    public function getAppliedMigrations() {
        $stmt = $this->pdo->prepare("SELECT `migration` FROM `migrations`");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migrations) {
        $str  = implode(",", array_map(fn($m) => "('$m')", $migrations));
        $stmt = $this->pdo->prepare("INSERT INTO `migrations` (migration) VALUES $str");
        $stmt->execute();
    }

    public function prepare($sql) {
        return $this->pdo->prepare($sql);
    }

    protected function log($message) {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }

}