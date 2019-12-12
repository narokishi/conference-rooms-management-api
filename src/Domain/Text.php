<?php
declare(strict_types=1);

namespace App\Domain;

/**
 * Class Text
 *
 * @package App\Domain
 */
final class Text extends AbstractValueObject
{
    /**
     * Text constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
