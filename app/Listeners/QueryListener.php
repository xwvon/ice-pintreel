<?php

namespace App\Listeners;

use DateTime;
use Exception;
use Illuminate\Support\Facades\Log;

class QueryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        try {
            if (config('app.debug')) {
                $sql = str_replace('%', '%%', $event->sql);
                $sql = str_replace("?", "'%s'", $sql);

                foreach ($event->bindings as $i => $binding) {
                    if ($binding instanceof DateTime) {
                        $event->bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                    } else {
                        if (is_string($binding)) {
                            $event->bindings[$i] = $binding;
                        }
                    }
                }
                if ($event->bindings) {
                    $log = vsprintf($sql, $event->bindings);
                } else {
                    $log = $sql;
                }
                $log = $log . '  [ RunTime:' . $event->time . 'ms ] ';

                if (strpos($sql, 'rbac_') !== false) {
                    Log::channel('rbac')->info($log);
                } else {
                    Log::channel('sql')->info($log);
                }
            }
        } catch (Exception $exception) {

        }
    }
}
