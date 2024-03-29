<?php
declare(strict_types=1);

namespace App\Domain\Authorization\Hasher;

/**
 * Interface HasherInterface
 *
 * @package App\Domain\Authorization\Hasher
 */
interface HasherInterface
{
    /**
     * Hash the given value.
     *
     * @param string $value
     * @param array $options
     *
     * @return string
     */
    public function make(string $value, array $options = []): string;

    /**
     * Check the given plain value against a hash.
     *
     * @param string $value
     * @param string $hashedValue
     * @param array $options
     *
     * @return bool
     */
    public function check(string $value, string $hashedValue, array $options = []): bool;
}
