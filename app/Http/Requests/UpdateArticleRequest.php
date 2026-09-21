<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
   {
    return true;
   } 

   public function rules():array
{
    return [
        'title' => ['required', 'string', 'max:200'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],

    ];
    }
}