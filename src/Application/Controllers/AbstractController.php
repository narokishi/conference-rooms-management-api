<?php
declare(strict_types=1);

namespace App\Application\Controllers;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
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
     *
     * @return Response
     */
    public function getJsonResponse(\JsonSerializable $data = null): ResponseInterface
    {
        $serializedData = $data instanceof \JsonSerializable
            ? json_encode($data, JSON_THROW_ON_ERROR) : null;

        $response = new Response(
            empty($serializedData) ? StatusCodeInterface::STATUS_NO_CONTENT : StatusCodeInterface::STATUS_OK
        );
        $response->getBody()->write($serializedData);
        $response->withHeader('Content-Type', 'application/json');

        return $response;
    }
}
