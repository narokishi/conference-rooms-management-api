<?php

namespace App\Domain;

use App\Domain\DomainException\InvalidArgumentExceptionAbstract;

/**
 * Class Id
 *
 * @package Domain
 */
final class Id extends AbstractValueObject
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
     * @throws InvalidArgumentExceptionAbstract
     */
    public function __construct(int $value)
    {
        if ($value < self::POSTGRES_MIN_INT_SIZE
            || $value > self::POSTGRES_MAX_INT_SIZE
        ) {
            throw new InvalidArgumentExceptionAbstract(sprintf(
                'Identifier value must be between %s and %s.',
                self::POSTGRES_MIN_INT_SIZE,
                self::POSTGRES_MAX_INT_SIZE
            ));
        }

        parent::__construct($value);
    }
}
