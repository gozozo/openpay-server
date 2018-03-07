<?php

namespace Gozozo\OpenpayServer\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardTokenForm extends FormRequest
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
            'token_id' => 'required',
            'device_session_id' => 'required',
        ];
    }
}