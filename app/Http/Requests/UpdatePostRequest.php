<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "title" => 'required|min:3|unique:posts,title,' . $this->route('post')->id,
            "category" => "required|exists:categories,id",
            "body" => "required|min:10",
            "photos.*" => "mimes:png,jpg|file|max:1024",
            "featured_image" => "nullable|mimes:png,jpg,jpeg|file|max:512"
        ];
    }
}
