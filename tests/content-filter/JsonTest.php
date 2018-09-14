<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

use PHPUnit\Framework\TestCase;
use RHo\Http\Content\Json as HttpJsonBody;

final class JsonTest extends TestCase
{

    /** @var HttpJsonBody */
    private $obj;

    protected function setUp()
    {
        $this->obj = new HttpJsonBody();
    }

    public function testValidJsonHttpBodyFromClient(): void
    {
        $this->assertSame(FALSE, $this->obj->decode('false'));
        $this->assertNull($this->obj->errText());
        $this->assertNull($this->obj->errCode());
    }

    public function testInvalidJsonHttpBodyFromClient(): void
    {
        $this->assertNull($this->obj->decode(''));
        $this->assertSame('Syntax error', $this->obj->errText());
        $this->assertSame(JSON_ERROR_SYNTAX, $this->obj->errCode());
    }

    public function testValidJsonHttpBodyToClient(): void
    {
        $this->assertSame('100', $this->obj->encode(100));
        $this->assertNull($this->obj->errText());
        $this->assertNull($this->obj->errCode());
    }

    public function testInvalidJsonHttpBodyToClient(): void
    {
        $this->assertNull($this->obj->encode("\xB1\x31"));
        $this->assertSame('Malformed UTF-8 characters, possibly incorrectly encoded', $this->obj->errText());
        $this->assertSame(JSON_ERROR_UTF8, $this->obj->errCode());
    }
}