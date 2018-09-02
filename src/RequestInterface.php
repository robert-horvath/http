<?php
namespace RHo\Http;

interface RequestInterface
{

    /**
     * Get HTTP header
     *
     * @param string $header
     *            The name of the header
     * @return string|NULL The value of header, or NULL if header name not present
     * @throws \BadMethodCallException If user func, to read header, not implemented
     */
    function header(string $name): ?string;

    /**
     * Get Query String
     *
     * @param string $name
     *            The field name of query string
     * @return string|NULL The field value of query string, or NULL if field name is not set
     */
    function queryStr(string $name): ?string;

    /**
     * Get HTTP message body
     *
     * @param string $filename
     *            The file name of HTTP request message
     * @return string The HTTP request body
     * @throws \RuntimeException If file cannot be found
     */
    function body(string $filename = 'php://input'): string;
}