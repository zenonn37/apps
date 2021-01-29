<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimerProjectUpdate extends FormRequest
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
            'name' => 'min:2|max:30|string',
            'goal' => 'integer|min:3600',
            'completed' => 'boolean'
        ];
    }
}
