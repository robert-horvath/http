<?php

declare(strict_types=1);

namespace RHo\Http;

interface ResponseInterface
{
    function send(): void;
}
