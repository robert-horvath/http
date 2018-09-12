<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

use PHPUnit\Framework\TestCase;
use RHo\Http\Content\PlainText as PlainTextHttpBody;

final class PlainTextTest extends TestCase
{

    public function testValidPlainTextHttpBodyFromClient(): void
    {
        $obj = new PlainTextHttpBody('abcd');
        $this->assertSame('abcd', $obj->decode());
        $this->assertNull($obj->errCode());
        $this->assertNull($obj->errText());
    }

    public function testValidPlainTextHttpBodyToClient(): void
    {
        $obj = new PlainTextHttpBody('Róbert');
        $this->assertSame('Róbert', $obj->encode());
        $this->assertNull($obj->errCode());
        $this->assertNull($obj->errText());
    }
}