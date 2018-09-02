<?php
namespace RHo\Http;

interface MediaTypeInterface
{

    public static function init(string $mediaType, int &$error): ?MediaTypeInterface;

    public function type(): string;

    public function subType(): string;

    public function suffix(): ?string;

    public function parameter(string $key): ?string;
}