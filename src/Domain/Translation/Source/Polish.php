<?php
declare(strict_types=1);

namespace App\Domain\Translation\Source;

use App\Domain\Authorization\Exception\ExpiredTokenException;
use App\Domain\Authorization\Exception\UsernameAlreadyTakenException;
use App\Domain\ConferenceRoom\Exception\ConferenceRoomNotFoundException;
use App\Domain\Reservation\Exception\ReservationNotFoundException;
use App\Domain\Translation\LanguageInterface;
use App\Domain\User\Exception\UserNotFoundException;

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
            UsernameAlreadyTakenException::class => 'Nazwa użytkownika "%s" jest już zajęta.',
            ReservationNotFoundException::class => 'Rezerwacja (ID: %s) nie istnieje.',
            ConferenceRoomNotFoundException::class => 'Sala konferencyjna (ID: %s) nie istnieje.',
            ExpiredTokenException::class => 'Token autoryzacyjny wygasł lub jest niepoprawny.',
        ];
    }
}
