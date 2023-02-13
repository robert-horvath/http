<?php

declare(strict_types=1);

namespace RHo\Http;

interface ResponseBuilderInterface
{
    function init(StatusCode $statusCode): self;

    function withHeader(string $name, string $value): self;

    function withBody(string $body): self;

    function build(): ResponseInterface;
}
