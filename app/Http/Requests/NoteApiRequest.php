<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class NoteApiRequest extends FormRequest
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
            'title' => 'required|max:50',
            'note' => 'nullable|max:1000',
        ];
    }

    /**
     * Get the validation custom messages
     *
     * @return array
     */
    public function messages() {
        return [
        'title.required'       => 'Note title is required.',
        'title.max'      => 'Note titles cannot be more than 50 characters in length.',
        'note.max'      => 'Notes cannot be more than 1000 characters in length.',
        ];
    }
    
    /**
     * Override failedValidation to return json response without redirect. 
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

}
