[![Build Status](https://travis-ci.org/robert-horvath/http-request.svg?branch=master)](https://travis-ci.org/robert-horvath/http-request)
[![Code Coverage](https://codecov.io/gh/robert-horvath/http-request/branch/master/graph/badge.svg)](https://codecov.io/gh/robert-horvath/http-request)
[![Latest Stable Version](https://img.shields.io/packagist/v/robert/http-request.svg)](https://packagist.org/packages/robert/http-request)

# Http Request
The HTTP request module is a thin wrapper class to access the HTTP request message information.

## Example usage
```php
namespace RHo\Http;

$req = new Request();
$req->get("foo"); // Get query string foo
$req->server("bar"); // Get server variable bar. E.g.: read header
$req->isJsonContentType(); // returns TRUE or FALSE

try {
    $ui = $req->body(); // Get json body. Returns \stdClass
    $ui->email; // Example parameter
} catch (\DomainException $e) {
    // JSON body error
} catch (\UnexpectedValueException $e) {
    // Not JSON content type
} catch (\InvalidArgumentException $e) {
    // Cannot read entire file into a string
}
```