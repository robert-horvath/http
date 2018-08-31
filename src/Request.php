<?php
declare(strict_types = 1);
namespace RHo\Http;

use InvalidArgumentException;

class Request implements RequestInterface
{

    /**
     *
     * @throws \TypeError If user func not implemented
     */
    public function header(string $key): ?string
    {
        return call_user_func([
            $this,
            "get${key}Header"
        ]);
    }

    public function queryStr(string $key): ?string
    {
        return $_GET[$key] ?? null;
    }

    public function body(string $filename = 'php://input'): ?string
    {
        $str = @file_get_contents($filename);
        if ($str === false)
            $this->throwInvalidArgumentException();
        return $str;
    }

    private function getAcceptHeader(): ?string
    {
        return $this->getHeader('HTTP_ACCEPT');
    }

    private function getAuthorizationHeader(): ?string
    {
        return $this->getHeader('HTTP_AUTHORIZATION');
    }

    private function getHeader(string $key): ?string
    {
        return $_SERVER[$key] ?? null;
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
}