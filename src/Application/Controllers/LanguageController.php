<?php
declare(strict_types=1);

namespace App\Application\Controllers;

use App\Domain\Text;
use Psr\Http\Message\MessageInterface;
use function App\setDomainCookie;

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
     * @return MessageInterface
     */
    public function set(Text $language): MessageInterface
    {
        setDomainCookie('X-Language', $language->get());

        return $this->getJsonResponse();
    }
}
