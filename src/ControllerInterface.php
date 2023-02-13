<?php

declare(strict_types=1);

namespace RHo\Http;

interface ControllerInterface
{
    function isLastRoute(): bool;

    function nextController(): self;

    function isRequestValid(): bool;

    function runService(): void;

    function sendResponse(): void;
}
