<?php

namespace App\Http\Requests\UserFile;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'   => 'required|string|max:128',
            'disk'   => 'required|string|in:public,local,s3,oss',
            'path'   => 'required|string|max:255',
            'type'   => 'required|string|in:image,video,audio,text,document,other',
            'ext'    => 'required|string|max:32',
            'size'   => 'integer',
            'mime'   => 'string',
            'labels' => 'array',
        ];
    }

}
