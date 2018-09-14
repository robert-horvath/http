<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

require_once __DIR__ . '/mock_functions.php';

use RHo\Http\ {
    Request,
    Body\Factory as BodyFactory,
    Header\ContentType as ContentTypeHeader
};
use PHPUnit\Framework\TestCase;

final class HttpTest extends TestCase
{

    private const PHP_INPUT_JSON_FILE = __DIR__ . '/body-ok.json';

    private const PHP_INPUT_XML_FILE = __DIR__ . '/body-ok.xml';

    private $req;

    protected function setUp()
    {
        $this->req = new Request();
    }

    public function testHttpReqPlainTextContentType()
    {
        $_SERVER['CONTENT_TYPE'] = 'text/plain+text';
        $GLOBALS['file_get_contents'] = self::PHP_INPUT_JSON_FILE;

        $mt = new ContentTypeHeader($this->req);
        $c = BodyFactory::build($mt->value());

        $this->assertSame('{"name": "Róbert"}', $c->decode($this->req->body()));
        $this->assertNull($c->errCode());
        $this->assertNull($c->errText());
    }

    public function testHttpReqJsonContentType()
    {
        $_SERVER['CONTENT_TYPE'] = 'application/prs.api.ela.do+json;version=1';
        $_SERVER['CONTENT_LENGTH'] = '2';
        $GLOBALS['file_get_contents'] = self::PHP_INPUT_JSON_FILE;

        $mt = new ContentTypeHeader($this->req);
        $c = BodyFactory::build($mt->value());

        $this->assertEquals((object) [
            "name" => "Róbert"
        ], $c->decode($this->req->body()));
        $this->assertNull($c->errCode());
        $this->assertNull($c->errText());
    }

    public function testHttpReqXmlContentType()
    {
        $_SERVER['CONTENT_TYPE'] = 'application/prs.api.ela.do+xml;version=2';
        $_SERVER['CONTENT_LENGTH'] = '20';
        $GLOBALS['file_get_contents'] = self::PHP_INPUT_XML_FILE;

        $mt = new ContentTypeHeader($this->req);
        $c = BodyFactory::build($mt->value());

        $this->assertSame('Róbert', (string) $c->decode($this->req->body()));
        $this->assertNull($c->errCode());
        $this->assertNull($c->errText());
    }

    public function testHttpReqMsgNotSupportContentType()
    {
        $_SERVER['CONTENT_TYPE'] = 'text/plain';
        $_SERVER['CONTENT_LENGTH'] = '0';

        $mt = new ContentTypeHeader($this->req);
        $c = BodyFactory::build($mt->value());

        $this->assertSame('', (string) $c->decode($this->req->body()));
        $this->assertNull($c->errCode());
        $this->assertNull($c->errText());
    }
}