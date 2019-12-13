<?php
declare(strict_types=1);

namespace App\Application\Controllers;

use App\Domain\Text;
use Psr\Http\Message\ResponseInterface;

/**
 * Class LanguageController
 *
 * @package App\Application\Controllers
 */
final class LanguageController extends AbstractController
{
    /**
     * @param Text $language
     *
     * @return ResponseInterface
     */
    public function set(Text $language): ResponseInterface
    {
        setcookie('X-Language', $language->get(), 0, '/');

        return $this->getJsonResponse();
    }
}
