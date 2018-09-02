<?php
declare(strict_types = 1);
namespace RHo\Http\Body;

use RHo\Http\BodyInterface;

class PlainText implements BodyInterface
{

    /** @var mixed */
    protected $val;

    /** @var string */
    protected $str;

    /** @var string */
    protected $errStr = '';

    public function decode(string $str): ?int
    {
        $this->str = $str;
        $this->val = $str;
        return NULL;
    }

    public function encode($value): ?int
    {
        $this->val = $value;
        $this->str = (string) $value;
        return NULL;
    }

    final public function errStr(): string
    {
        return $this->errStr;
    }

    final public function str(): string
    {
        return $this->str;
    }

    final public function value()
    {
        return $this->val;
    }
}