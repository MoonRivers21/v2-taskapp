<?php

namespace App\Http\Requests;

use App\Enums\PublishStatus;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class TaskStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array{title: array{0: string, 1: string, 2: string, 3: Unique}, image: string, content: string, published: string}
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'min:3',
                'max:100',
                Rule::unique('tasks')->where(function ($query) {
                    // Get the authenticated user's ID
                    $userId = Auth::id();
                    // Add a condition to check uniqueness only within the user's task records
                    return $query->where('user_id', $userId);
                }),
            ],
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:4048',
            'content' => 'required|min:3',
            'published' => Rule::in(PublishStatus::toSelectArray()),
            'status' => Rule::in(TaskStatus::toSelectArray())

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
            'user_id' => 'Unauthorized action, Please contact system admin',
            'image.max' => 'Maximum image size allowed 4mb'
        ];

    }
}
