<?php
declare(strict_types = 1);
namespace RHo\Http;

function preg_last_error()
{
    if ($GLOBALS['mock_preg_last_error'])
        return PREG_BACKTRACK_LIMIT_ERROR;
    return \preg_last_error();
}