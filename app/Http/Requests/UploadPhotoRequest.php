<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadPhotoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //image is required, must be a file, not greater than 2048kb, and must be a jpg,jpeg or png file type
            'image' => 'required|file|max:2048|mimes:jpg,jpeg,png',
            'caption' => 'string'
        ];
    }
}
