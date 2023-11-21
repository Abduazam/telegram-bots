<?php

namespace App\Helpers\Bots\Anonimyoz\Rules;

class StartCommandCheckRule
{
    public function __construct(protected ?string $text) { }

    public function __invoke(): ?string
    {
        if (!is_null($this->text) && str_starts_with($this->text, '/start') && strlen($this->text) > 6) {
            $data = explode(' ', $this->text);
            return $data[1];
        }

        return null;
    }
}
