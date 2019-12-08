<?php
declare(strict_types=1);

namespace App\Domain;

/**
 * Class AbstractValueObject
 *
 * @package App\Domain
 */
abstract class AbstractValueObject
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * AbstractValueObject constructor.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    final public function get()
    {
        return $this->value;
    }
}

