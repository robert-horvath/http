<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

use PHPUnit\Framework\TestCase;
use RHo\Http\Body\Json as JsonHttpBody;

final class JsonTest extends TestCase
{

    /** @var JsonHttpBody */
    private $obj;

    protected function setUp()
    {
        $this->obj = new JsonHttpBody();
    }

    public function testValidJsonHttpBodyFromClient(): void
    {
        $this->assertNull($this->obj->decode('false'));
        $this->assertSame('No error', $this->obj->errStr());
        $this->assertSame('false', $this->obj->str());
        $this->assertSame(FALSE, $this->obj->value());
    }

    public function testInvalidJsonHttpBodyFromClient(): void
    {
        $this->assertSame(JSON_ERROR_SYNTAX, $this->obj->decode(''));
        $this->assertSame('Syntax error', $this->obj->errStr());
        $this->assertSame('', $this->obj->str());
    }

    public function testValidJsonHttpBodyToClient(): void
    {
        $this->assertNull($this->obj->encode(100));
        $this->assertSame('No error', $this->obj->errStr());
        $this->assertSame('100', $this->obj->str());
        $this->assertSame(100, $this->obj->value());
    }

    public function testInvalidJsonHttpBodyToClient(): void
    {
        $this->assertSame(JSON_ERROR_UTF8, $this->obj->encode("\xB1\x31"));
        $this->assertSame('Malformed UTF-8 characters, possibly incorrectly encoded', $this->obj->errStr());
        $this->assertSame("\xB1\x31", $this->obj->value());
    }
}