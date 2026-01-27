<?php

namespace App\Extensions;

class ClientToken
{
    public function verify($data, $secret, $stKey = 'st')
    {
        ksort($data);
        // token
        if (!$data[$stKey]) {
            return false;
        }
        // timestamps
        if (!$data['ts']) {
            return false;
        }
        if (config('app.debug') === false) {
            // timestamps
            if ($data['ts'] > time() + 600 || $data['ts'] < time() - 600) {
                // return false;
            }
        }
        $st = $data[$stKey];
        unset($data[$stKey]);

        $str = '';

        foreach ($data as $k => $v) {
            $str .= "{$k}=$v&";
        }

        $md5str = md5($str . 'secret=' . $secret);

       // dd($st, $md5str, $str);
        if (strcmp($st, $md5str) !== 0) {
            return false;
        }
        return true;
    }
}
