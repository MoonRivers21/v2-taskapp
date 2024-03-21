<?php

namespace App\Models;

use App\Enums\PublishStatus;
use App\Enums\TaskStatus;
use App\Policies\TaskPolicy;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Task extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'title',
        'content',
        'image',
        'user_id',
        'status',
        'published_at',
        'published',
        'subtask'
    ];

    /**
     * Filter tasks based on user ID, status, and search query.
     *
     * @param  int  $user
     * @param  Request  $request
     * @return Builder
     */
    public static function filterTasks(int $user, Request $request): Builder
    {

        $query = self::query()->where('user_id', $user);

        // Apply status filter if provided
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Apply search query filter if provided
        $searchQuery = $request->query('search');
        if (is_string($searchQuery)) {
            $query->where('title', 'like', '%'.$searchQuery.'%');
        }

        return $query;
    }

    /**
     * Get the limited display of the title attribute.
     *
     * @return string
     */
    public function getLimitedTitleAttribute(): string
    {
        return Str::words((string) $this->title, 3, '...');
    }

    /**
     * @return string
     */
    public function getLimitedContentAttribute(): string
    {
        return Str::words((string) $this->content, 8, '...');

    }

    /**
     * @return string
     */
    public function getFormattedDateAttribute(): string
    {
        return Carbon::parse($this->created_at)->format('M d, Y');
    }


    /**
     * @return string
     */
    public function getImagePathAttribute(): string
    {
        return $this->image ? asset('storage/task-images/'.$this->image) : asset('images/default.png');
    }

    /**
     * Mutator for the 'published' attribute.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setPublishedAttribute($value): void
    {
        $this->attributes['published'] = $value;

        // Update 'published_at' if 'published' is set to 1
        if ($value == 1) {
            $this->attributes['published_at'] = Carbon::now('Asia/Manila');
        } else {
            $this->attributes['published_at'] = null; // Reset 'published_at' if 'published' is not 1
        }
    }

    /**
     * @return string
     */
    public function getPublishedStrAttribute(): string
    {
        $publishedValue = (int) $this->published;
        return PublishStatus::fromValue($publishedValue)->label($publishedValue);
    }

    /**
     * Get the difference in time from the 'created_at' attribute in human-readable format.
     *
     * @return string
     */
    public function getDiffTimeAttribute(): string
    {
        if ($this->created_at) {
            return Carbon::parse($this->created_at)->diffForHumans();
        }

        return ''; // or any default value you prefer when 'created_at' is null
    }

    /**
     * Check if the user is authorized to edit the given record.
     *
     * @param  Task  $record
     * @return bool
     */
    public function isAuthorizeToEdit(Task $record): bool
    {
        return $record->status !== TaskStatus::DONE;
    }


    /**
     * Handle policy for marking a task as 'To-do'.
     *
     * @param  Task  $record
     * @return bool
     */
    public function handlePolicyMarkAsTodo(Task $record): bool
    {
        $user = $this->user;

        if (!$user) {
            return false; // Or handle the case when user is null
        }

        return $record->status == TaskStatus::IN_PROGRESS ||
            !app(TaskPolicy::class)->markTodo($user, $record);
    }

    /**
     * Handle policy for marking a task as 'In Progress'.
     *
     * @param  Task  $record
     * @return bool
     */
    public function handlePolicyMarkInProgress(Task $record): bool
    {
        $user = $this->user;

        if (!$user) {
            return false; // Or handle the case when user is null
        }

        return $record->status == TaskStatus::TODO ||
            !app(TaskPolicy::class)->markInProgress($user, $record);
    }

    /**
     * Handle policy for marking a task as 'Done'.
     *
     * @param  Task  $record
     * @return bool
     */
    public function handlePolicyMarkDone(Task $record): bool
    {
        $user = $this->user;

        if (!$user) {
            return false; // Or handle the case when user is null
        }

        return $record->status == TaskStatus::TODO ||
            $record->status == TaskStatus::IN_PROGRESS ||
            !app(TaskPolicy::class)->markDone($user, $record);
    }


    /**
     * Get the user associated with the task.
     *
     * @return BelongsTo<User, Task>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}

