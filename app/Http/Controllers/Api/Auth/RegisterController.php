<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Tymon\JWTAuth\JWTAuth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'city' => 'required',
            'state' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required', 'min:8', 'confirmed',
            'zipcode' => 'required|regex:/\b\d{5}\b/',
        );
        $validator = Validator::make($request->all(), (array)$rules);

        if (!$validator->fails()) {

            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->address = $request->address;
            $user->phone = $request->phone;
            $user->city = $request->city;
            $user->state = $request->state;
            $user->email = $request->email;
            $user->zipcode = $request->zipcode;
            $user->password = Hash::make($request->password);
            $user->save();
            $token = $this->auth->attempt($request->only('email', 'password'));

            return response()->json([
                'success' => true,
                'id' => $user->id,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422);
    }
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkFields($user_id)
    {
        $user =  User::where('id', $user_id)->where('phone', '!=', '')
            ->where('first_name', '!=', '')
            ->where('address', '!=', '')
            ->where('zipcode', '!=', '')
            ->where('city', '!=', '')
            ->first();
        if (!empty($user)) {
            return response()->json([
                'success' => true,
            ], 200);
        }
        return response()->json([
            'success' => false,
        ], 200);
    }
}