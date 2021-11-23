<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (bool) auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:200|min:1',
            'email' => 'email|unique:users,email,'.$this->user->id,
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'googleplus' => 'nullable|url|max:255',
            'bio' => 'nullable|max:1000',
            'password' => 'nullable|min:5'
        ];
    }

    public function messages()
    {
        return [
            'facebook.url' => 'Provided Facebook URL is invalid.',
            'twitter.url' => 'Provided Twitter URL is invalid.',
            'googleplus.url' => 'Provided Google Plus URL is invalid.',
            'bio.max' => 'The biography should not exceed 1000 characters.'
        ];
    }
}
