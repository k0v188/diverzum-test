<?php

namespace App\Http\Requests;

use App\Helpers\CouponHelper;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'name' => 'required|string',
            'type' => Rule::in(['one', 'custom']),
            'active' => 'required|boolean',
            'discount' => 'required|numeric',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Név megadása kötelező',
            'discount.required' => 'Kedvezmény megadása kötelező',
        ];
    }

    public function passedValidation()
    {
        $this->merge([
           'code' => CouponHelper::generateCouponCode()
        ]);
    }
}
