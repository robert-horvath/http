<?php
declare(strict_types = 1);
namespace RHo\Http;

use PHPUnit\Framework\TestCase;

final class RequestTest extends TestCase
{

    public function testGet(): void
    {
        $req = new Request();
        $this->assertEquals("bar", $req->get("foo"));
        $this->assertNull($req->get("bar"));
    }

    public function testServer(): void
    {
        $req = new Request();
        $this->assertEquals("foo", $req->server("bar"));
        $this->assertNull($req->server("foo"));
    }

    public function testBodySuccess(): void
    {
        $obj = new \stdClass();
        $obj->name = "Róbert";
        
        $req = new Request(__DIR__ . '/body-ok.json');
        $this->assertEquals($obj, $req->body());
    }

    /**
     * @expectedException DomainException
     * @expectedExceptionMessage Syntax error
     */
    public function testBodySyntaxError(): void
    {
        $req = new Request(__DIR__ . '/syntax-error.txt');
        $req->body();
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage file_get_contents(unknown.json): failed to open stream: No such file or directory
     */
    public function testBodyInputReadError(): void
    {
        $req = new Request('unknown.json');
        $req->body();
    }
}