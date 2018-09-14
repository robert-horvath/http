<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

use PHPUnit\Framework\TestCase;
use RHo\Http\Content\Xml as HttpXmlBody;

final class XmlTest extends TestCase
{

    private const XML_ERROR_NAME_REQUIRED = 68;

    /** @var HttpXmlBody */
    private $obj;

    protected function setUp()
    {
        $this->obj = new HttpXmlBody();
    }

    public function testValidXmlHttpBodyFromClient(): void
    {
        $this->assertSame('z', (string) $this->obj->decode('<x><y>z</y></x>')->y);
        $this->assertNull($this->obj->errText());
        $this->assertNull($this->obj->errCode());
    }

    public function testInvalidXmlHttpBodyFromClient(): void
    {
        $this->assertNull($this->obj->decode('<x<y>z</y></x>'));
        $this->assertSame("error parsing attribute name\nattributes construct error\nCouldn't find end of Start Tag x line 1\nExtra content at the end of the document", $this->obj->errText());
        $this->assertSame(self::XML_ERROR_NAME_REQUIRED, $this->obj->errCode());
    }

    public function testValidXmlHttpBodyToClient(): void
    {
        $this->assertSame("<?xml version=\"1.0\"?>\n<a>b</a>", $this->obj->encode(new \SimpleXMLElement('<a>b</a>')));
        $this->assertNull($this->obj->errCode());
        $this->assertNull($this->obj->errText());
    }
}