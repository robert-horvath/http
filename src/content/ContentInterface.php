<?php
namespace RHo\Http\Content;

interface ContentInterface
{

    function decode();

    function encode(): ?string;

    function errText(): ?string;

    function errCode(): ?int;
}