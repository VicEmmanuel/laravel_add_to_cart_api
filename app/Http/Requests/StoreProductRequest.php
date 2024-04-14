<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_name' => ['required','max:255'],
            'product_description' => ['required'],
            'photo'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price'=> ['required'],
            'is_added_to_cart' =>['string']
        ];
    }
}
