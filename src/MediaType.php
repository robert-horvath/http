<?php
declare(strict_types = 1);
namespace RHo\Http;

class MediaType implements MediaTypeInterface
{

    /** @var string */
    private $type;

    /** @var string */
    private $subType;

    /** @var string */
    private $suffix;

    /** @var array */
    private $parameters;

    public function __construct(string $type, string $subType, string $suffix, array $parameters = [])
    {
        $this->type = $type;
        $this->subType = $subType;
        $this->suffix = $suffix;
        $this->parameters = $parameters;
    }

    public function parameter(string $key): ?string
    {
        return $this->parameters[$key] ?? NULL;
    }

    public function subType(): string
    {
        return $this->subType;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function suffix(): ?string
    {
        return $this->suffix;
    }

    public static function init(string $mediaType, ?int &$error): ?MediaTypeInterface
    {
        $matches = NULL;
        $error = self::pregMatch($mediaType, $matches);
        if ($error !== NULL || $matches === NULL)
            return NULL;
        parse_str(str_replace(';', '&', array_pop($matches)), $matches[0]);
        return new self($matches[1], $matches[2], $matches[3], $matches[0]);
    }

    private static function pregMatch(string $mediaType, ?array &$matches): ?int
    {
        $result = preg_match('/^(?:([^\/]+)\/([^+]+)\+([^;]+);([^,]+)){1,128}$/', $mediaType, $matches);
        $error = preg_last_error();
        if ($result === FALSE || $error !== PREG_NO_ERROR)
            return $error;
        if ($result === 0)
            $matches = NULL;
        return NULL;
    }
}