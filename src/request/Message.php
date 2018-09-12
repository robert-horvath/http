<?php
namespace RHo\Http\Request;

use RHo\Http\ {
    Request as HttpRequest,
    MediaType as HttpMediaType,
    MediaTypeInterface as HttpMediaTypeIface,
    Content\PlainText as PlainTextContent,
    Content\Xml as XmlContent,
    Content\Json as JsonContent
};

/**
 * HTTP Request Message
 */
class Message
{

    /** @var HttpRequest */
    private $httpRequest;

    /** @var HttpMediaTypeIface|NULL */
    private $contentType;

    /** @var string|NULL */
    private $contentLength;

    /** @var HttpMediaTypeIface[] */
    private $supportedContentTypes;

    public function __construct(HttpRequest $httpRequest)
    {
        $this->httpRequest = $httpRequest;
        $this->contentType = $this->getHttpMediaType();
        $this->contentLength = $httpRequest->header('Content-Length');
        $this->supportedContentTypes = [];
    }

    /**
     * Set supported Media Types
     *
     * @param HttpMediaTypeIface[] $sct
     */
    public function setSupportedContentTypes(array $sct): void
    {
        $this->supportedContentTypes = $sct;
    }

    /**
     * Checks if HTTP request message has Content-Length header set
     *
     * @return bool Returns true if HTTP Content-Length request header is set
     */
    public function hasContent(): bool
    {
        if ($this->contentLength === NULL)
            return FALSE;
        return TRUE;
    }

    /**
     * Get size of HTTP Body.
     * Do not call before checking if there is message content -> hasContent().
     *
     * @return int The size of the HTTP request body message
     */
    public function contentSize(): int
    {
        return (int) $this->contentLength;
    }

    /**
     * Checks if HTTP request message has Content-Type header set
     *
     * @return bool Returns true if HTTP Content-Type request header is set
     */
    public function hasContentType(): bool
    {
        if ($this->contentType === NULL)
            return FALSE;
        return TRUE;
    }

    /**
     * Check if Content-Type is supported.
     * Do not call before checking if there is any message content -> hasContentType().
     *
     * @return bool Returns true if Content Type is supported
     */
    public function isContentTypeSupported(): bool
    {
        foreach ($this->supportedContentTypes as $sct)
            if ($sct->type() == $this->contentType->type() && $sct->subType() == $this->contentType->subType())
                return TRUE;
        return FALSE;
    }

    /**
     * Get content type.
     * Do not call before checking if there is any message content -> hasContentType().
     *
     * @return HttpMediaTypeIface|NULL Returns the supported Content Type
     */
    public function contentType(): HttpMediaTypeIface
    {
        return $this->contentType;
    }

    /**
     * Get HTTP request message content
     * Do not call before checking if there is message content -> hasContent().
     *
     * @return NULL|\RHo\Http\Content\Json Return HTTP request message body
     */
    public function content()
    {
        $body = $this->httpRequest->body();
        switch ($this->contentType->structuredSyntaxSuffix()) {
            case "text":
                return new PlainTextContent($body);
            case "xml":
                return new XmlContent($body);
            case "json":
                return new JsonContent($body);
            default:
                return NULL;
        }
    }

    /**
     * Get HTTP Content-Type request header
     *
     * @return HttpMediaTypeIface|NULL The header if availbe or NULL if not set
     */
    private function getHttpMediaType(): ?HttpMediaTypeIface
    {
        $ct = $this->httpRequest->header('Content-Type');
        if ($ct === NULL)
            return NULL;
        return HttpMediaType::initWithStr($ct);
    }
}