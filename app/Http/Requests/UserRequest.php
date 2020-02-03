<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class UserRequest extends FormRequest
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
        $called_function = Route::getCurrentRoute()->getActionMethod();

        $rules = array();

        if($called_function == 'store')
        {
            $rules = [
                       'username' => 'required|unique:users,username',
                       'password' => 'required',
                       'role'     => 'required',
                     ];
        }

        if($called_function == 'update')
        {
            $rules = [
                       'username' => 'required',
                       'role'     => 'required',
                     ];
        }

        return $rules;
    }


    public function attributes()
    {
        return [
            'username' => 'نام کاربری',
            'password' => 'کلمه عبور',
            'role'     => 'نقش کاربری',
        ];
    }

}
