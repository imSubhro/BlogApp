<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'category_id' => [
                'nullable',
                'exists:categories,id',
            ],
            'excerpt' => [
                'nullable',
                'string',
                'max:500',
            ],
            'content' => [
                'required',
                'string',
                'min:10',
            ],
            'featured_image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:2048', // 2MB max
            ],
            'status' => [
                'required',
                'in:draft,published',
            ],
            'tags' => [
                'nullable',
                'array',
            ],
            'tags.*' => [
                'nullable',
                'string',
            ],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Please enter a title for your blog.',
            'title.min' => 'The title must be at least 3 characters.',
            'title.max' => 'The title cannot exceed 255 characters.',
            'content.required' => 'Please enter content for your blog.',
            'content.min' => 'The content must be at least 10 characters.',
            'excerpt.max' => 'The excerpt cannot exceed 500 characters.',
            'featured_image.image' => 'The file must be an image.',
            'featured_image.mimes' => 'The image must be a JPEG, PNG, JPG, GIF, or WebP file.',
            'featured_image.max' => 'The image cannot exceed 2MB.',
            'status.required' => 'Please select a status.',
            'status.in' => 'Invalid status selected.',
        ];
    }
}
