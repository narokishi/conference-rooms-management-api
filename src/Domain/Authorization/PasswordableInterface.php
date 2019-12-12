<?php
declare(strict_types=1);

namespace App\Domain\Authorization;

use App\Domain\Text;

/**
 * Interface PasswordableInterface
 *
 * @package App\Domain\Authorization
 */
interface PasswordableInterface
{
    /**
     * @return Text
     */
    public function getPassword(): Text;

    /**
     * @param Text $password
     *
     * @return $this
     */
    public function setPassword(Text $password): self;
}
