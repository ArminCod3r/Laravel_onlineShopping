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
            'bon'=>'integer|nullable',
            'product_status'=>'nullable',
            'show_product'=>'nullable',
            'special'=>'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'title'=>'نام محصول',
            'cat'=>'دسته',
            'code'=>'نام لاتین دسته',
            'price'=>'هزینه',
            'discount'=>'تخفیف',
            'product_number'=>'تعداد موجودی',
            'bon'=>'تعداد بن خرید محصول',
            'product_status'=>'وضعیت موجودی',
            'show_product'=>'نمایش محصول',
            'special'=>'پیشنهاد ویژه',
        ];
    }
}
