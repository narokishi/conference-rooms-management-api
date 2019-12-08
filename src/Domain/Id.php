<?php

namespace App\Domain;

use App\Domain\DomainException\InvalidArgumentException;

/**
 * Class Id
 *
 * @package Domain
 */
final class Id
{
    /**
     * @const int
     */
    private const POSTGRES_MIN_INT_SIZE = 1;

    /**
     * @const int
     */
    private const POSTGRES_MAX_INT_SIZE = 2147483647;

    /**
     * Id constructor.
     *
     * @param int $value
     *
     * @throws InvalidArgumentException
     */
    public function __construct(int $value)
    {
        if ($value < self::POSTGRES_MIN_INT_SIZE
            || $value > self::POSTGRES_MAX_INT_SIZE
        ) {
            throw new InvalidArgumentException(sprintf(
                'Identifier value must be between %s and %s.',
                self::POSTGRES_MIN_INT_SIZE,
                self::POSTGRES_MAX_INT_SIZE
            ));
        }
    }
}
