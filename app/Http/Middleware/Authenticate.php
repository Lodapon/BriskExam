<?php

namespace App\Http\Middleware;

use App\Http\Utils\SecureUtil;
use Closure;
use Exception;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\SignUpController;
use RealRashid\SweetAlert\Facades\Alert;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(request()->session()->get('user', '')){
            return $next($request);
        }
        $username = $request['usr'];
        $password = $request['pwd'];

        Log::debug("Authenicating with ". $username);

        try {
            $user_account = DB::selectOne('select distinct * from user_account where email = ?', [$username]);
            $hashLv2 = SecureUtil::hashing(array($user_account->username, $password, $user_account->salt));

            if($hashLv2 == $user_account->password) {
                Log::debug("password matched");

                if ($user_account->role == "S") {
                    session()->put("admin", true);
                    return redirect('/admin');
                }
                    $user_account->password = null;
                    $user_account->salt = null;
                    session()->put("user", $user_account);

                    $profile = DB::selectOne('select distinct * from user_profile where account_id = ?', [$user_account->account_id]);
                    session()->put("profile", $profile);


                    // Alert::success('Hello');
                    return $next($request);
                // } else {
                //     return redirect('/')->with('message', 'Waiting for approval, Please contact administrator.');
                // }

            } else {
                Log::error("password mismatched");
                return redirect()->action([SignUpController::class, 'signUpErr']);
            }

        } catch (Exception $e) {
            Log::error("can't find user_account");
            return redirect()->action([SignUpController::class, 'signUpErr']);
        }
    }

}
