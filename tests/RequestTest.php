<?php
declare(strict_types = 1);
namespace RHoTest\Http;

use RHo\Http\Request;
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

    public function testContentType(): void
    {
        $req = new Request();
        $this->assertTrue($req->isJsonContentType());
    }

    /**
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage text/html
     */
    public function testHtmlContentType(): void
    {
        $_SERVER['CONTENT_TYPE'] = 'text/html';
        $req = new Request();
        $req->body();
    }

    public function testBodySuccess(): void
    {
        $obj = new \stdClass();
        $obj->name = "Róbert";
        
        $req = new Request(__DIR__ . '/data/body-ok.json');
        $this->assertEquals($obj, $req->body());
    }

    /**
     * @expectedException DomainException
     * @expectedExceptionMessage Syntax error
     */
    public function testBodySyntaxError(): void
    {
        $req = new Request(__DIR__ . '/data/syntax-error.txt');
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