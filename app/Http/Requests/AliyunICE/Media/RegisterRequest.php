<?php

namespace App\Http\Requests\AliyunICE\Media;

use Illuminate\Foundation\Http\FormRequest;

// Title	string	否
// 标题，若不提供，根据日期自动生成默认 title。
//
// 长度不超过 128 字节。
//
// UTF8 编码。
//
// defaultTitle
// Description	string	否
// 内容描述。
//
// 长度不超过 1024 字节
//
// UTF8 编码。
//
// defaultDescription
// MediaTags	string	否
// 标签。
//
// 最多不超过 16 个标签。
//
// 多个用逗号分隔。
//
// 单个标签不超过 32 字节。
//
// UTF8 编码。
//
// tag1,tag2
// CoverURL	string	否
// 封面地址。
//
// 长度不超过 128 字节。
//
// UTF8 编码。
//
// http://example-bucket.oss-cn-shanghai.aliyuncs.com/example.png
// user_data	string	否
// 用户数据。支持自定义回调地址配置，配置说明可参考配置剪辑完成时的回调
//
// 长度不超过 1024 字节。
//
// UTF8 编码。
//
// Json 格式
//
// {"NotifyAddress":"http://xx.xx.xxx"} 或{"NotifyAddress":"https://xx.xx.xxx"} 或{"NotifyAddress":"ice-callback-demo"}
// Overwrite	boolean	否
// 是否覆盖已注册媒资，默认 false。
//
// -true，如果 inputUrl 已注册，删除原有媒资并注册新媒资；
//
// -false, 如果 inputUrl 已注册则不予注册新媒资，暂不支持重复的 inputUrl。
//
// true
// client_token	string	否
// 客户端 token，32 位 UUID，保证请求幂等性。
//
// ****0311a423d11a5f7dee713535****
// RegisterConfig	string	否
// 注册配置。
//
// 默认为媒资生成雪碧图，如不需要可以手动设置 NeedSprite 字段为 false。
//
// 默认生成截图，如不需要可以手动设置 NeedSnapshot 字段为 false。
//
// {
//       "NeedSprite": "false"
// }
// CateId	long	否
// 分类 ID。
//
// 3048
// WorkflowId	string	否
// 工作流 ID
//
// ******b4fb044839815d4f2cd8******
// ReferenceId	string	否
// 自定义 ID，仅支持小写字母、大写字母、数字、横线、下划线，长度 6-64 位。需保证用户维度唯一。
//
// 123-123
// SmartTagTemplateId	string	否
// 智能标签模板。取值：
//
// S00000101-300080：包含 NLP 内容理解功能的系统模板
// 配置该字段后，媒资注册完成会自动发起智能标签分析任务，相关计费项请参考 智能标签标准版计费。
//
// S00000101-300080
class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'input_url'             => 'required|string',
            'media_type'            => 'required|string|in:image,video,audio,text',
            'business_type'         => 'required|string|in:subtitles,watermark,opening,ending,general',
            'title'                 => 'string',
            'description'           => 'string',
            'media_tags'            => 'string',
            'cover_url'             => 'string',
            // 'user_data'             => 'array',
            'overwrite'             => 'boolean',
            'client_token'          => 'required|string',
            'register_config'       => 'string',
            'cate_id'               => 'integer',
            'workflow_id'           => 'string',
            'reference_id'          => 'string',
            'smart_tag_template_id' => 'string',
        ];
    }
}
