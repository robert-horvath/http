[![Build Status](https://travis-ci.org/robert-horvath/http.svg?branch=master)](https://travis-ci.org/robert-horvath/http)
[![Code Coverage](https://codecov.io/gh/robert-horvath/http/branch/master/graph/badge.svg)](https://codecov.io/gh/robert-horvath/http)
[![Latest Stable Version](https://img.shields.io/packagist/v/robert/http.svg)](https://packagist.org/packages/robert/http)

## Http
The HTTP module is a thin wrapper class to access the HTTP request and response message information as well as [Media Type](https://en.wikipedia.org/wiki/Media_type) format.

### Example usage of HTTP Request class
```php
namespace RHo\Http;

$req = new Request();
$req->queryStr("foo");  // Get query string foo
$req->header("Accept"); // Get HTTP Accept request header
$req->body();           // Get HTTP message body
```

### Example usage of HTTP Unauthorized Response class
```php
namespace RHo\Http\Response;

$res = new Unauthorized();
$res->setHeader('WWW-Authenticate', 'Basic realm="User Visible Realm"');
$res->setBody('Example answer');
$res->send(); // Terminates script execution
```

### Example usage of MediaType class
```php
namespace RHo\Http;

$mt = MediaType::init('application/vnd.api+json;version=1'); // Returns NULL if media type wrong
$mt->type();               // 'application'
$mt->subType();            // 'vnd.api'
$mt->suffix();             // 'json'
$mt->parameter('version'); // '1'
$mt->parameter('q');       // NULL
```