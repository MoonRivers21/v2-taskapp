<?php

namespace App\Rules;

use App\Models\Task;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CheckUniqueTaskTitle implements Rule
{
    protected int|string|null $taskId;
    protected string|null $currentTitle;

    public function __construct(int|string|null $taskId, string|null $currentTitle)
    {
        $this->taskId = $taskId;
        $this->currentTitle = $currentTitle;
    }

    public function passes($attribute, $value)
    {
        // If editing and title is not changed, skip validation
        if ($this->taskId && $value === $this->currentTitle) {
            return true;
        }

        $userId = Auth::id();

        $exists = Task::where('user_id', $userId)
            ->where('title', $value)
            ->exists();

        return !$exists;
    }

    public function message(): string
    {
        return 'The title must be unique.';
    }
}
