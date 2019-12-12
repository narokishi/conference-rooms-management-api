<?php
declare(strict_types=1);

namespace App\Infrastructure;

use App\Infrastructure\InfrastructureException\InvalidMigrationException;
use App\Infrastructure\InfrastructureException\MigrationDoesNotExistsException;
use App\Infrastructure\Migration\CreateUsersTable;

/**
 * Class Migrator
 *
 * @package App\Infrastructure
 */
final class Migrator extends AbstractDatabaseAccessObject
{
    /**
     * @var string[]
     */
    private array $migrations = [
        CreateUsersTable::class,
    ];

    /**
     * @return void
     */
    public function runAll(): void
    {
        foreach ($this->migrations as $migration) {
            $this->runSingle($migration);
        }
    }

    /**
     * @return void
     */
    public function downAll(): void
    {
        foreach ($this->migrations as $migration) {
            $this->downSingle($migration);
        }
    }

    /**
     * @param string $migrationClassName
     *
     * @return void
     */
    private function runSingle(string $migrationClassName): void
    {
        $this->getMigrationClass($migrationClassName)->run();
    }

    /**
     * @param string $migrationClassName
     *
     * @return void
     */
    private function downSingle(string $migrationClassName): void
    {
        $this->getMigrationClass($migrationClassName)->down();
    }

    /**
     * @param string $migrationClassName
     *
     * @return AbstractMigration
     */
    private function getMigrationClass(string $migrationClassName): AbstractMigration
    {
        if (!class_exists($migrationClassName)) {
            throw new MigrationDoesNotExistsException($migrationClassName);
        }

        if (!is_a($migrationClassName, AbstractMigration::class, true)) {
            throw new InvalidMigrationException($migrationClassName);
        }

        return new $migrationClassName($this->db);
    }
}
