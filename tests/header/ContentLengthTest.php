<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

use RHo\Http\ {
    Request as HttpReq,
    Header\ContentLength as HttpContentLengthHeader
};
use PHPUnit\Framework\TestCase;

final class ContentLengthTest extends TestCase
{

    public function testHttpReqMsgNoContentLength()
    {
        unset($_SERVER['CONTENT_LENGTH']);
        $contentLength = new HttpContentLengthHeader(new HttpReq());

        $this->assertFalse($contentLength->isSet());
        $this->assertFalse($contentLength->isValid());
        $this->assertSame(0, $contentLength->value());
    }

    public function testHttpReqMsgWithContentLength()
    {
        $_SERVER['CONTENT_LENGTH'] = '5';
        $contentLength = new HttpContentLengthHeader(new HttpReq());

        $this->assertTrue($contentLength->isSet());
        $this->assertTrue($contentLength->isValid());
        $this->assertSame(5, $contentLength->value());
    }

    public function testHttpReqMsgWithNegativeContentLength()
    {
        $_SERVER['CONTENT_LENGTH'] = '-8';
        $contentLength = new HttpContentLengthHeader(new HttpReq());

        $this->assertTrue($contentLength->isSet());
        $this->assertFalse($contentLength->isValid());
        $this->assertSame(0, $contentLength->value());
    }

    public function testHttpReqMsgWithInvalidContentLength()
    {
        $_SERVER['CONTENT_LENGTH'] = '1e10';
        $contentLength = new HttpContentLengthHeader(new HttpReq());

        $this->assertTrue($contentLength->isSet());
        $this->assertFalse($contentLength->isValid());
        $this->assertSame(0, $contentLength->value());
    }

    public function testHttpReqMsgWithEmptyContentLength()
    {
        $_SERVER['CONTENT_LENGTH'] = '';
        $contentLength = new HttpContentLengthHeader(new HttpReq());

        $this->assertTrue($contentLength->isSet());
        $this->assertFalse($contentLength->isValid());
        $this->assertSame(0, $contentLength->value());
    }
}