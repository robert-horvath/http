<?php
declare(strict_types = 1);
namespace RHo\Http\Body;

use SimpleXMLElement;

class Xml extends PlainText
{

    public function decode(string $value): ?SimpleXMLElement
    {
        $this->clearErrorFields();
        $xml = simplexml_load_string($value, 'SimpleXMLElement', LIBXML_NOCDATA);
        $this->updateErrorFields();
        return $this->value($xml);
    }

    public function encode($value): ?string
    {
        $this->clearErrorFields();
        $str = trim($value->asXml());
        $this->updateErrorFields();
        return $this->value($str);
    }

    private function clearErrorFields(): void
    {
        libxml_use_internal_errors(TRUE);
        libxml_clear_errors();
        $this->errCode = NULL;
        $this->errText = NULL;
    }

    private function updateErrorFields(): void
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