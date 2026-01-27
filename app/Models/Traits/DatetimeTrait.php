<?php

namespace App\Models\Traits;

trait DatetimeTrait
{

    //    protected function serializeDate(\DateTimeInterface $date)
//    {
//        return \Carbon\Carbon::instance($date)->toISOString(true);
//    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
