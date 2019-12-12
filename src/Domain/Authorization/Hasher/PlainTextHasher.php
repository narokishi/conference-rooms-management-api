<?php
declare(strict_types=1);

namespace App\Domain\Authorization\Hasher;

/**
 * Class PlainTextHasher
 *
 * @package App\Domain\Authorization\Hasher
 */
final class PlainTextHasher implements HasherInterface
{
    /**
     * @param string $value
     * @param array $options
     *
     * @return string
     */
    public function make(string $value, array $options = []): string
    {
        return $value;
    }

    /**
     * @param string $value
     * @param string $hashedValue
     * @param array $options
     *
     * @return bool
     */
    public function check(string $value, string $hashedValue, array $options = []): bool
    {
        return $value === $hashedValue;
    }

    /**
     * @param string $hashedValue
     * @param array $options
     *
     * @return bool
     */
    public function needsRehash(string $hashedValue, array $options = []): bool
    {
        return false;
    }
}
