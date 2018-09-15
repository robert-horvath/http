<?php
namespace RHo\Http;

interface ResponseInterface
{

    function __construct(int $statusCode = 200, array $headers = [], ?string $body = NULL);

    function send(): void;
}