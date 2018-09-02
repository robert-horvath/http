<?php
declare(strict_types = 1);
namespace RHo\Http;

interface BodyInterface
{

    function decode(string $str): ?int;

    function encode($value): ?int;

    function errStr(): string;

    function str(): string;

    function value();
}