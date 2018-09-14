<?php
declare(strict_types = 1);
namespace RHo\Http\Header;

use RHo\Http\ {
    HeaderInterface,
    Request as HttpRequest,
    MediaType as HttpMediaType,
    MediaTypeInterface as HttpMediaTypeIface
};

/**
 * HTTP Content-Type Header
 */
class ContentType implements HeaderInterface
{

    /** @var HttpRequest */
    private $httpRequest;

    /** @var string|NULL */
    private $contentType;

    /** @var HttpMediaTypeIface|NULL */
    private $mediaType;

    public function __construct(HttpRequest $httpRequest)
    {
        $this->httpRequest = $httpRequest;
        $this->contentType = $this->httpRequest->header('Content-Type');
        $this->mediaType = $this->getHttpMediaType();
    }

    /**
     * Checks if HTTP request message has Content-Type header set
     *
     * @return bool Returns true if HTTP Content-Type request header is set
     */
    public function isSet(): bool
    {
        if ($this->contentType === NULL)
            return FALSE;
        return TRUE;
    }

    /**
     * Checks if HTTP request message has valid Content-Type header
     *
     * @return bool Returns true if HTTP Content-Type syntax is valid
     */
    public function isValid(): bool
    {
        if ($this->mediaType === NULL)
            return FALSE;
        return TRUE;
    }

    /**
     * Check if Content-Type is supported.
     *
     * @param HttpMediaTypeIface[] $sct
     *            Supported Content Types
     * @return bool Returns true if Content Type is supported
     */
    public function isSupported(array $sctArr = []): bool
    {
        if ($this->isValid())
            foreach ($sctArr as $sct)
                if ($sct->type() == $this->mediaType->type() && $sct->subType() == $this->mediaType->subType())
                    return TRUE;
        return FALSE;
    }

    /**
     * Get content type.
     *
     * @return HttpMediaTypeIface|NULL Returns the supported Content Type
     */
    public function value(): ?HttpMediaTypeIface
    {
        return $this->mediaType;
    }

    /**
     * Get HTTP Content-Type request header
     *
     * @return HttpMediaTypeIface|NULL The header if availbe or NULL if not set
     */
    private function getHttpMediaType(): ?HttpMediaTypeIface
    {
        if ($this->contentType === NULL)
            return NULL;
        return HttpMediaType::initWithStr($this->contentType);
    }
}