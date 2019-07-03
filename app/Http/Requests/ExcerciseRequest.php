<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExcerciseRequest extends FormRequest
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
            'name' => 'required|max:30|min:2',
            'sets' => 'required|integer',
            'reps' => 'required|integer',
            'level' => 'required|string',
            'instructions' => 'required|string|min:10|max:2000',
            'failure' => 'required|boolean',
            'program_id' => 'required|integer'


        ];
    }
}
