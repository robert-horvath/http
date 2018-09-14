<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

require_once __DIR__ . '/../mock_functions.php';

use RHo\Http\ {
    Body\Factory as HttpBodyFactory,
    MediaType as HttpMediaType,
    Body\PlainText as HttpPlainTextBody,
    Body\Json as HttpJsonBody,
    Body\Xml as HttpXmlBody
};
use PHPUnit\Framework\TestCase;

final class FactoryTest extends TestCase
{

    public function testPlainTextContentType()
    {
        $c = HttpBodyFactory::build(new HttpMediaType('text', 'plain+text'));
        $this->assertInstanceOf(HttpPlainTextBody::class, $c);
    }

    public function testJsonContentType()
    {
        $c = HttpBodyFactory::build(new HttpMediaType('application', 'vnd.my.example+json'));
        $this->assertInstanceOf(HttpJsonBody::class, $c);
    }

    public function testXmlContentType()
    {
        $c = HttpBodyFactory::build(new HttpMediaType('application', 'vnd.my.example+xml'));
        $this->assertInstanceOf(HttpXmlBody::class, $c);
    }

    public function testUnknownContentType()
    {
        $c = HttpBodyFactory::build(new HttpMediaType('image', 'jpg'));
        $this->assertInstanceOf(HttpPlainTextBody::class, $c);
    }
}