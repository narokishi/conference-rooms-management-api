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

        $this->db->exec($this->prepareStatement(
            <<<SQL
                CREATE TABLE %table (
                  id SERIAL PRIMARY KEY,
                  first_name VARCHAR(64) NOT NULL,
                  last_name VARCHAR(64) NOT NULL,
                  username VARCHAR(64) NOT NULL UNIQUE,
                  password VARCHAR(256) NOT NULL,
                  created_at TIMESTAMP(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  updated_at TIMESTAMP(0) DEFAULT NULL
                );
                CREATE INDEX users_username_idx ON %table (username);
            SQL,
            self::TABLE_NAME
        ));
    }

    /**
     * @return void
     */
    public function down(): void
    {
        $this->checkIfTableDoesNotExists(self::TABLE_NAME);

        $query = $this->db->prepare($this->prepareStatement(
            <<<SQL
                DROP TABLE %table
            SQL,
            self::TABLE_NAME
        ));

        $query->execute();
    }
}
