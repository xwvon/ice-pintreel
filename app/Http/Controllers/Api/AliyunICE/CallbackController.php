<?php

namespace App\Http\Controllers\Api\AliyunICE;

use App\Helper;
use App\Http\Controllers\ApiBaseController;
use App\Jobs\SyncBatchMediaProducingJob;
use App\Jobs\SyncMediaDetail;
use App\Jobs\SyncMediaProducingJob;
use App\Models\BatchMediaProducingJob;
use App\Models\MediaInfo;
use App\Models\MediaProducingJob;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\ProduceMediaComplete;

class CallbackController extends ApiBaseController
{
    const FileUploadComplete          = 'FileUploadComplete';
    const UploadByURLComplete         = 'UploadByURLComplete';
    const ImageUploadComplete         = 'ImageUploadComplete';
    const AttachedMediaUploadComplete = 'AttachedMediaUploadComplete';
    const RegisterStreamComplete      = 'RegisterStreamComplete';
    const StreamUploadComplete        = 'StreamUploadComplete';
    const UploadStreamByURLComplete   = 'UploadStreamByURLComplete';
    const CreateAuditComplete         = 'CreateAuditComplete';
    const RegisterMediaComplete       = 'RegisterMediaComplete';
    const DeleteMediaComplete         = 'DeleteMediaComplete';
    const MediaBaseChangeComplete     = 'MediaBaseChangeComplete';
    const WorkflowTaskComplete        = 'WorkflowTaskComplete';
    const VideoAnalysisComplete       = 'VideoAnalysisComplete';
    const SnapshotComplete            = 'SnapshotComplete';
    const DynamicImageComplete        = 'DynamicImageComplete';
    const TranscodeComplete           = 'TranscodeComplete';
    const TranscodeParentComplete     = 'TranscodeParentComplete';
    const AIMediaAuditComplete        = 'AIMediaAuditComplete';
    const AIProduceComplete           = 'AIProduceComplete';
    const MediaAiAnalysisComplete     = 'MediaAiAnalysisComplete';
    const ProduceMediaComplete        = 'ProduceMediaComplete';
    const BatchProduceMediaComplete   = 'BatchProduceMediaComplete';
    const LiveRecordFileCreated       = 'LiveRecordFileCreated';
    const LiveRecordTaskStatus        = 'LiveRecordTaskStatus';
    const LiveSnapshotFileCreated     = 'LiveSnapshotFileCreated';

    private $events = [
        self::FileUploadComplete,
        self::UploadByURLComplete,
        self::ImageUploadComplete,
        self::AttachedMediaUploadComplete,
        self::RegisterStreamComplete,
        self::StreamUploadComplete,
        self::UploadStreamByURLComplete,
        self::CreateAuditComplete,
        self::RegisterMediaComplete,
        self::DeleteMediaComplete,
        self::MediaBaseChangeComplete,
        self::WorkflowTaskComplete,
        self::VideoAnalysisComplete,
        self::SnapshotComplete,
        self::DynamicImageComplete,
        self::TranscodeComplete,
        self::TranscodeParentComplete,
        self::AIMediaAuditComplete,
        self::AIProduceComplete,
        self::MediaAiAnalysisComplete,
        self::ProduceMediaComplete,
        self::BatchProduceMediaComplete,
        self::LiveRecordFileCreated,
        self::LiveRecordTaskStatus,
        self::LiveSnapshotFileCreated,
    ];

    public function index(Request $request)
    {
        // {"EventType":"RegisterMediaComplete","UserId":1074210416593145,"EventTime":"2024-07-25T09:21:36Z","MessageBody":{"Status":"Success","MediaId":"4aabe1804a6771ef9748f6f7d6496301"}}
        Log::channel('ice-callback')->info('ice callback:', [
            'data' => $request->all(),
        ]);
        try {
            if (!in_array($request->EventType, $this->events)) {
                return response(config('app.debug') ? 'event not support' : null, 500);
            }
            switch ($request->EventType) {
                case self::RegisterMediaComplete:
                    $this->registerMediaComplete($request);
                    break;
                case self::BatchProduceMediaComplete:
                    $this->batchProduceMediaComplete($request);
                    break;
                case self::ProduceMediaComplete:
                    $this->produceMediaComplete($request);
                    break;
                default:
                    break;
            }
            return 'success';
        } catch (Exception $e) {
            return response('fail', 500);
        }
    }

