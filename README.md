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
namespace RHo\Http;

try {
  $req = new Request();
  $req->queryStr("foo");        // string(3) "bar"
  $req->queryStr("baz");        // NULL
  $req->header("Accept");       // string(16) "plain/text;q=0.1"
  $req->header("Authorization");// NULL
  $req->body();                 // string(13) "{ "a": true }"
} catch (\BadMethodCallException $e) {
  // Get HTTP header function not implemented
} catch (\RuntimeException $e) {
  // Cannot open HTTP body file
}

$mTypes = new MediaTypeCollection($req->header("Accept"));
foreach ($mTypes as $mt) {      // $mt is a RHo\Http\MediaType object
  $mt->str();                   // string(16) "plain/text;q=0.1"
  $mt->valid();                 // bool(true)
  $mt->errCode();               // NULL
  $mt->errText();               // string(0) ""
  $mt->type();                  // string(5) "plain"
  $mt->subType();               // string(4) "text"
  $mt->suffix();                // NULL
  $mt->parameter('version');    // NULL
  $mt->parameter('q');          // string(3)  "0.1"
}

$msg = new RHo\Http\Message($req->header("Content-Type"),
                            $req->body());
$msg->data();             // class stdClass#1 (1) { public $a => bool(true) }
$mt = $msg->mediaType();  // $mt is a RHo\Http\MediaType object 
                          // or NULL if Content-Type heaader is not set
$mt->str();               // string(41) "application/prs.api.ela.do+json;version=1"
$mt->valid();             // bool(true)
$mt->errCode();           // NULL
$mt->errText();           // string(0) ""
$mt->type();              // string(11) "application"
$mt->subType();           // string(14) "prs.api.ela.do"
$mt->suffix();            // string(4) "json"
$mt->parameter('version');// string(1)  "1"
$mt->parameter('q');      // NULL
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

$mt = MediaType::init('application/vnd.api+json;version=1', $error); // Returns NULL if media type wrong
$mt->type();               // 'application'
$mt->subType();            // 'vnd.api'
$mt->suffix();             // 'json'
$mt->parameter('version'); // '1'
$mt->parameter('q');       // NULL
```

### Example usage of HTTP JSON Body
```php
namespace RHo\Http\Body\Json as JsonHttpBody;

$json = new JsonHttpBody();

// client -> server
$err = $json->decode('false'); 
if ($err === NULL) {
  echo $json->value(); // bool(false)
  echo $json->str();   // string(5) "false"
} else
  echo $err . ': ' . $json->errStr();

// server -> client
$err = $json->encode(true);
if ($err === NULL) {
  echo $json->value(); // bool(true)
  echo $json->str();   // string(4) "true"
} else
  echo $err . ': ' . $json->errStr();
```