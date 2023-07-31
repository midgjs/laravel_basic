<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool // 권한 확인
    {
        return $this->user()->can('update', $this->route('article'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array // 유효성 검증
    {
        return [
            'body' => [
                'required',
                'string',
                'max:255'
            ]
        ];
    }
}
