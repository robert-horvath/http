<?php
namespace RHo\Http;

interface RequestInterface
{

    function header(string $name): ?string;

    function queryStr(string $name): ?string;

    function body(): string;
}