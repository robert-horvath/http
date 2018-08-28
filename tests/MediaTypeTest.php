<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

use RHo\Http\MediaType;
use PHPUnit\Framework\TestCase;

final class MediaTypeTest extends TestCase
{

    public function testValidMediaType(): void
    {
        $mt = MediaType::init('application/prs.api.ela.do+json;version=1;q=2');
        $this->assertInstanceOf(MediaType::class, $mt);
        $this->assertSame('application', $mt->type());
        $this->assertSame('prs.api.ela.do', $mt->subType());
        $this->assertSame('json', $mt->suffix());
        $this->assertSame('1', $mt->parameter('version'));
        $this->assertSame('2', $mt->parameter('q'));
        $this->assertNull($mt->parameter('x'));
    }

    public function testInvalidMediaType(): void
    {
        $mt = MediaType::init('*/*,application/json');
        $this->assertNull($mt);
    }
}