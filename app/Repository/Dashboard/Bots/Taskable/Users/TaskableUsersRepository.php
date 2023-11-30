<?php

namespace App\Repository\Dashboard\Bots\Taskable\Users;

use App\Models\Bots\General\Bots\Bot;
use App\Models\Bots\General\Users\BotUser;

class TaskableUsersRepository
{
    protected int $bot_id;

    public function __construct()
    {
        $bot = Bot::where('token', config('telegram.bots.taskable.token'))->first();
        $this->bot_id = $bot->id;
    }

    public function getFiltered(
        string $search,
        int $perPage,
        int $user_status,
        string $orderBy,
        string $orderDirection,
    )
    {
        $query = BotUser::select(['id', 'chat_id', 'first_name', 'username', 'phone_number', 'active', 'created_at', 'deleted_at'])
            ->where('bot_id', $this->bot_id)
            ->where('active', $user_status)
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $search = base64_encode($search);
                    $query->where('first_name', 'like', "%$search%");
                });
            })
            ->when($orderBy, function ($query, $orderBy) use ($orderDirection) {
                return $query->orderBy($orderBy, $orderDirection);
            });

        return $perPage === 0 ? $query->get() : $query->paginate($perPage);
    }
}
