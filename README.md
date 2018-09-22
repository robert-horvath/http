[![Build Status](https://travis-ci.org/robert-horvath/http.svg?branch=master)](https://travis-ci.org/robert-horvath/http)
[![Code Coverage](https://codecov.io/gh/robert-horvath/http/branch/master/graph/badge.svg)](https://codecov.io/gh/robert-horvath/http)
[![Latest Stable Version](https://img.shields.io/packagist/v/robert/http.svg)](https://packagist.org/packages/robert/http)

## HTTP


### Example usage
```php
namespace RHo;

use RHo\ {
  Http\Request\Request as HttpRequest,
  Http\Response\ResponseBuilder as HttpResponseBuilder,
  
  
  
  Http\ControllerBuilder as HttpControllerBuilder,
  MediaType\MediaType,
  StableSort\StableSort  
};

$httpRequest = new HttpRequest();
$mediaTypeFactory = new MediaTypeFactory();
$mediaTypes = [ 
  new MediaType('application', 'prs.api.ela.do+json', [ 'version' => '1' ]),  
  new MediaType('application', 'prs.api.ela.do+xml',  [ 'version' => '2' ]) 
];

$ctrl = (new HttpControllerBuilder(new StableSort())) 
  ->withHttpRequest($httpRequest)
  ->withHttpResponseBuilder(new HttpResponseBuilder())
  ->withContentType(...)
  ->withExpectContent(TRUE)
  ->withSupportedMediaTypes($mediaTypes)
  
  
  
  ->withMediaTypeFactory()
  ->withAuthentication()
  ->build();
  
if ($ctrl->isRequestValid()) {
  var_dump($ctrl->query('foo'));
  var_dump($ctrl->authentication());
  var_dump($ctrl->message()); 
  var_dump($ctrl->clientAcceptsMediaTypes());
}
else
  $ctrl->sendErrorResponse();
```