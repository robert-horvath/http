<?php
namespace RHo\Http;

interface RequestInterface
{

    public function header(string $header): ?string;

    public function queryStr(string $key): ?string;

    public function body(string $filename = 'php://input'): ?string;
}