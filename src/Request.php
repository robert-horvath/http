<?php
declare(strict_types = 1);
namespace RHo\Http;

use BadMethodCallException, RuntimeException;

class Request implements RequestInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \RHo\Http\RequestInterface::header()
     */
    public function header(string $name): ?string
    {
        $f = sprintf('get%sHeader', $name);
        if (! method_exists($this, $f))
            throw new BadMethodCallException("Method [$f] does not exist");
        return call_user_func([
            $this,
            $f
        ]);
    }

    /**
     *
     * {@inheritdoc}
     * @see \RHo\Http\RequestInterface::queryStr()
     */
    public function queryStr(string $name): ?string
    {
        return $_GET[$name] ?? null;
    }

    /**
     *
     * {@inheritdoc}
     * @see \RHo\Http\RequestInterface::body()
     */
    public function body(string $filename = 'php://input'): string
    {
        $str = @file_get_contents($filename);
        if ($str === false)
            $this->throwRuntimeException();
        return $str;
    }

    /**
     *
     * @throws \RuntimeException
     */
    private function throwRuntimeException()
    {
        $arr = error_get_last();
        $msg = sprintf("%s in %s on line %d", $arr['message'], $arr['file'], $arr['line']);
        throw new RuntimeException($msg, $arr['type']);
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
}