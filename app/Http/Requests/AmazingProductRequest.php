<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AmazingProductRequest extends FormRequest
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
            'short_title'     => 'required',
            'long_title'      => 'required',
            'description'     => 'required|nullable',
            'price'           => 'required|integer',
            'price_discounted'=> 'required|integer',
            'product_id'      => 'required|integer',
            'time_amazing'    => 'required|integer',
        ];
    }

    public function attributes()
    {
        return [
            'short_title'     => 'عنوانک',
            'long_title'      => 'عنوان',
            'description'     => 'توضیح',
            'price'           => 'هزینه اصلی محصول',
            'price_discounted'=> 'تخفیف',
            'product_id'      => 'شناسه محصول',
            'time_amazing'    => 'مدت زمان شگفت انگیز بودن',
        ];
    }
}
