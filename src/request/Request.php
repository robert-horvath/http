<?php
declare(strict_types = 1);
namespace RHo\Http;

use BadMethodCallException, RuntimeException;

/**
 * HTTP Request
 */
class Request implements RequestInterface
{

    private const PHP_INPUT_FILE = 'php://input';

    /**
     * Get HTTP header
     *
     * @param string $header
     *            The name of the header
     * @return string|NULL The value of header, or NULL if header name not present
     * @throws \BadMethodCallException If user function, to read header, not implemented
     */
    public function header(string $name): ?string
    {
        return call_user_func([
            $this,
            $this->getHeaderFunc($name)
        ]);
    }

    /**
     * Get Query String
     *
     * @param string $name
     *            The field name of query string
     * @return string|NULL The field value of query string, or NULL if field name is not set
     */
    public function queryStr(string $name): ?string
    {
        return $_GET[$name] ?? null;
    }

    /**
     * Get HTTP message body
     *
     * @return string The HTTP request body
     * @throws \RuntimeException If file cannot be found
     */
    public function body(): string
    {
        $str = @file_get_contents(self::PHP_INPUT_FILE);
        if ($str === false)
            $this->throwRuntimeException();
        return $str;
    }

    /**
     * Get the name of the header getter function or throw error if it is not implemented
     *
     * @param string $name
     *            The name of the HTTP request header
     * @throws BadMethodCallException No getter function implemented yet
     * @return string The name of the getter function
     */
    private function getHeaderFunc(string $name): string
    {
        $f = sprintf('get%sHeader', str_replace('-', '', $name));
        if (! method_exists($this, $f))
            throw new BadMethodCallException('Function ' . __CLASS__ . "::$f() does not exist");
        return $f;
    }

    /**
     * Throws runtime exception
     *
     * @throws \RuntimeException
     */
    private function throwRuntimeException()
    {
        $arr = error_get_last();
        $msg = sprintf("%s in %s on line %d", $arr['message'], $arr['file'], $arr['line']);
        throw new RuntimeException($msg, $arr['type']);
    }

    /**
     * Get HTTP Content-Type request header
     *
     * @return string|NULL The header string or NULL if header not present
     */
    private function getContentTypeHeader(): ?string
    {
        return $this->getHeader('CONTENT_TYPE');
    }

    /**
     * Get HTTP Content-Length request header
     *
     * @return string|NULL The header string or NULL if header not present
     */
    private function getContentLengthHeader(): ?string
    {
        return $this->getHeader('CONTENT_LENGTH');
    }

    /**
     * Get HTTP Accept request header
     *
     * @return string|NULL The header string or NULL if header not present
     */
    private function getAcceptHeader(): ?string
    {
        return $this->getHeader('HTTP_ACCEPT');
    }

    /**
     * Get HTTP Authorization request header
     *
     * @return string|NULL The header string or NULL if header not present
     */
    private function getAuthorizationHeader(): ?string
    {
        return $this->getHeader('HTTP_AUTHORIZATION');
    }

    /**
     * Get HTTP request header
     *
     * @param string $key
     *            The name of the request header in PHP context
     * @return string|NULL The header string or NULL if header not present
     */
    private function getHeader(string $key): ?string
    {
        return $_SERVER[$key] ?? null;
    }
}