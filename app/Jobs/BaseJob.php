<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;

class BaseJob
{
    protected $params = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->params = $params;
    }

    protected function error($code, $message)
    {
        Log::error($message, ['code' => $code]);
        return true;
    }

    protected function success($data = [])
    {
        Log::info('success', ['params' => $this->params]);
        return true;
    }
}
