<?php

namespace App\Models;

use App\Helper;
use App\Models\BaseModel as Model;
use App\Models\Traits\DatetimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use stdClass;

class MediaProducingJob extends Model
{
    use HasFactory, DatetimeTrait;

    protected $fillable = [
        "user_id",
        "client_token",
        "project_id",
        "timeline",
        "template_id",
        "clips_param",
        "project_metadata",
        "output_media_target",
        "output_media_config",
        "user_data",
        "editing_produce_config",
        "media_metadata",
        "project_id",
        "job_id",
        "media_id",
        "vod_media_id",
    ];

    public function __construct($attributes = [])
    {
        if (!isset($attributes['client_token'])) {
            $attributes['client_token'] = Str::uuid()->toString();
        }
        if (!isset($attributes['job_id'])) {
            $attributes['job_id'] = null;
        }
        parent::__construct($attributes);
    }
    public function getDataForSubmit()
    {
        $data = $this->toArray();
        unset($data['created_at'], $data['updated_at'], $data['id']);
        $data = Helper::arrayKeyCamelForAliyun($data);

        return $data;
    }

    public function setUserDataAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        $value                         = Helper::arrayKeySnake($value);
        $this->attributes['user_data'] = $value;
    }

    public function setClipsParamAttribute($value)
    {
        if ($value === 'null') {
            $value                           = new stdClass();
            $this->attributes['clips_param'] = $value;
            return;
        }
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        $value                           = Helper::arrayKeySnake($value);
        $this->attributes['clips_param'] = $value;
    }

    public function setTimelineAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        $value                        = Helper::arrayKeySnake($value);
        $this->attributes['timeline'] = $value;
    }

    public function setSubJobMaterialsAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        $value                                  = Helper::arrayKeySnake($value);
        $this->attributes['sub_job_materials'] = $value;
    }
}
