<?php
namespace RHo\Http;

interface MediaTypeInterface
{

    static function initWithStr(string $mediaType): ?MediaTypeInterface;

    static function initWithCollection(string $mediaTypeCollection): array;

    function str(): string;

    function type(): string;

    function setTypes(string $mainType, string $subType): MediaTypeInterface;

    function subType(): string;

    function structuredSyntaxSuffix(): ?string;

    function parameter(string $key): ?string;

    function setParameter(string $key, string $value): MediaTypeInterface;
}