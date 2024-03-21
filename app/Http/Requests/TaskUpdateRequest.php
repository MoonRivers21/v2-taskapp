<?php

namespace App\Http\Requests;

use App\Enums\PublishStatus;
use App\Enums\TaskStatus;
use App\Rules\CheckUniqueTaskTitle;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        $taskId = $this->route('task');
        $currentTitle = $this->input('title');

        return [
            'title' => [
                'required',
                'min:3',
                'max:100',
                new CheckUniqueTaskTitle($taskId, $currentTitle),
            ],
            'content' => [
                'required',
                'min:3',
            ],
            'image' => [
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:4096', //4MB Max size
            ],
            'published' => [
                Rule::in(array_keys(PublishStatus::toSelectArray())),
            ],
            'status' => [
                Rule::in(array_keys(TaskStatus::toSelectArray())),
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'title.unique' => 'The title already exists, please choose a unique title',
            'title.min' => 'Minimum of 3 characters for title',
            'title.max' => 'Maximum of 100 characters only for the field title',
            'content.required' => 'Content is required',
            'image.image' => 'The file must be an image',
            'image.mimes' => 'Supported image formats are jpeg, png, jpg, and gif',
            'image.max' => 'Maximum image size allowed is 4MB',
            'published.in' => 'Invalid published status',
            'status.in' => 'Invalid task status',
        ];
    }
}
