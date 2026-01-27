<?php

namespace App\Http\Requests\AliyunICE\Template;

use Illuminate\Foundation\Http\FormRequest;

// name
// string
// 自定义模板名称。
//
// 示例值:
// 模板名称
// Type
// string
// 模板类型，目前支持： 展开详情
//
// 示例值:
// timeline
// Config
// string
// 普通模板 Config 是基于云剪辑 timeline 的封装，自定义模板 Config 会更加灵活。如果您有特殊需求，建议熟悉 Config 结构并自定义模板，详情请参见普通模板 Config 详解。展开详情
// 示例值:
// 参见Timeline模板Config文档
// 参考取值来源:
// GetContentAnalyzeConfig
// cover_url
// string
// 模板封面
//
// 示例值:
// http://example-bucket.oss-cn-shanghai.aliyuncs.com/cover.jpg
// preview_media
// string
// 模板预览视频 MediaId
//
// 示例值:
// ****01bf24bf41c78b2754cb3187****
// Status
// string
// 模板状态，取值范围：展开详情
//
// 示例值:
// Available
// Source
// string
// 模板创建来源，取值范围：展开详情
//
// 示例值:
// OpenAPI
// relatedmediaids
// string
// 模板关联素材，普通模板编辑器使用
//
// 示例值:
// {"video":["1805a0c6ca544fb395a06ca683619655"]}
class CreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            // "name" => "required|string",
            // "type" => "required|string",
            // "config" => "required|string",
            // "cover_url" => "required|string",
            // "preview_media" => "required|string",
            // "status" => "required|string",
            // "source" => "required|string",
            // "related_mediaids" => "required|string",
        ];
    }
}
