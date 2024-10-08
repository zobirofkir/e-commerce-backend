<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            "name" => "required|string|min:5",
            "price" => "required|string",
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            "description" => "required|string",
            "additionalInfo" => "required|string",
            "stars" => "nullable|integer"
        ];
    }
}
