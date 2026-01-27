<?php

namespace App\Http\Requests\AliyunICE\Media;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $client_token
 * @property string $media_id
 */
class SyncRequest extends FormRequest
{
    public function rules()
    {
        return [
            // media_id, client_token must have one
            'client_token' => 'string|required_without:media_id',
            'media_id'     => 'string|required_without:client_token',
        ];
    }

    public function attributes()
    {
        return [
            'client_token' => '客户端ID',
            'media_id'     => '媒体ID',
        ];
    }
}
