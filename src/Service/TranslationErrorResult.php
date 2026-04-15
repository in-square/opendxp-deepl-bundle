<?php

declare(strict_types=1);

namespace InSquare\OpendxpDeeplBundle\Service;

final class TranslationErrorResult
{
    public function __construct(
        private array $payload,
        private int $statusCode
    ) {
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}

