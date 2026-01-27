<?php

namespace App\Http\Requests\AliyunICE\MediaProducingJob;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $client_token
 * @property string $job_id
 */
class SyncRequest extends FormRequest
{
    public function rules()
    {
        return [
            'client_token' => 'string|required_without:job_id',
            'job_id' => 'string|required_without:client_token',
        ];
    }
}
