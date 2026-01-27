<?php

namespace App\Models;

use App\Helper;
use App\Models\BaseModel as Model;
use App\Models\Traits\DatetimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use MongoDB\BSON\UTCDateTime;

class BatchMediaProducingJob extends Model
{
    use HasFactory, DatetimeTrait;

    protected $dates = [
        'complete_time',
        'create_time',
        'modified_time',
    ];
    protected $fillable = [
        'user_id',
        'job_id',
        'client_token',
        'input_config',
        'output_config',
        'editing_config',
        'status',
        'user_data',
        'extend',
        'sub_job_list',
        'job_type',
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

    public function setInputConfigAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        $value                            = Helper::arrayKeySnake($value);
        $this->attributes['input_config'] = $value;
    }

    public function setOutputConfigAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        $value                             = Helper::arrayKeySnake($value);
        $this->attributes['output_config'] = $value;
    }

    public function setEditingConfigAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        $value                              = Helper::arrayKeySnake($value);
        $this->attributes['editing_config'] = $value;
    }

    public function setCompleteTimeAttribute($value)
    {
        // convert to mongodb datetime
        $this->attributes['complete_time'] = new UTCDateTime(strtotime($value) * 1000);
    }

    public function setCreateTimeAttribute($value)
    {
        // convert to mongodb datetime
        $this->attributes['create_time'] = new UTCDateTime(strtotime($value) * 1000);
    }

    public function setModifiedTimeAttribute($value)
    {
        // convert to mongodb datetime
        $this->attributes['modified_time'] = new UTCDateTime(strtotime($value) * 1000);
    }

    public function setExtendAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        $value                      = Helper::arrayKeySnake($value);
        $this->attributes['extend'] = $value;
    }

    public function setUserDataAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        $value                      = Helper::arrayKeySnake($value);
        $this->attributes['user_data'] = $value;
    }

    public function getDataForSubmit(): array
    {
        $data = $this->toArray();
        $data = Helper::arrayKeyCamelForAliyun($data);

        return $data;
    }
}
