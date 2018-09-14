<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

use PHPUnit\Framework\TestCase;
use RHo\Http\Body\Xml as HttpXmlBody;

final class XmlTest extends TestCase
{

    private const XML_ERROR_NAME_REQUIRED = 68;

    public function testValidXmlHttpBodyFromClient(): void
    {
        $body = HttpXmlBody::decode('<x><y>z</y></x>');
        $this->assertSame('z', (string) $body->value()->y);
        $this->assertNull($body->errText());
        $this->assertNull($body->errCode());
    }

    public function testInvalidXmlHttpBodyFromClient(): void
    {
        $body = HttpXmlBody::decode('<x<y>z</y></x>');
        $this->assertNull($body->value());
        $this->assertSame("error parsing attribute name\nattributes construct error\nCouldn't find end of Start Tag x line 1\nExtra content at the end of the document", $body->errText());
        $this->assertSame(self::XML_ERROR_NAME_REQUIRED, $body->errCode());
    }

    public function testValidXmlHttpBodyToClient(): void
    {
        $body = HttpXmlBody::encode(new \SimpleXMLElement('<a>b</a>'));
        $this->assertSame("<?xml version=\"1.0\"?>\n<a>b</a>", $body->value());
        $this->assertNull($body->errCode());
        $this->assertNull($body->errText());
    }
}