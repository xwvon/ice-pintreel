<?php
/**
 * @author    liuchunhua<448455556@qq.com>
 * @date      2021/3/30
 * @copyright Canton Univideo
 */

namespace App\Http\Controllers;


use App\Libraries\JsonResponse as J;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class ApiBaseController extends Controller
{

    /**
     * Get the token array structure.
     *
     * @param string $token
     * @param int $code
     * @param string $message
     *
     * @return JsonResponse
     * @throws AuthenticationException
     */
    protected function respondWithToken(string $token, int $code = J::CODE_SUCCESS, string $message = J::MSG_SUCCESS): JsonResponse
    {
        /* @var User $user */
        $user = auth()->user();

        if (!$user) {
            throw new AuthenticationException("未登录");
        }

        $data = [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
        ];
        Event::dispatch(new Login('api', $user, false));
        return $this->success($data, $message, $code);
    }
}
