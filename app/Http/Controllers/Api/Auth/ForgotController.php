<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendForgotToken;
use App\Models\User;
use Illuminate\Http\Request; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
class ForgotController extends Controller
{
   public function forgotPass(Request $request)
   {
     $user =  User::where('email', $request->email)->first(); 
       if($user){   
            DB::table('password_resets')->where('email', $request->email)->delete(); 
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => Str::random(30),
                'created_at' =>  Carbon::now()->addHours()
            ]); 
            $tokenData = DB::table('password_resets')->where('email', $request->email)->first();  
            Mail::to($user)->send(new SendForgotToken($tokenData)); 
            return response()->json([
                        'success' => true,
                        'id' => $user->id,
                        'message' => [
                            'email' => [
                                "Please check your email for more info.",
                            ],
                        ],
                    ], 200); 
            }else{
                return response()->json([
                            'success' => false,
                            'errors' => [
                                'email' => [
                                    "We could not find a user with that email address.",
                                ],
                            ],
                        ], 404);
                }
   }
 
   public function verify(Request $request)
   { 

    if($request->has('user_id')){
         $user = User::where('id', $request->user_id)->first();
  
           $token =  DB::table('password_resets')->where('email', $user->email)->where('token',$request->token)->first();
       if($user && $token){
                return response()->json([
                    'success' => true,
                    'token' => $token->token,
                    'message' => [
                        'verify' => [
                            "Verify Success",
                        ],
                    ],
                ], 200);
         }
         return response()->json([
                    'success' => false,
                    'errors' => [
                        'token' => [
                            "Token not match or expaire! please try again.",
                        ],
                    ],
                ], 404);
    }
   

       
   }
   public function changePassword(Request $request)
   {  
      $rules = array( 
            'password' => 'required', 'min:8', 'confirmed',  
        );
        $validator = Validator::make($request->all(), (array)$rules);
        
        if (!$validator->fails()) {
            if($request->has('user_id') && $request->has('token')){
                $user = User::where('id', $request->user_id)->first(); 
                $token =  DB::table('password_resets')->where('email', $user->email)->where('token',$request->token)->where('created_at', '>=', Carbon::now())->first();
                if($token){
                    if( ! Hash::check($request->password, $user->password) ){ 
                    $user->password = Hash::make($request->password); 
                    $user->save();
                    DB::table('password_resets')->where('email', $user->email)->delete(); 
                    return response()->json([
                        'success' => true, 
                    ], 200);
                    
                    } else{
                          return response()->json([
                            'success' => false,
                            'errors' => [
                                'token' => [
                                    "Your tried with your before password! please enter new password.",
                                ],
                            ],
                        ], 404);
                    }
                }else{
                    return response()->json([
                    'success' => false,
                    'errors' => [
                        'token' => [
                            "Token is expaire! please try again.",
                        ],
                    ],
                ], 404);
                }
            }  
        }

        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422);
 
   }
}
