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
        return $this->username ? '<a href="https://t.me/' . base64_decode($this->username) . '" target="_blank">' . base64_decode($this->username) . '</a>' : '';
    }

    /**
     * Bot user's status attribute getter.
     *
     * @return string
     */
    public function getStatus(): string
    {
        if ($this->isBlocked()) {
            $message = '<span class="btn btn-sm btn-alt-danger"><small>Blocked</small></span>';
        } else if ($this->isInactive()) {
            $message = '<span class="btn btn-sm btn-alt-warning"><small>Inactive</small></span>';
        } else {
            $message = '<span class="btn btn-sm btn-alt-success"><small>Active</small></span>';
        }

        return $message;
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
