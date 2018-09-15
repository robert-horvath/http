<?php
declare(strict_types = 1);
namespace RHo\Http\Response;

use RHo\Http\ {
    ResponseInterface,
    ResponseBuilderInterface
};

class ResponseBuilder implements ResponseBuilderInterface
{

    /** @var int */
    private $statusCode;

    /** @var string */
    private $body;

    /** @var array */
    private $headers;

    protected function __construct(int $statusCode = 200)
    {
        $this->statusCode = $statusCode;
        $this->body = NULL;
        $this->headers = [];
    }

    public function withBody(string $body): ResponseBuilderInterface
    {
        $this->body = $body;
        return $this;
    }

    public function withHeader(string $header, string $value): ResponseBuilderInterface
    {
        $this->headers[$header] = $value;
        return $this;
    }

    public function build(): ResponseInterface
    {
        return new Response($this->statusCode, $this->headers, $this->body);
    }
}