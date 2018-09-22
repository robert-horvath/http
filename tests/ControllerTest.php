<?php
declare(strict_types = 1);
namespace RHo\HttpTest;

use RHo\ {
    Http\Controller as HttpController,
    MediaType\MediaType
};
use PHPUnit\Framework\TestCase;

/**
 *
 * @runTestsInSeparateProcesses
 */
final class ControllerTest extends TestCase
{

    public function testMe(): void
    {
        $GLOBALS['file_get_contents'] = __DIR__ . '/body.json';

        $_SERVER['HTTP_ACCEPT'] = 'plain/text;q=0.7,application/prs.api.ela.do+json;version=1;q=0.7,image/png,application/prs.api.ela.do+xml;q=0.8;version=2';
        $_SERVER['CONTENT_TYPE'] = 'plain/text';
        /* ----- */
        $supportedMediaTypes = [
            new MediaType('application', 'prs.api.ela.do+json', [
                'version' => '1'
            ]),
            new MediaType('plain', 'text'),
            new MediaType('application', 'prs.api.ela.do+xml', [
                'version' => '2'
            ])
        ];
        $receiveContent = TRUE;
        $sendContent = TRUE;
        $ctrl = new HttpController($supportedMediaTypes, $receiveContent, $sendContent);

        // $this->assertTrue($ctrl->isRequestValid());
        $ctrl->isRequestValid();

        var_dump($ctrl->message());
    }
}