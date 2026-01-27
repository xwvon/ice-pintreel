<?php

namespace App\Http\Requests\AliyunICE\BatchMediaProducingJob;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $job_id
 * @property string $client_token
 */
class SyncRequest extends FormRequest
{
    public function rules()
    {
        return [
            // must have one
            'client_token' => 'string|required_without:job_id',
            'job_id' => 'string|required_without:client_token',
        ];
    }
}
