<?php

namespace App\Http\Requests\AliyunOSS;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $path
 */
class SignUrlRequest extends FormRequest
{
    public function rules()
    {
        return [
            'path'        => 'required|string',
            'http_method' => 'string|in:PUT,GET',
            'expires'     => 'integer',
            'bucket'      => 'string',
            'endpoint'    => 'string',
        ];
    }

    public function messages()
    {
        return [
            'http_method.in' => 'http_method 必须是 PUT,GET'
        ];
    }
}
