<?php
declare(strict_types = 1);
namespace RHo\Http\Response;

use RHo\Http\ResponseInterface;

final class Response implements ResponseInterface
{

    /** @var int */
    private $statusCode;

    /** @var string */
    private $body;

    /** @var array */
    private $headers;

    public function __construct(int $statusCode = 200, array $headers = [], ?string $body = NULL)
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
        $this->headers = $headers;
    }

    public function send(): void
    {
        http_response_code($this->statusCode);
        $this->setHeaders($this->headers);
        $this->setBody($this->body);
    }

    private function setHeaders(array $headers): void
    {
        foreach ($headers as $header => $value)
            header("$header: $value");
    }

    private function setBody(?string $body): void
    {
        if ($body !== NULL)
            echo $body;
    }
}