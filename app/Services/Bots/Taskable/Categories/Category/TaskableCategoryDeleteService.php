<?php

namespace App\Services\Bots\Taskable\Categories\Category;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Bots\Taskable\Categories\TaskableCategory;

class TaskableCategoryDeleteService
{
    public function __construct(protected TaskableCategory $category) { }

    public function delete(): bool
    {
        try {
            DB::beginTransaction();

            $this->category->delete();

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            info($exception);
            return false;
        }
    }

    public function forceDelete(): bool
    {
        try {
            DB::beginTransaction();

            $this->category->forceDelete();

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            info($exception);
            return false;
        }
    }
}
