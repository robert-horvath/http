<?php
declare(strict_types = 1);
namespace RHo\Http\Response;

class Unauthorized extends AbstractResponse
{

    public function __construct(string $headerWWWAuthenticate)
    {
        parent::__construct(401);
        parent::setHeader('WWW-Authenticate', $headerWWWAuthenticate);
    }
}