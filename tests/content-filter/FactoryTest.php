<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

require_once __DIR__ . '/../mock_functions.php';

use RHo\Http\ {
    Content\Factory as HttpContentFactory,
    MediaType as HttpMediaType,
    Content\PlainText as HttpPlainTextBody,
    Content\Json as HttpJsonBody,
    Content\Xml as HttpXmlBody
};
use PHPUnit\Framework\TestCase;

final class FactoryTest extends TestCase
{

    public function testPlainTextContentType()
    {
        $c = HttpContentFactory::build(new HttpMediaType('text', 'plain+text'));
        $this->assertInstanceOf(HttpPlainTextBody::class, $c);
    }

    public function testJsonContentType()
    {
        $c = HttpContentFactory::build(new HttpMediaType('application', 'vnd.my.example+json'));
        $this->assertInstanceOf(HttpJsonBody::class, $c);
    }

    public function testXmlContentType()
    {
        $c = HttpContentFactory::build(new HttpMediaType('application', 'vnd.my.example+xml'));
        $this->assertInstanceOf(HttpXmlBody::class, $c);
    }

    public function testUnknownContentType()
    {
        $c = HttpContentFactory::build(new HttpMediaType('image', 'jpg'));
        $this->assertInstanceOf(HttpPlainTextBody::class, $c);
    }
}