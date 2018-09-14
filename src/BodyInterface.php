<?php
namespace RHo\Http;

interface BodyInterface
{

    static function decode(string $value): BodyInterface;

    static function encode($value): BodyInterface;

    function value();

    function errText(): ?string;

    function errCode(): ?int;
}