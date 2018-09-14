<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

use RHo\Http\ {
    Request as HttpReq,
    Header\ContentType as HttpContentTypeHeader,
    MediaType as HttpMediaType
};
use PHPUnit\Framework\TestCase;

final class ContentTypeTest extends TestCase
{

    public function testHttpReqMsgNoContentType()
    {
        unset($_SERVER['CONTENT_TYPE']);
        $contentType = new HttpContentTypeHeader(new HttpReq());

        $this->assertFalse($contentType->isSet());
        $this->assertFalse($contentType->isValid());
        $this->assertFalse($contentType->isSupported([
            new HttpMediaType('text', 'plain+text')
        ]));
        $this->assertNull($contentType->value());
    }

    public function testHttpReqMsgSupportContentType()
    {
        $_SERVER['CONTENT_TYPE'] = 'text/plain+text';
        $contentType = new HttpContentTypeHeader(new HttpReq());

        $this->assertTrue($contentType->isValid());
        $this->assertTrue($contentType->isSet());
        $this->assertTrue($contentType->isSupported([
            new HttpMediaType('text', 'plain+text')
        ]));
        $this->assertSame('text/plain+text', (string) $contentType->value());
    }

    public function testHttpReqMsgSupportContentTypeFromListJson()
    {
        $_SERVER['CONTENT_TYPE'] = 'application/prs.api.ela.do+json;version=1';
        $contentType = new HttpContentTypeHeader(new HttpReq());

        $this->assertTrue($contentType->isSet());
        $this->assertTrue($contentType->isValid());
        $this->assertSame('application/prs.api.ela.do+json;version=1', (string) $contentType->value());
        $this->assertTrue($contentType->isSupported([
            new HttpMediaType('application', 'prs.api.ela.do+json'),
            new HttpMediaType('application', 'prs.api.ela.do+xml')
        ]));
    }

    public function testHttpReqMsgSupportContentTypeFromListXml()
    {
        $_SERVER['CONTENT_TYPE'] = 'application/prs.api.ela.do+xml;version=2';
        $contentType = new HttpContentTypeHeader(new HttpReq());

        $this->assertTrue($contentType->isSet());
        $this->assertTrue($contentType->isSupported([
            new HttpMediaType('application', 'prs.api.ela.do+json'),
            new HttpMediaType('application', 'prs.api.ela.do+xml')
        ]));
        $this->assertSame('application/prs.api.ela.do+xml;version=2', (string) $contentType->value());
        $this->assertTrue($contentType->isValid());
    }

    public function testHttpReqMsgNotSupportContentType()
    {
        $_SERVER['CONTENT_TYPE'] = 'text/plain';
        $contentType = new HttpContentTypeHeader(new HttpReq());

        $this->assertSame('text/plain', (string) $contentType->value());
        $this->assertFalse($contentType->isSupported([
            new HttpMediaType('image', 'png')
        ]));
        $this->assertTrue($contentType->isValid());
        $this->assertTrue($contentType->isSet());
    }

    public function testHttpReqMsgInvalidContentType()
    {
        $_SERVER['CONTENT_TYPE'] = '????????';
        $contentType = new HttpContentTypeHeader(new HttpReq());

        $this->assertFalse($contentType->isSupported());
        $this->assertFalse($contentType->isValid());
        $this->assertNull($contentType->value());
        $this->assertTrue($contentType->isSet());
    }

    public function testHttpReqMsgWithEmptyContentType()
    {
        $_SERVER['CONTENT_TYPE'] = '';
        $contentType = new HttpContentTypeHeader(new HttpReq());

        $this->assertFalse($contentType->isSupported());
        $this->assertFalse($contentType->isValid());
        $this->assertNull($contentType->value());
        $this->assertTrue($contentType->isSet());
    }
}