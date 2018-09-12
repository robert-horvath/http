<?php
declare(strict_types = 1);
namespace RHo\Http;

function preg_match($pattern, $subject, &$matches)
{
    if (isset($GLOBALS['mock_preg_match']) && $GLOBALS['mock_preg_match'])
        return FALSE;
    return \preg_match($pattern, $subject, $matches);
}

function preg_last_error()
{
    return $GLOBALS['preg_last_error'] ?? \preg_last_error();
}

function file_get_contents(string $fileName)
{
    $file = $GLOBALS['file_get_contents'] ?? NULL;
    if ($file === NULL)
        return \file_get_contents($fileName);
    return \file_get_contents($file);
}
