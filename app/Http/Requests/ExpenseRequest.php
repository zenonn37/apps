<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:40',
            'type' => 'required|string|min:3',
            'amount'=>'required|min:1',
            'due'=>'required',
            'paid'=>'required',
            'repeated'=>'required',
            'category'=>'required|string|min:3'
        ];
    }
}
