<?php

namespace Gozozo\OpenpayServer\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardForm extends FormRequest
{
    const RULES = [
        'holder_name' => 'required|string',
        'card_number' => 'required|numeric',
        'cvv2' => 'required|string|min:3|max:4',
        'expiration_month' => 'required|numeric|min:0|max:12',
        'expiration_year' => 'required|string|size:2',
        'device_session_id' => 'required',
    ];

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
        return self::RULES;
    }
}