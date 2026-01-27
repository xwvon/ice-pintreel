<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class BaseModel extends Model
{
    // 覆盖 toArray 方法，自动添加 id
    public function toArray()
    {
        $array = parent::toArray();
        // 添加 id, 使用array_merge使其添加在最前面
        $array = array_merge(['id' => $this->getIdAttribute()], $array);
        unset($array['_id']);
        return $array;
    }
}
