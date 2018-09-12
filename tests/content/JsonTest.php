<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

use PHPUnit\Framework\TestCase;
use RHo\Http\Content\Json as JsonHttpBody;

final class JsonTest extends TestCase
{

    public function testValidJsonHttpBodyFromClient(): void
    {
        $obj = new JsonHttpBody('false');
        $this->assertSame(FALSE, $obj->decode());
        $this->assertNull($obj->errText());
        $this->assertNull($obj->errCode());
    }

    public function testInvalidJsonHttpBodyFromClient(): void
    {
        $obj = new JsonHttpBody('');
        $this->assertNull($obj->decode());
        $this->assertSame('Syntax error', $obj->errText());
        $this->assertSame(JSON_ERROR_SYNTAX, $obj->errCode());
    }

    public function testValidJsonHttpBodyToClient(): void
    {
        $obj = new JsonHttpBody(100);
        $this->assertSame('100', $obj->encode());
        $this->assertNull($obj->errText());
        $this->assertNull($obj->errCode());
    }

    public function testInvalidJsonHttpBodyToClient(): void
    {
        $obj = new JsonHttpBody("\xB1\x31");
        $this->assertNull($obj->encode());
        $this->assertSame('Malformed UTF-8 characters, possibly incorrectly encoded', $obj->errText());
        $this->assertSame(JSON_ERROR_UTF8, $obj->errCode());
    }
}