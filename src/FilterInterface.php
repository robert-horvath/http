<?php

declare(strict_types=1);

namespace RHo\Http;

interface FilterInterface
{
    const ERR_DATA_TYPE = 1;

    const ERR_STR_TOO_SHORT = 2;

    const ERR_STR_TOO_LONG = 3;

    const ERR_INVALID_SYNTAX = 4;

    const ERR_INT_TOO_SMALL = 5;

    const ERR_INT_TOO_BIG = 6;

    const ERR_PASSWORD_MISSING_LOWER_CHAR = 7;

    const ERR_PASSWORD_MISSING_UPPER_CHAR = 8;

    const ERR_PASSWORD_MISSING_NUMBER_CHAR = 9;

    function validate(): ?int;

    function value(): mixed;
}
