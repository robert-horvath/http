<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

require_once __DIR__ . '/../mock_functions.php';

use RHo\Http\ {
    Request as HttpReq,
    Request\Message as HttpReqMsg,
    MediaType as HttpMediaType
};
use PHPUnit\Framework\TestCase;

final class RequestMessageTest extends TestCase
{

    private const PHP_INPUT_JSON_FILE = __DIR__ . '/../body-ok.json';

    private const PHP_INPUT_XML_FILE = __DIR__ . '/../body-ok.xml';

    public function testHttpReqMsgNoContentType()
    {
        unset($_SERVER['CONTENT_TYPE']);
        unset($_SERVER['CONTENT_LENGTH']);

        $msg = new HttpReqMsg(new HttpReq());
        $msg->setSupportedContentTypes([
            new HttpMediaType('text', 'plain+text')
        ]);

        $this->assertFalse($msg->hasContentType());
        $this->assertFalse($msg->hasContent());
        $this->assertSame(0, $msg->contentSize());
    }

    public function testHttpReqMsgSupportContentType()
    {
        $_SERVER['CONTENT_TYPE'] = 'text/plain+text';
        $_SERVER['CONTENT_LENGTH'] = '5';
        $GLOBALS['file_get_contents'] = self::PHP_INPUT_JSON_FILE;

        $msg = new HttpReqMsg(new HttpReq());
        $msg->setSupportedContentTypes([
            new HttpMediaType('text', 'plain+text')
        ]);

        $this->assertTrue($msg->hasContentType());
        $this->assertTrue($msg->isContentTypeSupported());
        $this->assertTrue($msg->hasContent());
        $this->assertSame(5, $msg->contentSize());
        $this->assertInstanceOf(\RHo\Http\Content\PlainText::class, $msg->content());
        $c = $msg->content();
        $this->assertSame('{"name": "Róbert"}', $c->decode());
        $this->assertNull($c->errCode());
        $this->assertNull($c->errText());
    }

    public function testHttpReqMsgSupportContentTypeFromListJson()
    {
        $_SERVER['CONTENT_TYPE'] = 'application/prs.api.ela.do+json;version=1';
        $_SERVER['CONTENT_LENGTH'] = '2';
        $GLOBALS['file_get_contents'] = self::PHP_INPUT_JSON_FILE;

        $msg = new HttpReqMsg(new HttpReq());
        $msg->setSupportedContentTypes([
            new HttpMediaType('application', 'prs.api.ela.do+json'),
            new HttpMediaType('application', 'prs.api.ela.do+xml')
        ]);

        $this->assertTrue($msg->hasContentType());
        $this->assertTrue($msg->isContentTypeSupported());
        $this->assertSame('application/prs.api.ela.do+json;version=1', (string) $msg->contentType());
        $this->assertTrue($msg->hasContent());
        $this->assertSame(2, $msg->contentSize());
        $this->assertInstanceOf(\RHo\Http\Content\Json::class, $msg->content());
        $c = $msg->content();
        $this->assertEquals((object) [
            "name" => "Róbert"
        ], $c->decode());
        $this->assertNull($c->errCode());
        $this->assertNull($c->errText());
    }

    public function testHttpReqMsgSupportContentTypeFromListXml()
    {
        $_SERVER['CONTENT_TYPE'] = 'application/prs.api.ela.do+xml;version=2';
        $_SERVER['CONTENT_LENGTH'] = '20';
        $GLOBALS['file_get_contents'] = self::PHP_INPUT_XML_FILE;

        $msg = new HttpReqMsg(new HttpReq());
        $msg->setSupportedContentTypes([
            new HttpMediaType('application', 'prs.api.ela.do+json'),
            new HttpMediaType('application', 'prs.api.ela.do+xml')
        ]);

        $this->assertTrue($msg->hasContentType());
        $this->assertTrue($msg->isContentTypeSupported());
        $this->assertSame('application/prs.api.ela.do+xml;version=2', (string) $msg->contentType());
        $this->assertTrue($msg->hasContent());
        $this->assertSame(20, $msg->contentSize());
        $this->assertInstanceOf(\RHo\Http\Content\Xml::class, $msg->content());
        $c = $msg->content();
        $this->assertSame('Róbert', (string) $c->decode());
        $this->assertNull($c->errCode());
        $this->assertNull($c->errText());
    }

    public function testHttpReqMsgNotSupportContentType()
    {
        $_SERVER['CONTENT_TYPE'] = 'text/plain';
        $_SERVER['CONTENT_LENGTH'] = '0';

        $msg = new HttpReqMsg(new HttpReq());
        $msg->setSupportedContentTypes([
            new HttpMediaType('image', 'png')
        ]);
        $this->assertTrue($msg->hasContentType());
        $this->assertFalse($msg->isContentTypeSupported());
        $this->assertTrue($msg->hasContent());
        $this->assertSame(0, $msg->contentSize());
        $this->assertNull($msg->content());
    }
}