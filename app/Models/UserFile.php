<?php

namespace App\Models;

use App\Models\Traits\DatetimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel as Model;

class UserFile extends Model
{
    use HasFactory, DatetimeTrait;

    protected $fillable = [
        'user_id',
        'name',
        'disk',
        'path',
        'type',
        'ext',
        'size',
        'mime',
        'labels',
        'payload',
    ];

    public function setLabelsAttribute($value)
    {
        $this->attributes['labels'] = implode(',', $value);
    }

    public function getLabelsAttribute($value)
    {
        return explode(',', $value);
    }
}
