<?php
declare(strict_types = 1);
namespace RHo\Http;

use RHo\ {
    Http\Request\RequestInterface as HttpRequestInterface,
    Http\Request\Request as HttpRequest,
    Http\Response\ResponseInterface as HttpResponseInterface,
    Http\Header\ContentType as HttpContentTypeHeader,
    Http\Header\Accept as HttpAcceptHeader,
    Http\Header\HeaderInterface as HttpHeaderInterface,

    MediaType\Factory,
    MediaType\MediaTypeFactory,
    MediaType\MediaTypeInterface,

    Http\Response\BadRequest,
    Http\Response\UnsupportedMediaType,

    StableSort\StableSort
};
use RHo\Http\Response\ResponseInterface;

class Controller
{

    /** @var HttpRequestInterface */
    private $httpRequest;

    /** @var HttpResponseInterface */
    private $httpResponse;

    /** @var MediaTypeFactory */
    private $mediaTypeFactory;

    /** @var MediaTypeInterface[] */
    private $supportedMediaTypes;

    /** @var HttpHeaderInterface */
    private $contentTypeHeader;

    /** @var HttpHeaderInterface */
    private $acceptHeader;

    /** @var bool */
    private $receiveContent;

    /** @var bool */
    private $sendContent;

    public function __construct(array $supportedMediaTypes, bool $receiveContent, bool $sendContent)
    {
        $this->httpRequest = new HttpRequest();
        $this->httpResponse = NULL;
        $this->mediaTypeFactory = new MediaTypeFactory();
        $this->supportedMediaTypes = $supportedMediaTypes;
        $this->contentTypeHeader = new HttpContentTypeHeader($this->httpRequest, $this->mediaTypeFactory);
        $this->acceptHeader = new HttpAcceptHeader($this->httpRequest, $this->mediaTypeFactory);
        $this->receiveContent = $receiveContent;
        $this->sendContent = $sendContent;
    }

    public function query(string $name): ?string
    {
        return $this->httpRequest->queryStr($name);
    }

    public function message()
    {
        return Factory::decode($this->contentTypeHeader->value()[0], $this->httpRequest->body());
    }

    public function response(): ?ResponseInterface
    {
        return $this->httpResponse;
    }

    public function supportedMediaTypes(): array
    {
        $mediaType = [];
        foreach ($this->supportedMediaTypes as $supportedMediaType)
            foreach ($this->acceptHeader->value() as $acceptMediaType)
                if ($acceptMediaType->compareTo($supportedMediaType) === 0) {
                    $mediaType[] = $acceptMediaType;
                    break;
                }
        StableSort::uasort($mediaType, function (MediaTypeInterface $a, MediaTypeInterface $b) {
            if ($b->parameterQ() > $a->parameterQ())
                return 1;
            if ($b->parameterQ() < $a->parameterQ())
                return - 1;
            return 0;
        });
        return $mediaType;
    }

    public function isRequestValid(): bool
    {
        if ($this->isContentNegotiationSucceeded())
            return TRUE;
        return FALSE;
    }

    private function isContentNegotiationSucceeded(): bool
    {
        if (! $this->validateMediaTypes($this->contentTypeHeader, $this->receiveContent))
            return FALSE;
        if (! $this->validateMediaTypes($this->acceptHeader, $this->sendContent))
            return FALSE;
        return TRUE;
    }

    private function validateMediaTypes(HttpHeaderInterface $header, bool $mustBeSet): bool
    {
        if ($mustBeSet && $this->httpResponse = $this->respondIfHeaderMissing($header))
            return FALSE;
        if (! $mustBeSet)
            return TRUE;
        if ($this->httpResponse = $this->respondIfHeaderInvalid($header))
            return FALSE;
        if ($this->httpResponse = $this->respondIfUnsupportedMediaType($header))
            return FALSE;
        return TRUE;
    }

    private function respondIfHeaderMissing(HttpHeaderInterface $header): ?ResponseInterface
    {
        if ($header->isSet())
            return NULL;
        return new BadRequest([
            'Warning' => '199 HttpController "Mandatory header (' . $header->name() . ') missing'
        ]);
    }

    private function respondIfHeaderInvalid(HttpHeaderInterface $header): ?ResponseInterface
    {
        if ($header->value())
            return NULL;
        return new BadRequest([
            'Warning' => '199 HttpController "Invalid header (' . $header->name() . ') syntax'
        ]);
    }

    private function respondIfUnsupportedMediaType(HttpHeaderInterface $header): ?ResponseInterface
    {
        foreach ($this->supportedMediaTypes as $supportedMediaType)
            foreach ($header->value() as $mediaType)
                if ($mediaType->compareTo($supportedMediaType) === 0)
                    return NULL;
        return new UnsupportedMediaType();
    }
}