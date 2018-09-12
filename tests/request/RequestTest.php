<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

require_once __DIR__ . '/../mock_functions.php';

use RHo\Http\Request;
use PHPUnit\Framework\TestCase;

final class RequestTest extends TestCase
{

    private const PHP_INPUT_FILE = __DIR__ . '/../body-ok.json';

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
        $_SERVER['CONTENT_TYPE'] = 'x';
        $_SERVER['CONTENT_LENGTH'] = '1';

        $this->assertSame("foo", $this->req->header('Accept'));
        $this->assertNull($this->req->header('Authorization'));
        $this->assertSame('x', $this->req->header('Content-Type'));
        $this->assertSame('1', $this->req->header('Content-Length'));
    }

    public function testBodySuccess(): void
    {
        $GLOBALS['file_get_contents'] = self::PHP_INPUT_FILE;
        $body = file_get_contents(self::PHP_INPUT_FILE);
        $this->assertSame($body, $this->req->body());
    }

    /**
     *
     * @expectedException RuntimeException
     * @expectedExceptionMessage file_get_contents(unknown.json): failed to open stream: No such file or directory
     */
    public function testBodyInputReadError(): void
    {
        $GLOBALS['file_get_contents'] = 'unknown.json';
        $this->req->body();
    }

    /**
     *
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage Function RHo\Http\Request::getqwertzuiopHeader() does not exist
     */
    public function testNotImplementedHeader(): void
    {
        $this->req->header('qwertzuiop');
    }
}