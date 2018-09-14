<?php
declare(strict_types = 1);
namespace RHo\Http\Header;

use RHo\Http\ {
    HeaderInterface,
    Request as HttpRequest
};

/**
 * HTTP Content-Length Header
 */
class ContentLength implements HeaderInterface
{

    /** @var string|NULL */
    private $contentLength;

    public function __construct(HttpRequest $httpRequest)
    {
        $this->contentLength = $httpRequest->header('Content-Length');
    }

    /**
     * Checks if HTTP request message has Content-Length header set
     *
     * @return bool Returns true if HTTP Content-Length request header is set
     */
    public function isSet(): bool
    {
        if ($this->contentLength === NULL)
            return FALSE;
        return TRUE;
    }

    /**
     * Checks if HTTP request message has valid Content-Length header
     *
     * @return bool Returns true if HTTP Content-Length syntax is valid
     */
    public function isValid(): bool
    {
        if ($this->contentLength === NULL)
            return FALSE;
        $i = intval($this->contentLength);
        if ((string) $i !== $this->contentLength)
            return FALSE;
        if (abs($i) !== $i)
            return FALSE;
        return TRUE;
    }

    /**
     * Get content length.
     *
     * @return int The value of the HTTP Content-Length header
     */
    public function value(): int
    {
        if ($this->isValid())
            return (int) $this->contentLength;
        return 0;
    }
}