<?php

namespace App\Models;

use App\Helper;
use App\Models\BaseModel as Model;
use App\Models\Traits\DatetimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Template extends Model
{
    use HasFactory, DatetimeTrait;

    protected $fillable = [
        'name',
        'type',
        'config',
        'cover_url',
        'preview_media',
        'status',
        'source',
        'related_mediaids',
    ];

    public function getDataForAddTemplate()
    {
        $data = $this->toArray();
        unset($data['id'], $data['created_at'], $data['updated_at']);
        $data = Helper::arrayKeyCamelForAliyun($data);

        return $data;
    }

    public function setConfigAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        $value                      = Helper::arrayKeySnake($value);
        $this->attributes['config'] = $value;
    }

    public function setClipsParamAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        $value                           = Helper::arrayKeySnake($value);
        $this->attributes['clips_param'] = $value;
    }

    public function getClipsParamAttribute()
    {
        if (!empty($this->attributes['clips_param'])) {
            return $this->attributes['clips_param'];
        }
        $config = $this->config;

    }

    private function getClipsParamByConfig($config)
    {
        $clipsParam = [];

        foreach ($config as $item) {

        }
    }
}
