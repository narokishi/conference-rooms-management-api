<?php
declare(strict_types=1);

namespace App\Domain;

/**
 * Class DateTime
 *
 * @package App\Domain
 */
final class DateTime extends AbstractValueObject
{
    /**
     * DateTime constructor.
     *
     * @param string $value
     *
     * @throws \Exception
     */
    public function __construct(string $value)
    {
        parent::__construct(new \DateTime($value));
    }

    /**
     * @return string
     */
    public function get(): string
    {
        /** @var \DateTime $dt */
        $dt = parent::get();

        return $dt->format('Y-m-d H:i:s');
    }
}
