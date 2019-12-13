<?php
declare(strict_types=1);

namespace App\Domain\Translation\Source;

use App\Domain\Translation\LanguageInterface;
use App\Domain\User\UserNotFoundException;

/**
 * Class English
 *
 * @package App\Domain\Translation\Source
 */
final class English implements LanguageInterface
{
    /**
     * @return array
     */
    public static function getTranslations(): array
    {
        return [
            UserNotFoundException::class => 'User (ID: %s) you requested does not exist.',
        ];
    }
}
