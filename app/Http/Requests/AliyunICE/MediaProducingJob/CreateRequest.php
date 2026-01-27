<?php

namespace App\Http\Requests\AliyunICE\MediaProducingJob;

use Illuminate\Foundation\Http\FormRequest;

// project_id	string	否
// 剪辑工程 ld。
//
// 注意
// 必须填写 ProgectId、timeline、TempalteId 三个参数中的一个，剩余两个参数填写为空。
// xxxxxfb2101cb318xxxxx
// timeline	string	否
// 云剪辑任务时间线。具体结构定义，请参见 timeline 配置说明。
//
// 注意
// 必须填写 ProgectId、timeline、TempalteId 三个参数中的一个，剩余两个参数填写为空。
// {"VideoTracks":[{"VideoTrackClips":[{"MediaId":"****4d7cf14dc7b83b0e801c****"},{"MediaId":"****4d7cf14dc7b83b0e801c****"}]}]}
// template_id	string	否
// 模板 Id，用于快速低门槛的构建时间线。
//
// 注意
// 必须填写 ProgectId、timeline、TempalteId 三个参数中的一个，剩余两个参数填写为空。 当 template_id 不为空时，clips_param 不能为空。
// ****96e8864746a0b6f3****
// clips_param	string	否
// 模板对应的素材参数，Json 格式，当 template_id 不为空时，clips_param 不能为空。具体格式见 普通模板创建及使用、高级模板创建及使用。
//
// 见模板使用文档
// project_metadata	string	否
// 剪辑工程的元数据信息，Json 格式。具体结构定义参见 project_metadata 。
//
// {"Description":"剪辑视频描述","Title":"剪辑标题测试"}
// output_media_target	string	否
// 输出成品的目标类型。取值：
//
// oss-object（客户在阿里云 oss bucket 下的 oss object）
//
// vod-media（阿里云 vod 的媒资）
//
// oss-object
// output_media_config	string	是
// 输出成品的目标配置，Json 格式。可以设置输出成品的在 OSS 上的 URL，或者 VOD Bucket 中的存储位置。
//
// 输出到 OSS 时，输出目标的 MediaURL 必填；输出到 VOD 时，StorageLocation 和 FileName 两个参数必填。
//
// output_media_config 参数示例。
//
// {"MediaURL":"https://example-bucket.oss-cn-shanghai.aliyuncs.com/example.mp4"}
// user_data	string	否
// 自定义设置，Json 格式，长度限制为 512 字节。支持自定义回调地址配置。
//
// {"NotifyAddress":"http://xx.xx.xxx"}或{"NotifyAddress":"https://xx.xx.xxx"}或{"NotifyAddress":"ice-callback-demo"}
// client_token	string	否
// 保证请求幂等性。
//
// ****12e8864746a0a398****
// Source	string	否
// 剪辑合成请求来源，取值范围：
//
// OpenAPI：API 直接请求。
//
// AliyunConsole：请求来自于阿里云控制台。
//
// WebSDK：请求来自于集成了 WebSDK 的前端页面。
//
// OPENAPI
// editing_produce_config	string	否
// 剪辑合成参数， 参数详情。
//
// AutoRegisterInputVodMedia：是否需要将您时间线中的 VOD 媒资自动注册至 IMS，默认为 true。
//
// OutputWebmTransparentChannel: 是否需要输出视频带透明通道，默认为 false。
//
// CoverConfig: 自定义封面图参数。
//
// 等......
//
// {
//       "AutoRegisterInputVodMedia": "true",
//       "OutputWebmTransparentChannel": "true"
// }
// media_metadata	string	否
// 合成视频的元数据，JSON 格式。具体结构定义，请参见 media_metadata 。
//
// {
//       "Title":"test-title",
//       "Tags":"test-tags1,tags2"
// }
class CreateRequest extends FormRequest
{
    public function rules()
    {
        // project_id,timeline,template_id 不能同时存在, 且不能同时为空, 否则报错
        return [
            "project_id" => ["string", "required_without_all:timeline,template_id"],
            "timeline" => ["array"],
            "template_id" => "string",
            "clips_param" => "array",
            "project_metadata" => "array",
            "output_media_target" => "string|in:oss-object,vod-media",
            "output_media_config" => "required|array",
            // "user_data" => "string",
            "client_token" => "required|string",
            // "Source" => "required|string",
            "editing_produce_config" => "array",
            "media_metadata" => "array",
        ];
    }
}
