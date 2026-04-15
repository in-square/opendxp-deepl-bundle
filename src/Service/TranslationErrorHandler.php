<?php

declare(strict_types=1);

namespace InSquare\OpendxpDeeplBundle\Service;

use OpenDxp\Model\Element\ValidationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Uuid;

final class TranslationErrorHandler
{
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    public function handleValidation(
        string $scope,
        Request $request,
        ?object $user,
        array $context,
        string $text,
        ValidationException $exception
    ): TranslationErrorResult {
        return $this->handle(
            $scope,
            $request,
            $user,
            $context,
            $text,
            $exception,
            422,
            'Validation failed. Check required fields and data format.',
            'validation failed'
        );
    }

    public function handleUnexpected(
        string $scope,
        Request $request,
        ?object $user,
        array $context,
        string $text,
        \Throwable $exception
    ): TranslationErrorResult {
        return $this->handle(
            $scope,
            $request,
            $user,
            $context,
            $text,
            $exception,
            500,
            'Translation failed. Contact administrator and provide error ID.',
            'failed'
        );
    }

    private function handle(
        string $scope,
        Request $request,
        ?object $user,
        array $context,
        string $text,
        \Throwable $exception,
        int $statusCode,
        string $userMessage,
        string $logSuffix
    ): TranslationErrorResult {
        $errorId = Uuid::v4()->toRfc4122();
        $logContext = $this->buildContext($request, $user, $context, $text, $errorId);
        $logContext['exception'] = $exception;

        $this->logger->error(sprintf('DeepL %s translation %s.', $scope, $logSuffix), $logContext);

        return new TranslationErrorResult([
            'success' => false,
            'message' => $userMessage,
            'errorId' => $errorId,
        ], $statusCode);
    }

    private function buildContext(Request $request, ?object $user, array $context, string $text, string $errorId): array
    {
        $baseContext = array_merge([
            'id' => null,
            'key' => null,
            'source' => null,
            'target' => null,
            'objectId' => null,
            'className' => null,
            'path' => null,
        ], $context);

        $baseContext['route'] = (string) $request->attributes->get('_route', '');
        $baseContext['user'] = $this->resolveUserIdentifier($user);
        $baseContext['errorId'] = $errorId;
        $baseContext['textLength'] = $this->getTextLength($text);
        $baseContext['textSnippet'] = $this->getTextSnippet($text);

        return $baseContext;
    }

    private function resolveUserIdentifier(?object $user): ?string
    {
        if (!$user) {
            return null;
        }

        if (method_exists($user, 'getUserIdentifier')) {
            return (string) $user->getUserIdentifier();
        }

        if (method_exists($user, 'getUsername')) {
            return (string) $user->getUsername();
        }

        return $user::class;
    }

    private function getTextLength(string $text): int
    {
        return function_exists('mb_strlen') ? mb_strlen($text) : strlen($text);
    }

    private function getTextSnippet(string $text, int $maxLength = 80): string
    {
        $normalized = trim((string) preg_replace('/\s+/u', ' ', strip_tags($text)));
        if ($normalized === '') {
            return '';
        }

        $length = function_exists('mb_strlen') ? mb_strlen($normalized) : strlen($normalized);
        $snippet = function_exists('mb_substr') ? mb_substr($normalized, 0, $maxLength) : substr($normalized, 0, $maxLength);

        if ($length > $maxLength) {
            $snippet .= '...';
        }

        return $snippet;
    }
}

