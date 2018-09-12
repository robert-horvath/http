[![Build Status](https://travis-ci.org/robert-horvath/http.svg?branch=master)](https://travis-ci.org/robert-horvath/http)
[![Code Coverage](https://codecov.io/gh/robert-horvath/http/branch/master/graph/badge.svg)](https://codecov.io/gh/robert-horvath/http)
[![Latest Stable Version](https://img.shields.io/packagist/v/robert/http.svg)](https://packagist.org/packages/robert/http)

## Http
The HTTP module is a thin wrapper class to access the HTTP request and response message information as well as [Media Type](https://en.wikipedia.org/wiki/Media_type) format.


### Example usage of HTTP Request class
```php
/*
 * POST /new-users?foo=bar HTTP/1.1
 * Host: example.com
 * Accept: plain/text;q=0.1
 * Content-Type: application/prs.api.ela.do+json;version=1
 * Content-Length: 13
 *
 * { "a": true }
 */
$req = new RHo\Http\Request();
$req->queryStr("foo"); // string(3) "bar"
$req->queryStr("baz"); // NULL

try {
  $req->header("Accept");        // string(16) "plain/text;q=0.1"
  $req->header("Authorization"); // NULL
} catch (BadMethodCallException $e) {
  // Get HTTP header function not implemented
}

try {
  $req->body(); // string(13) "{ "a": true }"
} catch (RuntimeException $e) {
  // Cannot open HTTP body file
}
```


### Example usage of HTTP MediaType class
```php
$mt = new RHo\Http\MediaType('application', 'vnd.api+json');
$mt->setParameter('version', '1');

var_dump($mt);                 // string(34) "application/vnd.api+json;version=1"
$mt->type();                   // string(11) "application"
$mt->subType();                // string(12) "vnd.api+json"
$mt->structuredSyntaxSuffix(); // string(4)  "json"
$mt->parameter('version');     // string(1)  "1"
$mt->parameter('q');           // NULL
```

### Example usage of HTTP MediaType class with init string
```php
try {
  $mt = RHo\Http\MediaType::initWithStr('*/*;version=2');

  $arr = new RHo\Http\MediaType::initWithCSV('image/jpg,plain/text');
  foreach ($arr as $mt) {
    // $mt is a RHo\Http\MediaType|NULL
  }
} catch (RuntimeException $e) {
  // Regular expression error
}
```

### Example usage of HTTP Message class
```php
$msg = new RHo\Http\Message(new RHo\Http\Request());
$msg->setSupportedContentTypes([
  new HttpMediaType('plain/text'), 
  new HttpMediaType('image/png')
]);

$msg->hasContentType();        // bool(true)
$msg->isContentTypeSupported() // bool(true)
$msg->contentType();           // RHo\Http\MediaType|NULL
$msg->hasContent();            // bool(true)
$msg->contentSize();           // int(10)
$json = $msg->content();       // RHo\Http\Body\Json
$json->decode();               // class stdClass#1 (1) { public $a => bool(true) }
```

### Example usage of HTTP Unauthorized Response class
```php
namespace RHo\Http\Response;

$res = new Unauthorized('Basic realm="User Visible Realm"');
$res->setBody('Example answer');
```