<?php
declare(strict_types=1);

namespace App\Infrastructure\InfrastructureException;

/**
 * Class MigrationDoesNotExistsException
 *
 * @package App\Infrastructure\InfrastructureException
 */
final class MigrationDoesNotExistsException extends AbstractInfrastructureException
{
    /**
     * MigrationDoesNotExistsException constructor.
     *
     * @param string $migrationClassName
     */
    public function __construct(string $migrationClassName)
    {
        parent::__construct(sprintf(
            'Migration class "%s" does not exists.',
            $migrationClassName
        ));
    }
}
