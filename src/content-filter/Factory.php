<?php
declare(strict_types = 1);
namespace RHo\Http\Content;

use RHo\Http\ {
    MediaTypeInterface as HttpMediaTypeIface,
    ContentFilterInterface as HttpContentFilterIface
};

class Factory
{

    public static function build(HttpMediaTypeIface $mediaType): HttpContentFilterIface
    {
        switch ($mediaType->structuredSyntaxSuffix()) {
            case 'xml':
                return new Xml();
            case 'json':
                return new Json();
            case 'text':
            default:
                return new PlainText();
        }
    }
}