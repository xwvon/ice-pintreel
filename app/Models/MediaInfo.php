<?php

namespace App\Models;

use App\Helper;
use App\Models\BaseModel as Model;
use App\Models\Traits\DatetimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class MediaInfo extends Model
{
    use HasFactory, DatetimeTrait;

    protected $fillable = [
        'media_basic_info',
        'client_token',
    ];

    public function __construct(array $attributes = [])
    {
        if (empty($attributes['client_token'])) {
            $this->client_token = Str::uuid()->toString();
        }
        parent::__construct($attributes);
    }

    public function getDataForRegister()
    {
        $data                 = $this->media_basic_info;
        $data['client_token'] = $this->client_token;

        $data             = Helper::arrayKeyCamelForAliyun($data);
        $data['inputURL'] = $data['inputUrl'];
        $data['coverURL'] = $data['coverUrl'] ?? "";
        $data['userData'] = json_encode(Helper::arrayKeyCamel($this->user_data));
        unset($data['inputUrl'], $data['coverUrl']);
        return $data;
    }

    public function setMediaIdAttribute($value)
    {
        $this->attributes['media_id'] = $value;
        $this->media_basic_info       = ['media_id' => $value];
    }

    public function getMediaBasicInfoAttribute()
    {
        return $this->attributes['media_basic_info'] ?? [];
    }

    public function setMediaBasicInfoAttribute(array $value)
    {
        $info = $this->media_basic_info;
        $info = array_merge($info, $value);

        if (isset($info['user_data']) && is_string($info['user_data'])) {
            $info['user_data'] = json_decode($info['user_data'], true);
            $info['user_data'] = Helper::arrayKeySnake($info['user_data']);
        }

        if (isset($info['snapshots']) && is_string($info['snapshots'])) {
            $info['snapshots'] = json_decode($info['snapshots'], true);
            $info['snapshots'] = Helper::arrayKeySnake($info['snapshots']);
        }

        if (isset($info['sprite_images']) && is_string($info['sprite_images'])) {
            $info['sprite_images'] = json_decode($info['sprite_images'], true);
            $info['sprite_images'] = Helper::arrayKeySnake($info['sprite_images']);

            foreach ($info['sprite_images'] as &$image) {
                if (isset($image['config']) && is_string($image['config'])) {
                    $image['config'] = json_decode($image['config'], true);
                    $image['config'] = Helper::arrayKeySnake($image['config']);
                }
            }
        }
        $this->attributes['media_basic_info'] = $info;
    }
}
