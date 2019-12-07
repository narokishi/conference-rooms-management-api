<?php
declare(strict_types=1);

namespace App\Infrastructure;

/**
 * Class AbstractDatabaseRepository
 *
 * @package App\Infrastructure
 */
abstract class AbstractDatabaseRepository
{
    /**
     * @var \PDO
     */
    protected \PDO $db;

    /**
     * AbstractDatabaseRepository constructor.
     *
     * @param \PDO $db
     */
    final public function __construct(\PDO $db)
    {
        $this->db = $db;
    }
}
