<?php
namespace RHo\Http;

interface BodyInterface
{

    function decode(string $value);

    function encode($value): ?string;

    function errText(): ?string;

    function errCode(): ?int;
}