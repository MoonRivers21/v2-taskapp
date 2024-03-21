<?php

namespace App\Http\Controllers;

use App\Enums\PublishStatus;
use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{


    public function index(): \Illuminate\Foundation\Application|Factory|View|Application
    {

        $user = auth()->id();

        //To-do Task list
        $todotask = Task::where('status', TaskStatus::TODO)
            ->where('published', PublishStatus::PUBLISHED)
            ->where('user_id', $user)
            ->get();

        //Draft Task list
        $draftTasks = Task::where('published', PublishStatus::DRAFT)
            ->where('user_id', $user)
            ->whereNull('deleted_at')
            ->get();

        //In-progress Task list
        $inProgressTasks = Task::where('published', PublishStatus::PUBLISHED)
            ->where('status', TaskStatus::IN_PROGRESS)
            ->where('user_id', $user)
            ->whereNull('deleted_at')
            ->get();

        $countProgress = Task::where('status', TaskStatus::IN_PROGRESS)
            ->where('published', PublishStatus::PUBLISHED)
            ->where('user_id', $user)
            ->count();

        $countDone = Task::where('status', TaskStatus::DONE)
            ->where('published', PublishStatus::PUBLISHED)
            ->where('user_id', $user)
            ->count();

        $countTodo = Task::where('status', TaskStatus::TODO)
            ->where('published', PublishStatus::PUBLISHED)
            ->where('user_id', $user)
            ->count();

        $countTrash = Task::onlyTrashed()->where('user_id', $user)->count();

        $countDraft = Task::where('published', PublishStatus::DRAFT)
            ->where('user_id', $user)
            ->whereNull('deleted_at')
            ->count();

        return view('dashboard', compact(
                'todotask',
                'countProgress',
                'countDone',
                'countTrash',
                'countTodo',
                'countDraft',
                'draftTasks',
                'inProgressTasks'
            )
        );
    }


}
