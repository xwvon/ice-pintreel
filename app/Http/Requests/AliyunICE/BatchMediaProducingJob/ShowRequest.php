<?php

namespace App\Http\Requests\AliyunICE\BatchMediaProducingJob;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $client_token
 */
class ShowRequest extends FormRequest
{
    public function rules()
    {
        return [
            'client_token' => 'required|string',
        ];
    }
}
