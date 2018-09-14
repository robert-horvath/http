<?php
namespace RHo\Http;

interface ResponseInterface
{

    function setHeader(string $header, string $value): void;

    function setBody(string $body): void;

    function send(): void;
}