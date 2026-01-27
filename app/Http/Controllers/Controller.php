<?php

namespace App\Http\Controllers;

use App\Libraries\JsonResponse as J;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

//    public function success($data = [], $message = 'ok', $status = 200, array $headers = [], $options = 0)
//    {
//        $json = [
//            'message' => $message,
//            'code' => $status * 100,
//            'data' => $data
//        ];
//        return response()->json($json, $status, $headers, $options);
//    }

    /**
     * 快捷访问
     *
     * @var J
     */
    protected $j;

    public function __construct()
    {
        $this->j = app()->j;
    }

    public function page(LengthAwarePaginator $page)
    {
        $data = [
            'items'        => $page->items(),
            'total'        => $page->total(),
            'per_page'     => $page->perPage(),
            'current_page' => $page->currentPage(),
            'from'         => $page->firstItem(),
            'last_page'    => $page->lastPage(),
            'to'           => $page->lastItem(),
        ];
        return $this->success(['page' => $data]);
    }

    public function itemPage($item ,LengthAwarePaginator $page)
    {
        $data = [
            'items'        => $item,
            'total'        => $page->total(),
            'per_page'     => $page->perPage(),
            'current_page' => $page->currentPage(),
            'from'         => $page->firstItem(),
            'last_page'    => $page->lastPage(),
            'to'           => $page->lastItem(),
        ];
        return $this->success(['page' => $data]);
    }

    /**
     * @param array $data
     * @param int $code
     * @param string $msg
     *
     * @return JsonResponse
     * @author liuchunhua<448455556@qq.com>
     * @date   2021/3/31
     */
    protected function success(array $data = [], string $msg = J::MSG_SUCCESS, int $code = J::CODE_SUCCESS): JsonResponse
    {
        $this->j->code    = $code;
        $this->j->message = $msg;
        $this->j->data    = $data;
        return response()->json($this->j);
    }

    /**
     * @param int $code
     * @param string $msg
     *
     * @return JsonResponse
     * @author liuchunhua<448455556@qq.com>
     * @date   2021/3/31
     */
    protected function error(int $code = J::CODE_ERROR, string $msg = J::MSG_ERROR): JsonResponse
    {
        $this->j->code    = $code;
        $this->j->message = $msg;
        return response()->json($this->j);
    }
}
