<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

use PHPUnit\Framework\TestCase;
use RHo\Http\Body\PlainText as HttpPlainTextBody;

final class PlainTextTest extends TestCase
{

    /** @var HttpPlainTextBody */
    private $obj;

    protected function setUp()
    {
        $this->obj = new HttpPlainTextBody();
    }

    public function testValidPlainTextHttpBodyFromClient(): void
    {
        $this->assertSame('abcd', $this->obj->decode('abcd'));
        $this->assertNull($this->obj->errCode());
        $this->assertNull($this->obj->errText());
    }

    public function testValidPlainTextHttpBodyToClient(): void
    {
        $this->assertSame('Róbert', $this->obj->encode('Róbert'));
        $this->assertNull($this->obj->errCode());
        $this->assertNull($this->obj->errText());
    }
}