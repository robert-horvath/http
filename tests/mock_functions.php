<?php
declare(strict_types = 1);
namespace RHo\Http\Request;

function file_get_contents(string $fileName)
{
    $file = $GLOBALS['file_get_contents'] ?? NULL;
    if ($file === NULL)
        return \file_get_contents($fileName);
    return \file_get_contents($file);
}
