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
    private array $languages = [
        'pl' => Polish::class,
        'en' => English::class,
    ];

    /**
     * @var string
     */
    private string $fallbackLanguage = 'en';

    /**
     * @var string
     */
    private string $language;

    /**
     * @var array
     */
    private array $compiledTranslations = [];

    /**
     * Translation constructor.
     *
     * @param string $language
     *
     * @throws InvalidFallbackLanguageException
     */
    public function __construct(?string $language = null)
    {
        if (!in_array($this->fallbackLanguage, array_keys($this->languages))) {
            throw new InvalidFallbackLanguageException();
        }

        $this->setLanguage($language ?: $this->fallbackLanguage);
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
            $language = $this->language;
        }

        return $this->compiledTranslations[$language][$translationKey]
            ?? $this->compiledTranslations[$this->fallbackLanguage][$translationKey]
            ?? '';
    }

    /**
     * @param string $language
     */
    private function setLanguage(string $language)
    {
        $this->language = in_array($language, array_keys($this->languages))
            ? $language : $this->fallbackLanguage;
    }

    /**
     * @return void
     */
    private function compile(): void
    {
        /** @var LanguageInterface $languageClass */
        foreach ($this->languages as $language => $languageClass) {
            $this->compiledTranslations[$language] = $languageClass::getTranslations();
        }
    }
}
