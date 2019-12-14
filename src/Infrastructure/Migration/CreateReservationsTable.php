<?php
declare(strict_types=1);

namespace App\Infrastructure\Migration;

use App\Infrastructure\AbstractMigration;

/**
 * Class CreateReservationsTable
 *
 * @package App\Infrastructure\Migration
 */
final class CreateReservationsTable extends AbstractMigration
{
    /**
     * @const string
     */
    private const TABLE_NAME = 'reservations';

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
                  conference_room_id INT NOT NULL REFERENCES conference_rooms (id),
                  user_id INT NOT NULL REFERENCES users (id),
                  starts_at TIMESTAMP(0) NOT NULL,
                  ends_at TIMESTAMP(0) NOT NULL,
                  created_at TIMESTAMP(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  updated_at TIMESTAMP(0)
                );
                CREATE INDEX reservations_user_id_idx ON %table (user_id);
                CREATE INDEX reservations_conference_room_id_idx ON %table (conference_room_id);
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
