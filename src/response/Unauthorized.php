<?php
declare(strict_types = 1);
namespace RHo\Http\Response;

class Unauthorized extends ResponseBuilder
{

    public function __construct(string $headerWWWAuthenticate)
    {
        parent::__construct(401);
        $this->withHeader('WWW-Authenticate', $headerWWWAuthenticate);
    }
}