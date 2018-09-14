<?php
declare(strict_types = 1);
namespace RHo\Http\Body;

use RHo\Http\BodyInterface;

class Text implements BodyInterface
{

    /** @var mixed */
    protected $value;

    /** @var ?int */
    protected $errCode;

    /** @var ?string */
    protected $errText;

    protected function __construct($value)
    {
        $this->value = $value;
        $this->initErrorFields();
    }

    protected function initErrorFields(): void
    {
        $this->errCode = NULL;
        $this->errText = NULL;
    }

    public static function decode(string $value): BodyInterface
    {
        return new static($value);
    }

    public static function encode($value): BodyInterface
    {
        return new static((string) $value);
    }

    public function errText(): ?string
    {
        return $this->errText;
    }

    public function errCode(): ?int
    {
        return $this->errCode;
    }

    public function value()
    {
        if ($this->errCode === NULL)
            return $this->value;
        return NULL;
    }
}