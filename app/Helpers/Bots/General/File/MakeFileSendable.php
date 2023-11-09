<?php

namespace App\Helpers\Bots\General\File;

class MakeFileSendable
{
    public function __construct(protected string $file) { }

    public function makeWithUrl(): string
    {
        return $this->getAppUrl() . '/storage/' . $this->file;
    }

    public function makeWithCurl(): \CURLFile
    {
        return curl_file_create($this->getAppUrl() . '/storage/' . $this->file);
    }

    public function makeWithPublicUrl(): string
    {
        return $this->file;
    }

    private function getAppUrl()
    {
        return config('app.url');
    }
}
