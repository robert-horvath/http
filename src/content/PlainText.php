<?php
declare(strict_types = 1);
namespace RHo\Http\Content;

class PlainText implements ContentInterface
{

    /** @var mixed */
    protected $value;

    /** @var ?int */
    protected $errCode;

    /** @var ?string */
    protected $errText;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function decode()
    {
        return $this->value((string) $this->value);
    }

    public function encode(): ?string
    {
        return $this->value((string) $this->value);
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