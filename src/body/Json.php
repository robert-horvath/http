<?php
declare(strict_types = 1);
namespace RHo\Http\Body;

use RHo\Http\BodyInterface;

class Json extends Text
{

    public static function decode(string $value): BodyInterface
    {
        return new static(json_decode($value));
    }

    public static function encode($value): BodyInterface
    {
        return new static(json_encode($value));
    }

    protected function initErrorFields(): void
    {
        $this->errCode = $this->jsonLastError();
        $this->errText = $this->errCode === NULL ? NULL : $this->jsonLastErrorMsg();
    }

    private function jsonLastError(): ?int
    {
        $err = json_last_error();
        if ($err === JSON_ERROR_NONE)
            return NULL;
        return $err;
    }

    private function jsonLastErrorMsg(): string
    {
        return json_last_error_msg();
    }
}