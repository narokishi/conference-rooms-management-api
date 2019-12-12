<?php
declare(strict_types=1);

namespace App\Infrastructure\Migration;

use App\Infrastructure\AbstractMigration;

/**
 * Class CreateUsersTable
 *
 * @package App\Infrastructure\Migration
 */
final class CreateUsersTable extends AbstractMigration
{
    /**
     * @const string
     */
    private const TABLE_NAME = 'users';

    /**
     * @return void
     */
    public function run(): void
    {
        $this->checkIfTableDoesExists(self::TABLE_NAME);

        $query = $this->db->prepare(sprintf(
            <<<SQL
                CREATE TABLE %s (
                  id SERIAL,
                  first_name VARCHAR(64) NOT NULL,
                  last_name VARCHAR(64) NOT NULL,
                  username VARCHAR(64) NOT NULL UNIQUE,
                  password VARCHAR(256) NOT NULL,
                  created_at TIMESTAMP(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  updated_at TIMESTAMP(0) DEFAULT NULL
                )
            SQL,
            static::DEFAULT_SCHEMA_NAME . '.' . self::TABLE_NAME
        ));

        $query->execute();
    }

    /**
     * @return void
     */
    public function down(): void
    {
        $this->checkIfTableDoesNotExists(self::TABLE_NAME);

        $query = $this->db->prepare(sprintf(
            <<<SQL
                DROP TABLE %s
            SQL,
            static::DEFAULT_SCHEMA_NAME . '.' . self::TABLE_NAME
        ));

        $query->execute();
    }
}
