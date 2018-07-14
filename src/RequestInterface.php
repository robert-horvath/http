<?php
namespace RHo\Http;

use stdClass;

interface RequestInterface
{

    public function server(string $key): ?string;

    public function get(string $key): ?string;

    public function body(): stdClass;

    public function isJsonContentType(): bool;
}