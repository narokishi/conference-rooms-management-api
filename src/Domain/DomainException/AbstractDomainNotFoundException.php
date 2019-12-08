<?php
declare(strict_types=1);

namespace App\Domain\DomainException;

use Fig\Http\Message\StatusCodeInterface;

/**
 * Class AbstractDomainNotFoundException
 *
 * @package App\Domain\DomainException
 */
abstract class AbstractDomainNotFoundException extends AbstractDomainException
{
    /**
     * AbstractDomainNotFoundException constructor.
     *
     * @param string $message
     */
    public function __construct($message = '')
    {
        parent::__construct($message, StatusCodeInterface::STATUS_NOT_FOUND);
    }
}
