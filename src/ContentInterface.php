<?php
namespace RHo\Http;

interface ContentFilterInterface
{

    function decode(string $value);

    function encode($value): ?string;

    function errText(): ?string;

    function errCode(): ?int;
}