<?php
declare(strict_types=1);

namespace App\Domain\ConferenceRoom\Command;

use App\Domain\Text;

/**
 * Class ConferenceRoomCreateCommand
 *
 * @package App\Domain\ConferenceRoom\Command
 */
final class ConferenceRoomCreateCommand
{
    /**
     * @var Text
     */
    private Text $name;

    /**
     * @param array $payload
     *
     * @return self
     */
    public static function createFromPayload(array $payload): self
    {
        return (new self())
            ->setName(new Text($payload['name']));
    }

    /**
     * @return Text
     */
    public function getName(): Text
    {
        return $this->name;
    }

    /**
     * @param Text $name
     *
     * @return $this
     */
    public function setName(Text $name): self
    {
        $this->name = $name;

        return $this;
    }
}
