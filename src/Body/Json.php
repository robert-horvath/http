<?php
declare(strict_types = 1);
namespace RHo\Http\Body;

class Json extends PlainText
{

    public function decode(string $str): ?int
    {
        $this->str = $str;
        $this->val = json_decode($str);
        $err = json_last_error();
        $this->errStr = json_last_error_msg();
        return $err === JSON_ERROR_NONE ? NULL : $err;
    }

    public function encode($value): ?int
    {
        $this->val = $value;
        $this->str = json_encode($value);
        $err = json_last_error();
        $this->errStr = json_last_error_msg();
        return $err === JSON_ERROR_NONE ? NULL : $err;
    }
}