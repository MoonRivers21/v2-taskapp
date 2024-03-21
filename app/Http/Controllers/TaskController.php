<?php

namespace App\Http\Controllers;

use App\Enums\PublishStatus;
use App\Enums\TaskStatus;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return View
     */
    public function index(Request $request): View
    {
        $user = (int) auth()->id();

        // Ensure $perPage is an integer or defaults to 5
        $perPage = (int) $request->query('per_page') ? (int) $request->query('per_page') : 5;

        $statusOptions = TaskStatus::toSelectArray();

        // Ensure $sortColumn is a string or defaults to 'created_at'
        /** @phpstan-ignore-next-line */
        $sortColumn = (string) $request->filled('sort') ? (string) $request->query('sort') : 'created_at';

        // Ensure $sortOrder is a string or defaults to 'asc'
        /** @phpstan-ignore-next-line */
        $sortOrder = (string) $request->filled('order') ? (string) $request->query('order') : 'desc';

        $searchQuery = $request->query('search');

        // Call the filterTasks function from Task model
        $tasksQuery = Task::filterTasks($user, $request);

        $tasks = $tasksQuery->orderBy($sortColumn, $sortOrder)->paginate($perPage);

        return view('tasks.index', compact('tasks', 'statusOptions', 'sortColumn', 'sortOrder', 'searchQuery'))
            ->with('sort', $sortColumn)
            ->with('order', $sortOrder)
            ->with('status', $request->input('status', ''));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  TaskStoreRequest  $request
     * @return RedirectResponse
     */
    public function store(TaskStoreRequest $request): RedirectResponse
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validated();

            // Set the user_id of the task to the authenticated user's ID
            $validatedData['user_id'] = auth()->id();

            if ($request->hasFile('image')) {
                $image = $request->file('image');

                // Generate a unique image name
                /** @var UploadedFile $image */
                $imageName = sprintf("%s.%s", uniqid(), $image->getClientOriginalExtension());

                // Store the image in the 'task-images' directory
                $image->storeAs('task-images', $imageName, 'public');

                // Add the image path to the validated data
                $validatedData['image'] = $imageName;
            }

            // Create a new task using the validated data
            Task::create($validatedData);

            // Notify success
            /** @phpstan-ignore-next-line */
            notyf()
                ->position('x', 'center')
                ->position('y', 'top')
                ->addSuccess('Task has been successfully created.');

        } catch (Exception $e) {
            // Log the error
            Log::error('An error occurred: '.$e->getMessage());

            // Notify error
            /** @phpstan-ignore-next-line */
            notyf()
                ->position('x', 'center')
                ->position('y', 'top')
                ->addError('Something error occurred. Please contact the system administrator.');
        }

        // Redirect to the tasks index page
        return redirect()->route('tasks.index');
    }

    public function create(): View
    {
        $this->authorize('create', Task::class);
        return view('tasks.create');
    }

    /**
     * @param  Request  $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function edit(Request $request)
    {
        $task = Task::find($request->task);
        $this->authorize('update', $task);

        if ($task) {
            return view('tasks.edit', compact('task'));
        } else {
            Log::error('An error occurred, while retrieving task details');

            /** @phpstan-ignore-next-line */
            notyf()
                ->position('x', 'center')
                ->position('y', 'top')
                ->addError('Something error occurred, Please contact system admin');
            return back();
        }
    }

    /**
     * @param  TaskUpdateRequest  $request
     * @param  Task  $task
     * @return RedirectResponse
     */
    public function update(TaskUpdateRequest $request, Task $task): RedirectResponse
    {
        $this->authorize('update', $task);

        $validated = $request->validated();

        // Store the image
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            /** @var UploadedFile $image */
            $imageName = uniqid().'.'.$image->getClientOriginalExtension();
            $image->storeAs('task-images', $imageName, 'public'); // Store the image in the 'task-images' directory
            $validated['image'] = $imageName;
        }

        $validated['published'] = $request->published ?? 0;
        $task->update($validated);


        /** @phpstan-ignore-next-line */
        notyf()
            ->position('x', 'center')
            ->position('y', 'top')
            ->addSuccess('Task has been successfully updated');
        return back();
    }

    /**
     * @param  int  $id
     * @param  int  $progress
     * @return RedirectResponse
     */
    public function upStatus($id, $progress): RedirectResponse
    {
        $task = Task::find($id);

        if ($task === null) {
            return back()->withErrors('Task not found.');
        }

        $checkStatus = TaskStatus::hasValue($progress);
        if ($checkStatus) {
            /** @var string $progress */
            $task->status = $progress;
            $task->save();

            /** @phpstan-ignore-next-line */
            notyf()
                ->position('x', 'center')
                ->position('y', 'top')
                ->addSuccess("Task <b>{$task->limitedTitle}</b> has been set as <b>{$progress}</b>.");

        } else {
            $task->published = PublishStatus::fromValue(PublishStatus::PUBLISHED)->toValueBool(true);
            $task->save();

            /** @phpstan-ignore-next-line */
            notyf()
                ->position('x', 'center')
                ->position('y', 'top')
                ->addSuccess("Task <b>{$task->limitedTitle}</b> has been <b>published</b>.");
        }

        return back();
    }


    /**
     * @param  Task  $task
     * @return RedirectResponse
     */
    public function destroy(Task $task): RedirectResponse
    {
        // Delete the task instance (soft delete)
        $task->delete();
        $title = Str::words($task->title, 3);

        /** @phpstan-ignore-next-line */
        notyf()
            ->position('x', 'center')
            ->position('y', 'top')
            ->addSuccess("Task {$title} has been moved to trash.");
        return back();
    }


    /**
     * @param  Task  $task
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     * @throws AuthorizationException
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return view('tasks.show', compact('task'));
    }
}
