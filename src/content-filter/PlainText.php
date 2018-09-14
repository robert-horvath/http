<?php
declare(strict_types = 1);
namespace RHo\Http\Content;

use RHo\Http\ContentFilterInterface;

class PlainText implements ContentFilterInterface
{

    /** @var mixed */
    protected $value;

    /** @var ?int */
    protected $errCode;

    /** @var ?string */
    protected $errText;

    public function decode(string $value)
    {
        return $this->value($value);
    }

    public function encode($value): ?string
    {
        return $this->value((string) $value);
    }

    public function errText(): ?string
    {
        return $this->errText;
    }

    public function errCode(): ?int
    {
        return $this->errCode;
    }

    protected function value($value)
    {
        if ($this->errCode === NULL)
            return $value;
        return NULL;
    }
}