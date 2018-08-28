<?php
declare(strict_types = 1);
namespace RHo\Http\Response;

use RHo\Http\AbstractResponse;

class Unauthorized extends AbstractResponse
{

    public function __construct()
    {
        parent::__construct(401);
    }
}