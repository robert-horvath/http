<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

use PHPUnit\Framework\TestCase;
use RHo\Http\Body\PlainText as PlainTextHttpBody;

final class PlainTextTest extends TestCase
{

    /** @var PlainTextHttpBody */
    private $obj;

    protected function setUp()
    {
        $this->obj = new PlainTextHttpBody();
    }

    public function testValidPlainTextHttpBodyFromClient(): void
    {
        $this->assertNull($this->obj->decode('abcd'));
        $this->assertSame('', $this->obj->errStr());
        $this->assertSame('abcd', $this->obj->str());
        $this->assertSame('abcd', $this->obj->value());
    }

    public function testValidPlainTextHttpBodyToClient(): void
    {
        $this->assertNull($this->obj->encode('Róbert'));
        $this->assertSame('', $this->obj->errStr());
        $this->assertSame('Róbert', $this->obj->str());
        $this->assertSame('Róbert', $this->obj->value());
    }
}