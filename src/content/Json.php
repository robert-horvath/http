<?php
declare(strict_types = 1);
namespace RHo\Http\Content;

class Json extends PlainText
{

    public function decode()
    {
        $value = json_decode($this->value);
        $this->updateErrorFields();
        return $this->value($value);
    }

    public function encode(): ?string
    {
        $value = json_encode($this->value);
        $this->updateErrorFields();
        return $this->value($value);
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