<?php

namespace App\Http\Requests\FileUpload;

use Illuminate\Foundation\Http\FormRequest;

class SimpleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $mimeTypes = 'image/jpeg,image/png,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,audio/mpeg,video/mp4,text/csv,application/csv';

        return [
            'file' => "required|file|max:50000|mimetypes:{$mimeTypes}",
            'disk' => ['required', 'in:public,local'],
        ];
    }

    public function messages() {
        return [
            'file.required' => '请上传文件',
            'file.file' => '请上传文件',
            'file.max' => '文件大小不能超过50M',
            'file.mimetypes' => '文件类型错误, 仅支持jpeg, png, pdf, docx, xlsx, mp3, mp4, csv',
            'disk.required' => '请选择存储位置',
            'disk.in' => '存储位置错误',
        ];
    }
}
