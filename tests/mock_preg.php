<?php
declare(strict_types = 1);
namespace RHo\Http;

function preg_match($pattern, $subject, &$matches)
{
    if ($GLOBALS['mock_preg'])
        return FALSE;
    return \preg_match($pattern, $subject, $matches);
}

function preg_last_error()
{
    if ($GLOBALS['mock_preg'])
        return PREG_BACKTRACK_LIMIT_ERROR;
    return \preg_last_error();
}