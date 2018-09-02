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
$mt = new RHo\Http\MediaType();
$mt->setTypes('application', 'vnd.api+json');
$mt->setParameter('version', '1');

$mt->str();                    // string(34) "application/vnd.api+json;version=1"
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
} catch (RuntimeException $e) {
  // Regular expression error
}
```

### Example usage of HTTP MediaTypeCollection class
```php
$mtc = new RHo\Http\MediaTypeCollection($req->header("Accept"));
$mtc->errCode();             // NULL
$mtc->errText();             // string(0) ""
foreach ($mtc as $mt) {      // $mt is a RHo\Http\MediaType|NULL
  $mt->str();                // string(16) "plain/text;q=0.1"
  $mt->type();               // string(5) "plain"
  $mt->subType();            // string(4) "text"
  $mt->suffix();             // NULL
  $mt->parameter('version'); // NULL
  $mt->parameter('q');       // string(3) "0.1"
}
```

### Example usage of HTTP Message class
```php
$msg = new RHo\Http\Message(new RHo\Http\Request());
$json = $msg->data();            // class stdClass#1 (1) { public $a => bool(true) }
$mtf = $msg->mediaTypeFactory(); // RHo\Http\MediaTypeFactory
```

### Example usage of HTTP Unauthorized Response class
```php
namespace RHo\Http\Response;

$res = new Unauthorized('Basic realm="User Visible Realm"');
$res->setBody('Example answer');
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