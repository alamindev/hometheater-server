<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '';

    protected $auth;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
       $user =  User::where('email', $request->email)->first();
       if($user){
        if ( $user->status !== 0) {

            if ($this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);

                return response()->json([
                    'success' => false,
                    'errors' => [
                        "You've been locked out",
                    ],
                ]);
            }

            $this->incrementLoginAttempts($request);

            // attempt login with token
            if ($request->input('token')) {
                $this->auth->setToken($request->input('token'));

                $user = $this->auth->authenticate();
                if ($user) {
                    return response()->json([
                        'success' => true,
                        'data' => $request->user(),
                        'token' => $request->input('token'),
                    ], 200);
                }
            }

            try {
                if (!$token = $this->auth->attempt($request->only('email', 'password'))) {
                    return response()->json([
                        'success' => false,
                        'errors' => [
                            'email' => [
                                "Invalid email address or password",
                            ],
                        ],
                    ], 422);
                }
            } catch (JWTException $e) {
                return response()->json([
                    'success' => false,
                    'errors' => [
                        'email' => [
                            "Invalid email address or password",
                        ],
                    ],
                ], 422);
            }

            return response()->json([
                'success' => true,
                'data' => $request->user(),
                'token' => $token,
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'errors' => [
                    'email' => [
                        "Your account is disabled",
                    ],
                ],
            ], 422);
        }
        }else{
         return response()->json([
                    'success' => false,
                    'errors' => [
                        'email' => [
                            "User not found! Please register and try again",
                        ],
                    ],
                ], 404);
        }
    }

}
