<?php
namespace RHo\Http;

interface HeaderInterface
{

    function isSet(): bool;

    function isValid(): bool;

    function value();
}