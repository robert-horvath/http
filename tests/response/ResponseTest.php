<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

use RHo\Http\Response as HttpResponse;
use PHPUnit\Framework\TestCase;

/**
 *
 * @runTestsInSeparateProcesses
 */
final class ResponseTest extends TestCase
{

    public function testBadRequest(): void
    {
        $res = new HttpResponse\BadRequest();
        $res->withBody('test')->withHeader('Content-Type', 'application/json;charset=UTF-8');
        $res->build()->send();

        $this->assertSame(400, http_response_code());
        $headers = xdebug_get_headers();
        $this->assertArraySubset([
            'Content-Type: application/json;charset=UTF-8'
        ], $headers);
        $this->expectOutputString('test');
    }

    public function testUnauthorized(): void
    {
        $res = new HttpResponse\Unauthorized('Basic realm="Access to the staging site", charset="UTF-8');
        $res->withHeader('Content-Type', 'application/vnd.api+json;version=1');
        $res->build()->send();

        $this->assertSame(401, http_response_code());
        $headers = xdebug_get_headers();
        $this->assertArraySubset([
            'WWW-Authenticate: Basic realm="Access to the staging site", charset="UTF-8',
            'Content-Type: application/vnd.api+json;version=1'
        ], $headers);
        $this->expectOutputString('');
    }
}