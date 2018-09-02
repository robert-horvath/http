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
        $res->setBody('test');
        $res->setHeader('Content-Type', 'application/json;charset=UTF-8');
        $res->send(FALSE);

        $this->assertSame(400, http_response_code());
        $headers = xdebug_get_headers();
        $this->assertArraySubset([
            'Content-Type: application/json;charset=UTF-8'
        ], $headers);
        $this->expectOutputString('test');
    }

    public function testUnauthorized(): void
    {
        $res = new HttpResponse\Unauthorized();
        $res->setHeader('Content-Type', 'application/vnd.api+json;version=1');
        $res->send(FALSE);

        $this->assertSame(401, http_response_code());
        $headers = xdebug_get_headers();
        $this->assertArraySubset([
            'Content-Type: application/vnd.api+json;version=1'
        ], $headers);
        $this->expectOutputString('');
    }
}