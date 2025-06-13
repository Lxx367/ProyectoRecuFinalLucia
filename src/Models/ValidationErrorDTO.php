<?php

namespace App\Models;

class ValidationErrorDTO
{
    public int $code;
    public string $description;

    public function __construct(int $code, string $description)
    {
        $this->code = $code;
        $this->description = $description;
    }
}
