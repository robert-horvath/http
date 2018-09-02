<?php
declare(strict_types = 1);
namespace RHo\Http;

class MediaTypeCollection
{

    /** @var array */
    private $mediaTypes;

    public function __construct()
    {
        $this->mediaTypes = [];
    }

    public function add(MediaType $mediaType)
    {
        $this->mediaTypes[] = $mediaType;
    }
}