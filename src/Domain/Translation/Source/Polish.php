<?php
declare(strict_types=1);

namespace App\Domain\Translation\Source;

use App\Domain\Translation\LanguageInterface;
use App\Domain\User\UserNotFoundException;

/**
 * Class Polish
 *
 * @package App\Domain\Translation\Source
 */
final class Polish implements LanguageInterface
{
    /**
     * @return array
     */
    public static function getTranslations(): array
    {
        return [
            UserNotFoundException::class => 'Użytkownik (ID: %s) nie istnieje.',
        ];
    }
}
