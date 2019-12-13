<?php
declare(strict_types=1);

namespace App\Domain\Authorization\Hasher;

/**
 * Class ArgonHasher
 *
 * @package App\Domain\Authorization\Hasher
 */
final class ArgonHasher implements HasherInterface
{
    /**
     * @var int
     */
    private int $memory = 1024;

    /**
     * @var int
     */
    private int $time = 2;

    /**
     * @var int
     */
    private int $threads = 2;

    /**
     * @param string $value
     * @param array $options
     *
     * @return string
     */
    public function make(string $value, array $options = []): string
    {
        $hash = password_hash($value, PASSWORD_ARGON2I, [
            'memory_cost' => $options['memory'] ?? $this->memory,
            'time_cost' => $options['time'] ?? $this->time,
            'threads' => $options['threads'] ?? $this->threads,
        ]);

        if ($hash === false) {
            throw new \RuntimeException('Argon2 hashing is not supported.');
        }

        return $hash;
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
        if (strlen($hashedValue) === 0) {
            return false;
        }

        return password_verify($value, $hashedValue);
    }
}
