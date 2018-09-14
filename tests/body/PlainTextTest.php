<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

use PHPUnit\Framework\TestCase;
use RHo\Http\Body\Text as HttpTextBody;

final class PlainTextTest extends TestCase
{

    public function testValidPlainTextHttpBodyFromClient(): void
    {
        $body = HttpTextBody::decode('abcd');
        $this->assertSame('abcd', $body->value());
        $this->assertNull($body->errCode());
        $this->assertNull($body->errText());
    }

    public function testValidPlainTextHttpBodyToClient(): void
    {
        $body = HttpTextBody::encode(1000);
        $this->assertSame('1000', $body->value());
        $this->assertNull($body->errCode());
        $this->assertNull($body->errText());
    }
}