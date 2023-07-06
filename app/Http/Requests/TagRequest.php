<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'name' => 'required|string|min:3|max:35|unique:tags,name,' . $id,
        ];
    }

//    public function messages(): array
//    {
//        return [
////            'required' => 'The :attribute field is required.',
////            'name.required' => 'The name field is required.',
////            'name.string' => 'The name field must be string.',
////            'name.min' => 'The name field must be at least 3 characters.',
////            'name.max' => 'The name field may not be greater than 35 characters.',
////            'name.unique' => 'The name field must be unique.',
//        ];
//    }
}
