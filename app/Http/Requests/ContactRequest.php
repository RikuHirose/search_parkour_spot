<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'email' => 'required|email',
            'body' => 'required|max:1000'
        ];
    }
    public function attributes() {
        return [
            'name' => 'お名前',
            'email' => 'メールアドレス',
            'body' => '内容'
        ];
    }
}