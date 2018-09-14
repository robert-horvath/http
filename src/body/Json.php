<?php
declare(strict_types = 1);
namespace RHo\Http\Body;

class Json extends PlainText
{

    public function decode(string $value)
    {
        $json = json_decode($value);
        $this->updateErrorFields();
        return $this->value($json);
    }

    public function encode($value): ?string
    {
        $str = json_encode($value);
        $this->updateErrorFields();
        return $this->value($str);
    }

    private function updateErrorFields(): void
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