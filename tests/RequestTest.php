<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

use RHo\Http\Request;
use PHPUnit\Framework\TestCase;

final class RequestTest extends TestCase
{

    private $req;

    protected function setUp()
    {
        $this->req = new Request();
    }

    public function testQueryString(): void
    {
        $this->assertSame("bar", $this->req->queryStr("foo"));
        $this->assertNull($this->req->queryStr("bar"));
    }

    public function testHeader(): void
    {
        $this->assertSame("foo", $this->req->header('Accept'));
        $this->assertNull($this->req->header('Authorization'));
    }

    public function testBodySuccess(): void
    {
        $filename = __DIR__ . '/data/body-ok.json';
        $body = file_get_contents($filename);
        $this->assertSame($body, $this->req->body($filename));
    }

    /**
     *
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage file_get_contents(unknown.json): failed to open stream: No such file or directory
     */
    public function testBodyInputReadError(): void
    {
        $this->req->body('unknown.json');
    }

    /**
     *
     * @expectedException TypeError
     * @expectedExceptionMessage call_user_func() expects parameter 1 to be a valid callback, class 'RHo\Http\Request' does not have a method 'getqwertzuiopHeader'
     */
    public function testNotImplementedHeader(): void
    {
        $this->req->header('qwertzuiop');
    }
}