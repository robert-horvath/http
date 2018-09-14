<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

use PHPUnit\Framework\TestCase;
use RHo\Http\Body\Json as HttpJsonBody;

final class JsonTest extends TestCase
{

    public function testValidJsonHttpBodyFromClient(): void
    {
        $body = HttpJsonBody::decode('false');
        $this->assertSame(FALSE, $body->value());
        $this->assertNull($body->errText());
        $this->assertNull($body->errCode());
    }

    public function testInvalidJsonHttpBodyFromClient(): void
    {
        $body = HttpJsonBody::decode('');
        $this->assertNull($body->value());
        $this->assertSame('Syntax error', $body->errText());
        $this->assertSame(JSON_ERROR_SYNTAX, $body->errCode());
    }

    public function testValidJsonHttpBodyToClient(): void
    {
        $body = HttpJsonBody::encode(100);
        $this->assertSame('100', $body->value());
        $this->assertNull($body->errText());
        $this->assertNull($body->errCode());
    }

    public function testInvalidJsonHttpBodyToClient(): void
    {
        $body = HttpJsonBody::encode("\xB1\x31");
        $this->assertNull($body->value());
        $this->assertSame('Malformed UTF-8 characters, possibly incorrectly encoded', $body->errText());
        $this->assertSame(JSON_ERROR_UTF8, $body->errCode());
    }
}