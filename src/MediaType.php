<?php
declare(strict_types = 1);
namespace RHo\Http;

class MediaType implements MediaTypeInterface
{

    /** @var array|NULL */
    private $matches;

    /** @var array|NULL */
    private $parameters;

    private function __construct(string $mediaType)
    {
        if (preg_match('/^([^\/]+)\/([^+]+)\+([^;]+);([^,]+)$/', $mediaType, $this->matches) === 1)
            parse_str(str_replace(';', '&', array_pop($this->matches)), $this->parameters);
        else 
            $this->matches = NULL;
    }

    private function valid(): bool
    {
        if ($this->matches === NULL)
            return FALSE;
        return TRUE;
    }

    public function parameter(string $key): ?string
    {
        return $this->parameters[$key] ?? NULL;
    }

    public function subType(): string
    {
        return $this->matches[2];
    }

    public function type(): string
    {
        return $this->matches[1];
    }

    public function suffix(): ?string
    {
        return $this->matches[3];
    }

    public static function init(string $mediaType): ?MediaType
    {
        $mt = new self($mediaType);
        if ($mt->valid())
            return $mt;
        return NULL;
    }
}