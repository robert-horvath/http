<?php
declare(strict_types = 1);
namespace RHo\Http\Body;

class Xml extends PlainText
{

    public function decode(string $str): ?int
    {
        $this->str = $str;
        libxml_use_internal_errors(TRUE);
        libxml_clear_errors();
        $this->val = simplexml_load_string($str, "SimpleXMLElement", LIBXML_NOCDATA);
        if ($this->val === FALSE)
            return $this->error();
        return NULL;
    }

    public function encode($value): ?int
    {
        $this->val = $value;
        libxml_clear_errors();
        $this->str = trim($value->asXml());
        $this->errStr = '';
        return NULL;
    }

    private function error(): ?int
    {
        $errCode = XML_ERROR_NONE;
        $errStr = '';
        foreach (libxml_get_errors() as $err) {
            $errCode = $err->code; // Save only the last one
            $errStr = $err->message . $errStr;
        }
        $this->errStr = trim($errStr);
        return $errCode;
    }
}