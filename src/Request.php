<?php
declare(strict_types = 1);
namespace RHo\Http;

use stdClass, InvalidArgumentException, DomainException;

class Request implements RequestInterface
{

    /** @var string */
    private $filename;

    public function __construct(string $filename = 'php://input')
    {
        $this->filename = $filename;
    }

    public function server(string $key): ?string
    {
        return $_SERVER[$key] ?? null;
    }

    public function get(string $key): ?string
    {
        return $_GET[$key] ?? null;
    }

    /**
     *
     * @throws \UnexpectedValueException
     */
    public function body(): stdClass
    {
        if ($this->isJsonContentType())
            return $this->jsonBody();
        throw new \UnexpectedValueException($this->getContentTypeHeader());
    }

    public function isJsonContentType(): bool
    {
        return $this->getContentTypeHeader() === 'application/json';
    }

    private function getPhpInputFileContents(): string
    {
        $str = @file_get_contents($this->filename);
        if ($str === false)
            $this->throwInvalidArgumentException();
        return $str;
    }

    /**
     *
     * @throws \DomainException
     */
    private function decodeJson(string $str): stdClass
    {
        $json = json_decode($str);
        if (json_last_error() === JSON_ERROR_NONE)
            return $json;
        throw new DomainException(json_last_error_msg(), json_last_error());
    }

    /**
     *
     * @throws \InvalidArgumentException
     */
    private function throwInvalidArgumentException()
    {
        $arr = error_get_last();
        $msg = sprintf("%s in %s on line %d", $arr['message'], $arr['file'], $arr['line']);
        throw new InvalidArgumentException($msg, $arr['type']);
    }

    private function jsonBody(): stdClass
    {
        error_clear_last();
        return $this->decodeJson($this->getPhpInputFileContents());
    }

    private function getContentTypeHeader(): ?string
    {
        return strtolower($this->server('CONTENT_TYPE'));
    }
}