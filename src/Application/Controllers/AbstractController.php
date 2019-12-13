<?php
declare(strict_types=1);

namespace App\Application\Controllers;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

/**
 * Class AbstractController
 *
 * @package App\Application\Controllers
 */
abstract class AbstractController
{
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * AbstractController constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param \JsonSerializable|null $data
     * @param int $statusCode
     *
     * @return MessageInterface
     */
    final protected function getJsonResponse(
        \JsonSerializable $data = null,
        int $statusCode = StatusCodeInterface::STATUS_OK
    ): MessageInterface {
        $serializedData = $data instanceof \JsonSerializable
            ? json_encode($data, JSON_THROW_ON_ERROR) : '';

        $response = new Response(
            empty($serializedData) && $statusCode === StatusCodeInterface::STATUS_OK
                ? StatusCodeInterface::STATUS_NO_CONTENT : $statusCode
        );
        $response->getBody()->write($serializedData);

        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param Request $request
     * @param array $requiredFields
     *
     * @return array|object|null
     * @throws HttpBadRequestException
     */
    final protected function getPayload(Request $request, array $requiredFields = [])
    {
        $payload = $request->getParsedBody();

        if (!empty($requiredFields)) {
            $errors = [];

            foreach ($requiredFields as $requiredField) {
                if (!array_key_exists($requiredField, $payload)) {
                    $errors[] = $requiredField;
                }
            }

            if (!empty($errors)) {
                throw new HttpBadRequestException($request, sprintf(
                    "There are missing keys in the request: %s",
                    json_encode($errors)
                ));
            }
        }

        return $payload;
    }
}
