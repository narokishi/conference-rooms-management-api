<?php
declare(strict_types=1);

namespace App\Infrastructure\Migration;

use App\Infrastructure\AbstractMigration;

/**
 * Class CreateUsersTokensTable
 *
 * @package App\Infrastructure\Migration
 */
final class CreateUsersTokensTable extends AbstractMigration
{
    /**
     * @const string
     */
    private const TABLE_NAME = 'users_tokens';

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
                  user_id INT NOT NULL REFERENCES users (id),
                  token VARCHAR(32) NOT NULL,
                  created_at TIMESTAMP(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  expires_at TIMESTAMP(0) DEFAULT CURRENT_TIMESTAMP + INTERVAL '3600 SECONDS'
                );
                CREATE INDEX users_tokens_token_idx ON %table (token);
                CREATE INDEX users_tokens_user_id_idx ON %table (user_id);
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
