<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThreadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if($this->path() === "thread/store/" . $this->route("id")){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "text" => "required|max:500",
            "thread_image" => "nullable|image|mimes:jpeg,jpg,png,gif|max:10000",
        ];
    }

    public function messages()
    {
        return [
            "text.required" => "コメントは文字入力が必須です",
            "text.max" => "コメントは500字以内で入力して下さい",
            "thread_image.image" => "画像はjpeg・jpg・png・gif形式のいずれかを選択して下さい",
            "thread.max" => "10M以下の画像を選択して下さい",
        ];
    }
}
