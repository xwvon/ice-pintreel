<?php

namespace App\Http\Requests\AliyunICE\BatchMediaProducingJob;

use Illuminate\Foundation\Http\FormRequest;

//client_token	string	否
// 调用方保证请求幂等性 Client Token
//
// ****12e8864746a0a398****
// input_config	string	否
// 用户合成输出配置。具体结构定义，请参见 input_config 配置说明。
//
// {
//   "MediaGroupArray": [{
//       "GroupName": "MediaGroup1",
//       "MediaArray": [
//         "****9d46c886b45481030f6e****",
//         "****6c886b4549d481030f6e****" ]
//     }, {
//       "GroupName": "MediaGroup2",
//       "MediaArray": [
//         "****d46c886810b454930f6e****",
//         "****4549d886810b46c30f6e****" ]
//   }],
//   "TitleArray": [
//       "回龙观盒马鲜生开业啦",
//       "盒马鲜生开业啦" ],
//   "SpeechTextArray": [
//       "附近的商场新开了一家盒马鲜生，今天是第一天开业"
//       "商场里的人不少，零食、酒水都比较便宜大家也快来看看呀" ]
// }
// editing_config	string	否
// 剪辑相关配置。具体结构定义，请参见 editing_config 配置说明。
//
// {
//   "MediaConfig": {
//       "Volume": 0
//   },
//   "SpeechConfig": {
//       "Volume": 1
//   },
//  "BackgroundMusicConfig": {
//       "Volume": 0.3
//   }
// }
// output_config	string	否
// 输出配置。具体结构定义，请参见 output_config 配置说明。
//
// {
//   "MediaURL": "http://xxx.oss-cn-shanghai.aliyuncs.com/xxx_{index}.mp4",
//   "Count": 20,
//   "MaxDuration": 15,
//   "Width": 1080,
//   "Height": 1920,
//   "Video": {"Crf": 27}
// }
// user_data	string	否
// 用户业务配置、回调配置。具体结构定义，请参见 user_data 配置说明。
//
// {"NotifyAddress":"http://xx.xx.xxx"}或{"NotifyAddress":"https://xx.xx.xxx"}或{"NotifyAddress":"ice-callback-demo"}
class CreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'input_config' => 'array',
            'editing_config' => 'array',
            'output_config' => 'array',
        ];
    }
}
