<?php

namespace Database\Factories\Bots\BotUserTasks;

use App\Models\Bots\Tasks\BotUserTask;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BotUserTaskFactory extends Factory
{
    protected $model = BotUserTask::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bot_user_id' => $this->faker->numberBetween(1, 2),
            'bot_category_id' => $this->faker->numberBetween(1, 4),
            'description' => base64_encode($this->faker->sentence(10)),
            'amount' => $this->faker->numberBetween(1, 50),
            'schedule_time' => date("H:i", strtotime("+2 minutes")),
            'active' => true,
        ];
    }
}
