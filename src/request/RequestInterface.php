<?php

declare(strict_types=1);

namespace RHo\Http;

interface RequestInterface
{
    function isHttpsScheme(): bool;

    function isWwwHost(): bool;

    function isUriMatch(string $pattern, array &$matches): bool;

    function method(): string;

    function uri(): string;

    function uriPart(int $index): string;

    function headers(): array;
}
