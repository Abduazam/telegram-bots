<?php

namespace App\Helpers\Classes\Uploads;

use Illuminate\Support\Facades\File;

class Upload
{
    public function __construct(
        protected mixed $media,
        protected string $folder,
        protected $model = null,
        protected $modelColumn = null,
    ) { }

    public function uploadMedia()
    {
        if (isset($this->media)) {
            if ($this->model !== null && $this->model->{$this->modelColumn} !== null && File::exists(public_path('storage/' . $this->model->{$this->modelColumn}))) {
                unlink(storage_path('app/public/' . $this->model->{$this->modelColumn}));
            }

            return $this->media->store($this->folder, 'public');
        }

        return null;
    }
}