    private function registerMediaComplete(Request $request)
    {
        $params  = $request->MessageBody ?? [];
        $params = Helper::arrayKeySnake($params);
        $mediaId = $params['media_id'] ?? "";
        if (!$mediaId) {
            return;
        }
        $media   = MediaInfo::query()->where('media_id', $mediaId)->first();

        if (!$media) {
            $model = new MediaInfo();
            $model->forceFill($params);
            $model->user_id      = $model->user_data['user_id'] ?? "";
            $model->client_token = $model->user_data['client_token'] ?? "";
            $model->save();
        }

        SyncMediaDetail::dispatch(['user_id' => $media->user_id, 'media_id' => $media->media_id]);
    }

    private function batchProduceMediaComplete(Request $request)
    {
        // {
        // 	"EventType": "BatchProduceMediaComplete",
        // 	"UserId": 183320223000****,
        // 	"EventTime": "2024-01-09T08:37:24Z",
        // 	"MessageBody": {
        // 		"Status": "Finished",
        // 		"UserData": "{\"NotifyAddress\":\"https://**.**.**\"}",
        // 		"JobId": "61195f35cc7d4786a0bda02390cb4587"
        // 	}
        // }

        $params = $request->MessageBody ?? [];
        $params = Helper::arrayKeySnake($params);
        $jobId  = $params['job_id'] ?? '';
        if (!$jobId) {
            return;
        }
        $model = BatchMediaProducingJob::query()
            ->where('job_id', $jobId)
            ->first();
        if (!$model) {
            $model = new BatchMediaProducingJob();
            $model->forceFill($params);
            $model->user_id      = $model->user_data['user_id'] ?? "";
            $model->client_token = $model->user_data['client_token'] ?? "";
            $model->save();
        }
        SyncBatchMediaProducingJob::dispatch(['user_id' => $model->user_id, 'job_id' => $model->job_id]);
    }

    private function produceMediaComplete(Request $request)
    {
        // {
        //   "EventType": "ProduceMediaComplete",
        //   "UserId": 183320223000****,
        //   "EventTime": "2022-07-13T10:49:45Z",
        //   "MessageBody": {
        //     "Status": "Success",
        //     "MediaURL": "https://your-bucket.oss-cn-shanghai.aliyuncs.com/xxxxx.mp4",
        //     "MediaId": "1d1cbbc46da24edd9cf11ba5d193****",
        //     "ProjectId": "aded28bac782446a8e5a7cf86b67****",
        //     "ErrorCode": "",
        //     "ErrorMessage": "",
        //     "JobId": "8bc08c859569446ca5303ea903ca****",
        //     "UserData": "{\"NotifyAddress\":\"http://xx.xx.xxx\"}"
        //   }
        // }

        $params = $request->MessageBody ?? [];
        $params = Helper::arrayKeySnake($params);
        $jobId  = $params['job_id'] ?? '';
        if (!$jobId) {
            return;
        }

        $model = MediaProducingJob::query()
            ->where('job_id', $jobId)
            ->first();
        if (!$model) {
            $model = new MediaProducingJob();
            $model->forceFill($params);
            $model->user_id = $model->user_data['user_id'] ?? "";
            $model->client_token = $model->user_data['client_token'] ?? "";
            $model->save();
        }
        // Log::info($model->user_id);
        // event(new ProduceMediaComplete($params, $model->user_id));
        SyncMediaProducingJob::dispatch(['user_id' => $model->user_id, 'job_id' => $model->job_id, 'params' => $params]);
    }
}
