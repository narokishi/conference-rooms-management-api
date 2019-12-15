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
            UsernameAlreadyTakenException::class => 'Username "%s" is already taken.',
            ReservationNotFoundException::class => 'Reservation (ID: %s) you requested does not exist.',
            ConferenceRoomNotFoundException::class => 'Conference room (ID: %s) you requested does not exist.',
            ExpiredTokenException::class => 'Authorization token is invalid or expired.',
        ];
    }
}
