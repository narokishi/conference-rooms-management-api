<?php
declare(strict_types=1);

namespace App\Infrastructure\InfrastructureException;

use App\Infrastructure\AbstractMigration;

/**
 * Class TableDoesNotExistsException
 *
 * @package App\Infrastructure\InfrastructureException
 */
final class TableDoesNotExistsException extends AbstractInfrastructureException
{
    /**
     * TableAlreadyExistsException constructor.
     *
     * @param string $tableName
     * @param string $schemaName
     */
    public function __construct(string $tableName, string $schemaName = AbstractMigration::DEFAULT_SCHEMA_NAME)
    {
        parent::__construct(sprintf(
            'Table "%s" does not exists in "%s" database schema.',
            $tableName,
            $schemaName
        ));
    }
}
