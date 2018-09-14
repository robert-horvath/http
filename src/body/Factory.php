<?php
declare(strict_types = 1);
namespace RHo\Http\Body;

use RHo\Http\ {
    MediaTypeInterface,
    BodyInterface
};

class Factory
{

    public static function decode(MediaTypeInterface $mediaType, string $value): BodyInterface
    {
        $class = __NAMESPACE__ . '\\' . $mediaType->structuredSyntaxSuffix();
        if (class_exists($class))
            return $class::decode($value);
        return Text::decode($value);
    }
}