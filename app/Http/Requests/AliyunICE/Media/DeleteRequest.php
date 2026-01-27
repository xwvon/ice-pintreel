<?php

namespace App\Http\Requests\AliyunICE\Media;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $client_token
 */
class DeleteRequest extends FormRequest
{
    public function rules()
    {
        // client_token, media_id must one of them
        return [
            'client_token' => 'string|required_without:id',
            'id'     => 'required_without:client_token',
        ];
    }

    public function attributes()
    {
        return [
            'client_token' => '客户端令牌',
            'media_id'     => '媒体ID',
        ];
    }
}
