<?php
namespace RHo\Http;

use RHo\Http\MediaTypeInterface as HttpMediaTypeIface;

interface MessageInterface
{

    function setSupportedContentTypes(array $sct): void;

    function hasContent(): bool;

    function contentSize(): int;

    function content();

    function hasContentType(): bool;

    function isContentTypeSupported(): bool;

    function contentType(): HttpMediaTypeIface;
}