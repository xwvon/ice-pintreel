<?php

namespace App\Providers;

use App\Extensions\ClientToken;
use App\Models\User;
use App\Models\UserCenterClient;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::viaRequest('custom-token', function (Request $request) {
            $user = $this->token($request);
            if ($user) {
                return $user;
            }
        });
    }

    private function token(Request $request)
    {
        try {

            $token      = $request->header('token', $request->post('token', ''));
            if (!$token) {
                return null;
            }
            $headers = [
                'token'    => $token,
            ];
            $client = new Client([
                                     'base_uri' => env('PENGTOUR_API_URL'),
                                     'timeout'  => 5,
                                     'headers'  => $headers,
                                 ]);

            $res = $client->get('/api/v1/auth/token/check');
            if ($res->getStatusCode() !== 200) {
                return null;
            }
            $str = $res->getBody()->getContents();
            if (!$str) {
                return null;
            }
            $data = json_decode($str, true);

            if (!isset($data['code']) || $data['code'] !== 1) {
                return null;
            }
            // return User::where('username', $username)->first();
            return User::firstOrcreate(['username' => $data['data']['user_info']['username']]);
        } catch (Exception $e) {
            throw $e;
        }

        return null;
    }

}
