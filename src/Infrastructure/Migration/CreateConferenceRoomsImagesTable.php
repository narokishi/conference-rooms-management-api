<?php
declare(strict_types=1);

namespace App\Infrastructure\Migration;

use App\Infrastructure\AbstractMigration;

/**
 * Class CreateConferenceRoomsImagesTable
 *
 * @package App\Infrastructure\Migration
 */
final class CreateConferenceRoomsImagesTable extends AbstractMigration
{
    /**
     * @const string
     */
    private const TABLE_NAME = 'conference_rooms_images';

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
                  enabled BOOL NOT NULL DEFAULT TRUE,
                  conference_room_id INT NOT NULL REFERENCES conference_rooms (id),
                  image_base64 TEXT NOT NULL,
                  created_at TIMESTAMP(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  updated_at TIMESTAMP(0)
                );
                CREATE INDEX conference_rooms_images_conference_room_id_idx ON %table (conference_room_id);
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
