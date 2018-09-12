<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

require_once __DIR__ . '/../mock_functions.php'; // mock function

use RHo\Http\MediaType;
use PHPUnit\Framework\TestCase;

final class MediaTypeTest extends TestCase
{

    public function testIsLinearWhiteSpace()
    {
        $this->assertSame(1, preg_match('/^' . MediaType::linear_white_space . '$/', "\r\n "));
        $this->assertSame(1, preg_match('/^' . MediaType::linear_white_space . '$/', "\r\n "));
        $this->assertSame(1, preg_match('/^' . MediaType::linear_white_space . '$/', " \t"));
        $this->assertSame(1, preg_match('/^' . MediaType::linear_white_space . '$/', "\t\t"));
        $this->assertSame(1, preg_match('/^' . MediaType::linear_white_space . '$/', "\t \t "));
        $this->assertSame(0, preg_match('/^' . MediaType::linear_white_space . '$/', ""));
    }

    public function testIsSpecials()
    {
        $this->assertSame(1, preg_match('/^[' . MediaType::specials . ']+$/', '(]<>@,;:\\.[)"'));
        $this->assertSame(0, preg_match('/^[' . MediaType::specials . ']+$/', '(?]<=>@,/;:\\[)"'));
        $this->assertSame(1, preg_match('/^[' . MediaType::tspecials . ']+$/', '(?]<=>@,/;:\\[)"'));
        $this->assertSame(0, preg_match('/^[' . MediaType::tspecials . ']+$/', '(]<>@,;:\\.[)"'));
    }

    public function testIsToken()
    {
        $this->assertSame(1, preg_match('/^' . MediaType::token . '$/', '!#$%&\'*+-.0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ^_`abcdefghijklmnopqrstuvwxyz{|}~'));
    }

    public function testIsQuotedString()
    {
        $this->assertSame(0, preg_match('/^' . MediaType::quoted_string . '$/', 'apple'));
        $this->assertSame(1, preg_match('/^' . MediaType::quoted_string . '$/', '"apple"'));
        $this->assertSame(1, preg_match('/^' . MediaType::quoted_string . '$/', '"\a\p\p\l\e"'));
        $this->assertSame(1, preg_match('/^' . MediaType::quoted_string . '$/', '""'));
        $this->assertSame(1, preg_match('/^' . MediaType::quoted_string . '$/', "\"ap\r\n p\tle\""));
        $this->assertSame(1, preg_match('/^' . MediaType::quoted_string . '$/', "\"\ap\r\n p\tle" . '\c"'));
    }

    public function testIsContentType()
    {
        $matches = NULL;
        $this->assertSame(1, preg_match('/^' . MediaType::content . '$/', 'plain/text'));
        $this->assertSame(1, preg_match('/^' . MediaType::content . '$/', 'application/prs.api.ela.do+xml+json', $matches));
        $this->assertSame('application', $matches[1]);
        $this->assertSame('prs.api.ela.do+xml+json', $matches[2]);
        $this->assertSame(1, preg_match('/^' . MediaType::content . '$/', 'application/prs.api.ela.do+json;version=1;q=2', $matches));
        $this->assertSame('application', $matches[1]);
        $this->assertSame('prs.api.ela.do+json', $matches[2]);
        $this->assertSame(';version=1;q=2', $matches[3]);
    }

    public function testMediaType(): void
    {
        $mt = new MediaType('application', 'prs.api.ela.do+txt+json');
        $mt->setParameter('version', '1');
        $mt->setParameter('q', '2');

        $this->assertSame('application/prs.api.ela.do+txt+json;version=1;q=2', (string) $mt);
        $this->assertSame('application', $mt->type());
        $this->assertSame('prs.api.ela.do+txt+json', $mt->subType());
        $this->assertSame('json', $mt->structuredSyntaxSuffix());
        $this->assertSame('1', $mt->parameter('version'));
        $this->assertSame('2', $mt->parameter('q'));
        $this->assertNull($mt->parameter('x'));
    }

    public function validMediaTypeStrProvider()
    {
        return [
            [
                'application/prs.api.ela.do+json;version=1;q=2',
                'application',
                'prs.api.ela.do+json',
                'json',
                '1',
                '2'
            ],
            [
                'plain/text;version=2',
                'plain',
                'text',
                NULL,
                '2',
                NULL
            ],
            [
                'image/jpeg',
                'image',
                'jpeg',
                NULL,
                NULL,
                NULL
            ]
        ];
    }

    /**
     *
     * @dataProvider validMediaTypeStrProvider
     */
    public function testValidMediaTypeWithInitStr($str, $type, $subType, $suffix, $p1, $p2): void
    {
        $mt = MediaType::initWithStr($str);
        $this->assertInstanceOf(MediaType::class, $mt);

        $this->assertSame($str, (string) $mt);
        $this->assertSame($type, $mt->type());
        $this->assertSame($subType, $mt->subType());
        $this->assertSame($suffix, $mt->structuredSyntaxSuffix());
        $this->assertSame($p1, $mt->parameter('version'));
        $this->assertSame($p2, $mt->parameter('q'));
        $this->assertNull($mt->parameter('x'));
    }

    public function testValidMediaTypeWithInitStrWithoutParameters(): void
    {
        $mt = MediaType::initWithStr('application/prs.api.ela.do+json');

        $this->assertSame('application/prs.api.ela.do+json', (string) $mt);
        $this->assertSame('application', $mt->type());
        $this->assertSame('prs.api.ela.do+json', $mt->subType());
        $this->assertSame('json', $mt->structuredSyntaxSuffix());
        $this->assertNull($mt->parameter('version'));
        $this->assertNull($mt->parameter('q'));
    }

    public function testInvalidMediaTypeWithInitStr(): void
    {
        $mt = MediaType::initWithStr('applicationjson');
        $this->assertNull($mt);
    }

    /**
     *
     * @expectedException RuntimeException
     * @expectedExceptionMessage preg_match: regular expression failed
     * @expectedExceptionCode PREG_BACKTRACK_LIMIT_ERROR
     */
    public function testRegexpError(): void
    {
        $GLOBALS['mock_preg_match'] = TRUE;
        $GLOBALS['preg_last_error'] = PREG_BACKTRACK_LIMIT_ERROR;
        MediaType::initWithStr('xyz');
    }

    public function testValidMediaTypeWithCollection(): void
    {
        $mtc = MediaType::initWithCSV('application/prs.api.ela.do+json;version=1,plain/text');
        $this->assertSame(2, count($mtc));

        $this->assertSame('application/prs.api.ela.do+json;version=1', (string) $mtc[0]);
        $this->assertSame('application', $mtc[0]->type());
        $this->assertSame('prs.api.ela.do+json', $mtc[0]->subType());
        $this->assertSame('json', $mtc[0]->structuredSyntaxSuffix());
        $this->assertSame('1', $mtc[0]->parameter('version'));

        $this->assertSame('plain/text', (string) $mtc[1]);
        $this->assertSame('plain', $mtc[1]->type());
        $this->assertSame('text', $mtc[1]->subType());
        $this->assertNull($mtc[1]->structuredSyntaxSuffix());
        $this->assertNull($mtc[1]->parameter('version'));
    }
}