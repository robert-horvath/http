<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

require_once __DIR__ . '/preg_last_error.php'; // mock function

use RHo\Http\MediaType;
use PHPUnit\Framework\TestCase;

final class MediaTypeTest extends TestCase
{

    public function testValidMediaTypeString(): void
    {
        $GLOBALS['mock_preg_last_error'] = FALSE;

        $error = NULL;
        $mt = MediaType::init('application/prs.api.ela.do+json;version=1;q=2', $error);
        $this->assertInstanceOf(MediaType::class, $mt);
        $this->assertSame('application', $mt->type());
        $this->assertSame('prs.api.ela.do', $mt->subType());
        $this->assertSame('json', $mt->suffix());
        $this->assertSame('1', $mt->parameter('version'));
        $this->assertSame('2', $mt->parameter('q'));
        $this->assertNull($mt->parameter('x'));
        $this->assertNull($error);
    }

    public function testInvalidMediaType(): void
    {
        $GLOBALS['mock_preg_last_error'] = FALSE;

        $error = NULL;
        $mt = MediaType::init('*/*,application/json', $error);
        $this->assertNull($mt);
        $this->assertNull($error);
    }

    public function testRegexpErrorMediaType(): void
    {
        $GLOBALS['mock_preg_last_error'] = TRUE;

        $error = NULL;
        $mt = MediaType::init('xyz', $error);
        $this->assertNull($mt);
        $this->assertSame(PREG_BACKTRACK_LIMIT_ERROR, $error);
    }

    public function testValidMediaType(): void
    {
        $mt = new MediaType('application', 'prs.api.ela.do', 'xml', [
            'a' => '1',
            'b' => '2'
        ]);
        $this->assertSame('application', $mt->type());
        $this->assertSame('prs.api.ela.do', $mt->subType());
        $this->assertSame('xml', $mt->suffix());
        $this->assertSame('1', $mt->parameter('a'));
        $this->assertSame('2', $mt->parameter('b'));
        $this->assertNull($mt->parameter('c'));
    }
}