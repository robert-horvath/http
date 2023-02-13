<?php

declare(strict_types=1);

namespace RHo\Http;

enum StatusCode
{
    // Successful responses
    case OK;
    case Created;
    case Accepted;

    // Client error responses
    case BadRequest;
    case Unauthorized;
    case Forbidden;
    case NotFound;
    case MethodNotAllowed;
    case NotAcceptable;
    case UnsupportedMediaType;

    // Server error responses
    case InternalServerError;
    case NotImplemented;
    case ServiceUnavailable;
}
