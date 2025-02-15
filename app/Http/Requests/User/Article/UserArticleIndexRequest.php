<?php

namespace App\Http\Requests\User\Article;

use Illuminate\Foundation\Http\FormRequest;

class UserArticleIndexRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "q" => "nullable|string",
            "per_page" => "nullable|integer|min:1",
            "page" => "nullable|integer|min:1",
            "sources" => "nullable|array",
            "sources.*" => "nullable|string|exists:news_sources,id",
            "categories" => "nullable|array",
            "categories.*" => "nullable|string|exists:categories,id",
            "authors" => "nullable|array",
            "authors.*" => "nullable|string|exists:authors,id"
        ];
    }
}
