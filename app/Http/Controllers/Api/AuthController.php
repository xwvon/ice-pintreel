<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiBaseController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->middleware('auth:api', ['except' => ['login', 'status']]);
    // }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function login()
    {
        $credentials = request(['username', 'password']);

        // $user = new Admin(['username' => $credentials['username'], 'password' => Hash::make($credentials['password'])]);
        // $user->save();
        if (!$token = auth()->attempt($credentials)) {
            throw new AuthenticationException('login failed.');
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        $tmp = [
            "username"    => Auth::user()->username,
            "name"        => Auth::user()->name,
            "permissions" => [
                "role" => "admin",
            ],
            "avatar"      => "",
        ];
        return $this->success(['user' => $tmp]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return $this->success(['message' => 'Successfully logged out']);
    }


    public function status()
    {
        return $this->success();
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

}
