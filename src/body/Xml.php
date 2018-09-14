<?php
declare(strict_types = 1);
namespace RHo\Http\Body;

use RHo\Http\BodyInterface;

class Xml extends Text
{

    public static function decode(string $value): BodyInterface
    {
        self::clearErrorFields();
        return new static(simplexml_load_string($value, 'SimpleXMLElement', LIBXML_NOCDATA));
    }

    public static function encode($value): BodyInterface
    {
        self::clearErrorFields();
        return new static(trim($value->asXml()));
    }

    private static function clearErrorFields(): void
    {
        libxml_use_internal_errors(TRUE);
        libxml_clear_errors();
    }

    protected function initErrorFields(): void
    {
        $errCode = XML_ERROR_NONE;
        $errText = [];
        foreach (libxml_get_errors() as $err) {
            if ($errCode === XML_ERROR_NONE)
                $errCode = $err->code; // Save only the last one
            $errText[] = trim($err->message);
        }
        $this->errCode = $errCode === XML_ERROR_NONE ? NULL : $errCode;
        $this->errText = $this->errCode === NULL ? NULL : implode("\n", $errText);
    }
}