<?php

namespace SlackUnfurl\Controller;

use InvalidArgumentException;
use SlackUnfurl\Command;
use SlackUnfurl\Command\CommandInterface;
use SlackUnfurl\CommandResolver;
use SlackUnfurl\RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UnfurlController
{
    private const COMMAND_MAP = [
        'url_verification' => Command\UrlVerification::class,
        'event_callback' => Command\EventCallback::class,
    ];

    /** @var CommandResolver */
    private $commandResolver;

    /** @var string */
    private $verificationToken;

    public function __construct(CommandResolver $commandResolver, string $verificationToken)
    {
        $this->commandResolver = $commandResolver;
        $this->verificationToken = $verificationToken;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $content = $request->getContent();
        $payload = json_decode($content, 1);
        if (!$payload) {
            throw new RuntimeException('Unable to decode json');
        }

        $this->verifyToken($payload['token'] ?? null);

        /** @var CommandInterface $command */
        $command = $this->commandResolver
            ->configure(self::COMMAND_MAP)
            ->resolve($payload['type'] ?? null);

        return $command->execute($payload);
    }

    /**
     * @param string $token
     * @throws InvalidArgumentException
     */
    private function verifyToken($token): void
    {
        if ($token !== $this->verificationToken) {
            throw new RuntimeException('Token verification failed');
        }
    }
}