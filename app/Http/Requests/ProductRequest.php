<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'title' =>'required',
            'cat'=>'required',
            'code'=>'required|integer',
            'price'=>'required|integer',
            'discount'=>'integer|nullable',
            'product_number'=>'integer|nullable',
        ];
    }

    public function attributes()
    {
        return [
            'title'=>'نام محصول',
            'cat'=>'دسته',
            'code'=>'نام لاتین دسته',
            'price'=>'هزینه',
        ];
    }
}
