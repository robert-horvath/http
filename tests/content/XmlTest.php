<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

use PHPUnit\Framework\TestCase;
use RHo\Http\Content\Xml as XmlHttpBody;

final class XmlTest extends TestCase
{

    private const XML_ERROR_NAME_REQUIRED = 68;

    public function testValidXmlHttpBodyFromClient(): void
    {
        $obj = new XmlHttpBody('<x><y>z</y></x>');
        $this->assertSame('z', (string) $obj->decode()->y);
        $this->assertNull($obj->errText());
        $this->assertNull($obj->errCode());
    }

    public function testInvalidXmlHttpBodyFromClient(): void
    {
        $obj = new XmlHttpBody('<x<y>z</y></x>');
        $this->assertNull($obj->decode());
        $this->assertSame("error parsing attribute name\nattributes construct error\nCouldn't find end of Start Tag x line 1\nExtra content at the end of the document", $obj->errText());
        $this->assertSame(self::XML_ERROR_NAME_REQUIRED, $obj->errCode());
    }

    public function testValidXmlHttpBodyToClient(): void
    {
        $obj = new XmlHttpBody(new \SimpleXMLElement('<a>b</a>'));
        $this->assertSame("<?xml version=\"1.0\"?>\n<a>b</a>", $obj->encode());
        $this->assertNull($obj->errCode());
        $this->assertNull($obj->errText());
    }
}