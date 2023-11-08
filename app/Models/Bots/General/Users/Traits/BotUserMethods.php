<?php

namespace App\Models\Bots\General\Users\Traits;

trait BotUserMethods
{
    /**
     * Bot user's first name attribute getter.
     *
     * @return string
     */
    public function getFirstName(): string
    {
        return base64_decode($this->first_name);
    }

    /**
     * Bot user's username attribute getter.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return base64_decode($this->username);
    }

    /**
     * Bot user's username attribute getter.
     */
    public function updateSteps(int $step_one, int $step_two): void
    {
        $this->steps->update([
            'step_one' => $step_one,
            'step_two' => $step_two,
        ]);
    }
}
