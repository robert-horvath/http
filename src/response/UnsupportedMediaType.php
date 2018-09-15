<?php
declare(strict_types = 1);
namespace RHo\Http\Response;

class UnsupportedMediaType extends ResponseBuilder
{

    public function __construct()
    {
        parent::__construct(415);
    }
}