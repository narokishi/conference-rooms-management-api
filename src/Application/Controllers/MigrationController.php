<?php
declare(strict_types=1);

namespace App\Application\Controllers;

use App\Domain\Id;
use App\Domain\Reservation\Exception\ReservationNotFoundException;
use App\Domain\Reservation\ReservationService;
use App\Infrastructure\Migrator;
use Psr\Http\Message\MessageInterface;
use Psr\Log\LoggerInterface;

/**
 * Class MigrationController
 *
 * @package App\Application\Controllers
 */
final class MigrationController extends AbstractController
{
    /**
     * @var Migrator
     */
    private Migrator $migrator;

    /**
     * @param LoggerInterface $logger
     * @param Migrator $migrator
     */
    public function __construct(
        LoggerInterface $logger,
        Migrator $migrator
    ) {
        parent::__construct($logger);

        $this->migrator = $migrator;
    }

    /**
     * @return MessageInterface
     */
    public function runAll(): MessageInterface
    {
        $this->migrator->runAll();

        return $this->getJsonResponse();
    }

    public function downAll(): MessageInterface
    {
        $this->migrator->downAll();

        return $this->getJsonResponse();
    }
}

