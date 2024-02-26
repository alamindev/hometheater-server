<?php

namespace App\Http\Controllers\api\Auth;

use App\Models\User;
use App\Models\UserSocial;
use Socialite;
use App\Http\Controllers\Controller;
use App\Models\SocialUser;
use Tymon\JWTAuth\JWTAuth;

class SocialLoginController extends Controller
{
    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
        $this->middleware(['social', 'web']);
    }

    public function redirect($service)
    {
        return Socialite::driver($service)->redirect();
    }

    public function callback($service)
    {
        try {
            $serviceUser = Socialite::driver($service)->scopes(['profile','email'])->user();
        } catch (\Exception $e) {
            return redirect('https://hometheaterproz.com/auth/social-callback?error=Unable to login using ' . $service . '. Please try again' . '&origin=login');
        }

        if ($serviceUser->getEmail()) {
            $email = $serviceUser->getEmail();
        } else {
            $email = $serviceUser->getId() . '@' . $service . '.local';
        }

        $user =  User::where('email', $email)->first();
        $newUser = false;
        if (!$user) {
            $newUser = true;
            $user = User::create([
                'first_name' => $serviceUser->getName(),
                'email' => $email,
                'photo' => $serviceUser->getAvatar(),
                'password' => ''
            ]);
        }


        if ($this->needsToCreateSocial($user, $service)) {
            SocialUser::create([
                'user_id' => $user->id,
                'social_id' => $serviceUser->getId(),
                'service' => $service
            ]);
        }
		return 'alain';
        return redirect('https://hometheaterproz.com/auth/social-callback?token=' . $this->auth->fromUser($user) . '&origin=' . ($newUser ? 'register' : 'login'))->scopes(['profile','email']);
    }

    public function needsToCreateSocial(User $user, $service)
    {
        return !$user->hasSocialLinked($service);
    }
}
