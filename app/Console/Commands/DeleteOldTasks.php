<?php

namespace App\Console\Commands;

use App\Enums\PublishStatus;
use App\Enums\TaskStatus;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteOldTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:delete-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trash tasks older than 30 days';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $thresholdDate = Carbon::now()->subDays(30);
          Task::where('created_at', '<', $thresholdDate)
            ->where('published', PublishStatus::PUBLISHED)
            ->where('status', TaskStatus::DONE)
            ->delete();
        $this->info('Old tasks deleted successfully.');
    }
}
