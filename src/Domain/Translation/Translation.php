<?php
declare(strict_types=1);

namespace App\Domain\Translation;

use App\Domain\Translation\Exception\InvalidFallbackLanguageException;
use App\Domain\Translation\Source\English;
use App\Domain\Translation\Source\Polish;

/**
 * Class Translation
 *
 * @package App\Domain\Translation
 */
final class Translation
{
    /**
     * @var array
     */
    public static array $languages = [
        'pl' => Polish::class,
        'en' => English::class,
    ];

    /**
     * @var string
     */
    private static string $fallbackLanguage = 'en';

    /**
     * @var string
     */
    private static string $language = 'en';

    /**
     * @var bool
     */
    private static bool $isLanguageForced = false;

    /**
     * @var array
     */
    private array $compiledTranslations = [];

    /**
     * Translation constructor.
     *
     * @throws InvalidFallbackLanguageException
     */
    public function __construct()
    {
        if (!in_array(self::$fallbackLanguage, array_keys(self::$languages))) {
            throw new InvalidFallbackLanguageException();
        }

        $this->compile();
    }

    /**
     * @param string $translationKey
     * @param string|null $language
     *
     * @return string
     */
    public function get(string $translationKey, ?string $language = null): string
    {
        if (is_null($language)) {
            $language = self::$language;
        }

        return $this->compiledTranslations[$language][$translationKey]
            ?? $this->compiledTranslations[self::$fallbackLanguage][$translationKey]
            ?? '';
    }

    /**
     * @param string $language
     * @param bool $forceLanguage
     *
     * @return void
     */
    public static function setLanguage(string $language, bool $forceLanguage = false): void
    {
        if (!self::$isLanguageForced) {
            if ($forceLanguage) {
                self::$isLanguageForced = $forceLanguage;
            }

            self::$language = in_array($language, array_keys(self::$languages))
                ? $language : self::$fallbackLanguage;
        }
    }

    /**
     * @return void
     */
    private function compile(): void
    {
        /** @var LanguageInterface $languageClass */
        foreach (self::$languages as $language => $languageClass) {
            $this->compiledTranslations[$language] = $languageClass::getTranslations();
        }
    }
}
