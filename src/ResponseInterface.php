<?php
namespace RHo\Http;

interface ResponseInterface
{

    public function setHeader(string $header, string $value): void;

    public function setBody(string $body): void;

    public function send(): void;
}