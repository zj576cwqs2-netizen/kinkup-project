<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|max:200',
            'content' => 'required|max:1000',
            'post_date' => 'nullable|date',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|max:5120', 
        ];
    }
}