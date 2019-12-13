<?php
declare(strict_types=1);

namespace App\Domain\Authorization\Hasher;

/**
 * Class Md5Hasher
 *
 * @package App\Domain\Authorization\Hasher
 */
final class Md5Hasher implements HasherInterface
{
    /**
     * @param string $value
     * @param array $options
     *
     * @return string
     */
    public function make(string $value, array $options = []): string
    {
        return md5($value);
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
        return md5($value) === $hashedValue;
    }
}
