<?php
declare(strict_types = 1);
namespace RHo\Http;

abstract class AbstractResponse implements ResponseInterface
{

    public function __construct(int $statusCode)
    {
        http_response_code($statusCode);
    }

    public function setHeader(string $header, string $value): void
    {
        header("$header: $value");
    }

    public function setBody(string $body): void
    {
        echo $body;
    }

    public function send(bool $exit = TRUE): void
    {
        $exit && exit(0);
    }
}