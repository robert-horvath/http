<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

use PHPUnit\Framework\TestCase;
use RHo\Http\Body\Xml as XmlHttpBody;

final class XmlTest extends TestCase
{

    /** @var XmlHttpBody */
    private $obj;

    protected function setUp()
    {
        $this->obj = new XmlHttpBody();
    }

    public function testValidXmlHttpBodyFromClient(): void
    {
        $this->assertNull($this->obj->decode('<x><y>z</y></x>'));
        $this->assertSame('', $this->obj->errStr());
        $this->assertSame('<x><y>z</y></x>', $this->obj->str());
        $this->assertEquals('z', $this->obj->value()->y);
    }

    public function testInvalidXmlHttpBodyFromClient(): void
    {
        $this->assertSame(XML_ERROR_UNCLOSED_TOKEN, $this->obj->decode('<x<y>z</y></x>'));
        $this->assertSame("Extra content at the end of the document\nCouldn't find end of Start Tag x line 1\nattributes construct error\nerror parsing attribute name", $this->obj->errStr());
        $this->assertSame('<x<y>z</y></x>', $this->obj->str());
    }

    public function testValidXmlHttpBodyToClient(): void
    {
        $xml = new \SimpleXMLElement('<a>b</a>');
        $this->assertNull($this->obj->encode($xml));
        $this->assertSame('', $this->obj->errStr());
        $this->assertSame("<?xml version=\"1.0\"?>\n<a>b</a>", $this->obj->str());
        $this->assertSame($xml, $this->obj->value());
    }
}