<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'product_name' => 'required|string',
            'description' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png',
            'category' => 'required',
            'condition' => 'required',
            'price' => 'required|numeric|min:0',
        ];
    }

    public function massages()
    {
        return [
            'product_name.required' => '商品名は必須です。',
            'description.required' => '商品説明は必須です',
            'description.max' => '文字数は255文字以内で入力してください',
            'image.required' => '商品画像は必須です',
            'image.mimes' => '拡張子は.Jpegもしくは.pngで指定してください',
            'category.required' => 'カテゴリーを選択してください',
            'condition.required' => '商品の状態を選択してください',
            'price.required' => '商品価格を入力してください',
            'price.numeric' => '数値で入力してください',
            'price.min' => '0円以上で入力してください',
        ];
    }
}
