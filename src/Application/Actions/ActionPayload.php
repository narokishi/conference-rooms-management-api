<?php
declare(strict_types=1);

namespace App\Application\Actions;

/**
 * Class ActionPayload
 *
 * @package App\Application\Actions
 */
class ActionPayload implements \JsonSerializable
{
    /**
     * @var int
     */
    private int $statusCode;

    /**
     * @var \JsonSerializable|null
     */
    private ?\JsonSerializable $data;

    /**
     * @var ActionError|null
     */
    private ?ActionError $error;

    /**
     * ActionPayload constructor.
     *
     * @param int $statusCode
     * @param \JsonSerializable|null $data
     * @param ActionError|null $error
     */
    public function __construct(
        int $statusCode = 200,
        \JsonSerializable $data = null,
        ?ActionError $error = null
    ) {
        $this->statusCode = $statusCode;
        $this->data = $data;
        $this->error = $error;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array|null|object
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return ActionError|null
     */
    public function getError(): ?ActionError
    {
        return $this->error;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $payload = [
            'statusCode' => $this->statusCode,
        ];

        if ($this->data instanceof \JsonSerializable) {
            $payload['data'] = $this->data;
        } elseif ($this->error instanceof ActionError) {
            $payload['error'] = $this->error;
        }

        return $payload;
    }
}
