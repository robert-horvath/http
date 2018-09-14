<?php
declare(strict_types = 1);
namespace RHo\Http\Body;

use RHo\Http\ {
    MediaTypeInterface as HttpMediaTypeIface,
    BodyInterface as HttpBodyIface
};

class Factory
{

    public static function build(HttpMediaTypeIface $mediaType): HttpBodyIface
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