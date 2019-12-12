<?php
declare(strict_types=1);

namespace App\Infrastructure;

/**
 * Class AbstractDatabaseAccessObject
 *
 * @package App\Infrastructure
 */
abstract class AbstractDatabaseAccessObject
{
    /**
     * @var \PDO
     */
    protected \PDO $db;

    /**
     * AbstractDatabaseAccessObject constructor.
     *
     * @param \PDO $db
     */
    final public function __construct(\PDO $db)
    {
        $this->db = $db;
    }
}
