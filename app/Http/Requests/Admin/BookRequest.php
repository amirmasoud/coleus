<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'pages' => 'required|numeric',
            'ISBN' => 'required|max:255',
            'price' => 'required|numeric',
            'year' => 'required|numeric',
            'description' => 'required',
        ];
    }
}
