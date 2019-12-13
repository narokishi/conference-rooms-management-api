<?php
declare(strict_types=1);

namespace App\Domain\Translation;

/**
 * Interface LanguageInterface
 *
 * @package App\Domain\Translation
 */
interface LanguageInterface
{
    /**
     * @return array
     */
    public static function getTranslations(): array;
}
