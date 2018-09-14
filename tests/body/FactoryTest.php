<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

require_once __DIR__ . '/../mock_functions.php';

use RHo\Http\ {
    Body\Factory as HttpBodyFactory,
    MediaType as HttpMediaType,
    Body\Text as HttpTextBody,
    Body\Json as HttpJsonBody,
    Body\Xml as HttpXmlBody
};
use PHPUnit\Framework\TestCase;

final class FactoryTest extends TestCase
{

    public function testPlainTextContentType()
    {
        $c = HttpBodyFactory::decode(new HttpMediaType('text', 'plain+text'), 'Róbert');
        $this->assertInstanceOf(HttpTextBody::class, $c);
    }

    public function testJsonContentType()
    {
        $c = HttpBodyFactory::decode(new HttpMediaType('application', 'vnd.my.example+json'), '{}');
        $this->assertInstanceOf(HttpJsonBody::class, $c);
    }

    public function testXmlContentType()
    {
        $c = HttpBodyFactory::decode(new HttpMediaType('application', 'vnd.my.example+xml'), '');
        $this->assertInstanceOf(HttpXmlBody::class, $c);
    }

    public function testUnknownContentType()
    {
        $c = HttpBodyFactory::decode(new HttpMediaType('image', 'jpg'), 'true');
        $this->assertInstanceOf(HttpTextBody::class, $c);
    }
}