<?php
declare(strict_types=1);

namespace App\Infrastructure;

use App\Infrastructure\InfrastructureException\TableAlreadyExistsException;
use App\Infrastructure\InfrastructureException\TableDoesNotExistsException;

/**
 * Class AbstractMigration
 *
 * @package App\Infrastructure
 */
abstract class AbstractMigration extends AbstractDatabaseAccessObject
{
    /**
     * @const string
     */
    public const DEFAULT_SCHEMA_NAME = 'public';

    /**
     * @return void
     */
    abstract public function run(): void;

    /**
     * @return void
     */
    abstract public function down(): void;

    /**
     * @param string $sqlStatement
     * @param string $tableName
     * @param string $schemaName
     *
     * @return string
     */
    final protected function prepareStatement(
        string $sqlStatement,
        string $tableName,
        string $schemaName = 'public'
    ): string {
        return str_replace(
            '%table',
            $schemaName . '.' . $tableName,
            $sqlStatement
        );
    }

    /**
     * @param string $tableName
     * @param string $schemaName
     *
     * @return void
     * @throws TableAlreadyExistsException
     */
    final protected function checkIfTableDoesExists(
        string $tableName,
        string $schemaName = self::DEFAULT_SCHEMA_NAME
    ): void {
        if ($this->doesTableExists($tableName, $schemaName)) {
            throw new TableAlreadyExistsException($tableName, $schemaName);
        }
    }

    /**
     * @param string $tableName
     * @param string $schemaName
     *
     * @return void
     * @throws TableDoesNotExistsException
     */
    final protected function checkIfTableDoesNotExists(
        string $tableName,
        string $schemaName = self::DEFAULT_SCHEMA_NAME
    ): void {
        if (!$this->doesTableExists($tableName, $schemaName)) {
            throw new TableDoesNotExistsException($tableName, $schemaName);
        }
    }

    /**
     * @param string $tableName
     * @param string $schemaName
     *
     * @return bool
     */
    final private function doesTableExists(string $tableName, string $schemaName): bool
    {
        $query = $this->db->prepare(<<<SQL
            SELECT
              1
            FROM
              information_schema.tables 
            WHERE table_schema = :schemaName
               AND table_name = :tableName
        SQL);

        $query->execute([
            'schemaName' => $schemaName,
            'tableName' => $tableName,
        ]);

        return !!$query->fetchColumn();
    }
}
