<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// InputURL	string	是
// 待注册的媒资在相应系统中的地址，一经注册不可更改，并与 IMS 的 mediaId 绑定。
//
// OSS 地址，支持两种格式。
// http(s)://example-bucket.oss-cn-shanghai.aliyuncs.com/example.mp4
//
// oss://example-bucket/example.mp4 （此格式默认 oss region 与服务接入区域一致）
//
// VOD 媒资
// vod://***20b48fb04483915d4f2cd8ac****
//
// http://example-bucket.oss-cn-shanghai.aliyuncs.com/example.mp4  或  vod://****20b48fb04483915d4f2cd8ac****
// MediaType	string	否
// 媒资媒体类型。取值范围：
//
// "image" 图片
//
// "video" 视频
//
// "audio" 音频
//
// "text" 文字
//
// 此字段建议用户按需填写。当 InputURL 字段是 OSS URL 时，也支持按照文件后缀自动判断媒资类型（仅限图片、视频、音频文件后缀），对应关系见文件格式。
//
// video
// BusinessType	string	否
// 媒资业务类型。取值范围：
//
// "subtitles" 字幕
//
// "watermark" 水印
//
// "opening" 片头/开场
//
// "ending" 片尾
//
// "general" 通用
//
// opening
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
// UserData	string	否
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
// ClientToken	string	否
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
class CreateMediaInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_infos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("user_id")->index()->comment('用户ID');
            $table->string('input_url');
            $table->string('media_type')->nullable();
            $table->string('media_id')->unique();
            $table->string('reference_id', 64)->unique();
            $table->string('client_token', 32)->nullable();
            $table->string('business_type')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('media_tags', 32 * 16)->nullable();
            $table->string('cover_url', 128)->nullable();
            $table->string('user_data', 1024)->nullable();
            $table->boolean('overwrite')->default(false);
            $table->string('register_config')->nullable();
            $table->unsignedBigInteger('cate_id')->nullable();
            $table->string('workflow_id')->nullable();
            $table->string('smart_tag_template_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_infos');
    }
}
