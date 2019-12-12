<?php
declare(strict_types=1);

namespace App\Infrastructure\InfrastructureException;

use App\Infrastructure\AbstractMigration;

/**
 * Class InvalidMigrationException
 *
 * @package App\Infrastructure\InfrastructureException
 */
final class InvalidMigrationException extends AbstractInfrastructureException
{
    /**
     * MigrationDoesNotExistsException constructor.
     *
     * @param string $migrationClassName
     */
    public function __construct(string $migrationClassName)
    {
        parent::__construct(sprintf(
            'Class "%s" is not a valid migration. It has to extend "%s" class.',
            $migrationClassName,
            AbstractMigration::class
        ));
    }
}
