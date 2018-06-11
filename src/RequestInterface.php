<?php
namespace RHo\Http;

use stdClass;

interface RequestInterface
{

    function server(string $key): ?string;

    function get(string $key): ?string;

    function body(): stdClass;
}