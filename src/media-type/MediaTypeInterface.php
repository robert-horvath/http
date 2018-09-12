<?php
namespace RHo\Http;

interface MediaTypeInterface
{

    static function initWithStr(string $mediaType): ?MediaTypeInterface;

    static function initWithCSV(string $mediaTypeCollection): array;

    function __construct(string $mainType, string $subType);

    function __toString(): string;

    function type(): string;

    function subType(): string;

    function structuredSyntaxSuffix(): ?string;

    function parameter(string $key): ?string;

    function setParameter(string $key, string $value): MediaTypeInterface;
}