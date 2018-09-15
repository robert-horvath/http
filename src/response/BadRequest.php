<?php
declare(strict_types = 1);
namespace RHo\Http\Response;

class BadRequest extends ResponseBuilder
{

    public function __construct()
    {
        parent::__construct(400);
    }
}