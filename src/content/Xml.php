<?php
declare(strict_types = 1);
namespace RHo\Http\Content;

use SimpleXMLElement;

class Xml extends PlainText
{

    public function decode(): ?SimpleXMLElement
    {
        $this->clearErrorFields();
        $value = simplexml_load_string($this->value, 'SimpleXMLElement', LIBXML_NOCDATA);
        $this->updateErrorFields();
        return $this->value($value);
    }

    public function encode(): ?string
    {
        $this->clearErrorFields();
        $value = trim($this->value->asXml());
        $this->updateErrorFields();
        return $this->value($value);
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