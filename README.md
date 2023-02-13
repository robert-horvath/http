[![Latest Stable Version](https://img.shields.io/packagist/v/robert/http.svg?style=flat-square)](https://packagist.org/packages/robert/http)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%208.1-8892BF.svg?style=flat-square)](https://php.net/)
# HTTP
The HTTP module provides the required interfaces for handling the HTTP communication.
## HTTP Requet Interface
This interface contains the required funcionalities for handling an HTTP request message.
### Example usage
Get properties of an HTTP request message.
```php
use RHo\Http\Request;

function example(RequestInterface $request): void {
    var_dump($request->isHttpsScheme());
    var_dump($request->method());
    var_dump($request->uri());
}
```
If the below HTTP request was received by server:
```
GET /new-users/ HTTP/1.1
User-Agent: Mozilla/4.0 (compatible; MSIE5.01; Windows NT)
Host: ela.do
Accept-Language: en-us
Accept-Encoding: gzip, deflate
Connection: Keep-Alive
```
By calling the `example` function, it will print out the following answer.
```
```
## HTTP Response Interface
This interface contains the required funcionalities for sending an HTTP response message.
### Example usage
Builds and sends an HTTP response message.
```php
use RHo\Http\Response;

function replyWithBadRequest(ResponseInterfaceBuilder $builder): void {
    $builder->init(StatusCode::BadRequest)
        ->withHeader('Content-Type', 'application/prs.api.ela.do+json;version=1') // optional
        ->withBody('{ "apple": "tree" }')  // optional
        ->build()
        ->send();
}
```
By calling the `replyWithBadRequest` function, it will send the below HTTP response message.
```
HTTP/1.1 400 Bad Request
Content-Type: application/prs.api.ela.do+json;version=1
Content-Length: 19

{ "apple": "tree" }
```
## HTTP Exception Interface
This interface contains the required funcionalities for throwing an exception with an HTTP response message.
```php
use RHo\Http;

try {
    // HTTP handling
}
catch (ExceptionInterface $ex) {
    $ex->response()->send();
    exit(-1);
}
```
## HTTP Router Interface
The router interface helps to find the right controller for a given user request.
### Example usage
```php
use RHo\Http;

$router = Router::buildWithRoutingTable([
    '/new-users' => NewUserCtrl::class,
    '/users' => UserCtrl::class,
    '/' => RootCtrl::class
]);
$ctrl = Controller::build($router);
}
```
## HTTP Controller Interface
The controller interface is the main handler of the HTTP request and response messages. The below example shows an end to end handling of such communication.
### Example usage
```php
use RHo\Http;

function main(ControllerInterface $ctrl): void {
    try {
        do {
            $ctrl->validateRequest();
        } while ($ctrl->nextController());
        $ctrl->runService();
        $ctrl->sendResponse();
    }
    catch (ExceptionInterface $ex) {
        $ex->response()->send();
        exit(-1);
    }
}
```