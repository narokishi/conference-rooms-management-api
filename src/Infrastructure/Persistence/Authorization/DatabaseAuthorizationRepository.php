<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Authorization;

use App\Domain\Authorization\AuthorizationRepositoryInterface;
use App\Infrastructure\AbstractDatabaseRepository;

/**
 * Class DatabaseAuthorizationRepository
 *
 * @package App\Infrastructure\Persistence\Authorization
 */
final class DatabaseAuthorizationRepository extends AbstractDatabaseRepository implements AuthorizationRepositoryInterface
{

}
