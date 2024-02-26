<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingUserResource;
use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display  user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function profile($id)
    {
        if (auth()->check()) {

            $user = User::with('social')->find($id);
            if ($user) {
                return response()->json([
                    'success' => true,
                    'user' => new SettingUserResource($user),
                ], 200);
            }
            return response()->json([
                'success' => false,
                'errors' => 'user not found',
            ], 422);
        }

        return response()->json([
            'success' => false,
            'errors' => 'Unauthinticate or Unauthorized',
        ], 401);
    }
    public function update(Request $request, $id)
    {
        if (auth()->check()) {
            $data = json_decode($request->data, true);

            $rules = array(
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'city' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'zipcode' => 'required|regex:/\b\d{5}\b/',
            );
            $validator = Validator::make($data, $rules);

            if (!$validator->fails()) {

                $user = User::find($id);
                $user->first_name = $data['first_name'];
                $user->last_name = $data['last_name'];
                $user->phone = $data['phone'];
                $user->email = $data['email'];
                $user->address = $data['address'];
                $user->city = $data['city'];
                $user->state = $data['state'];
                $user->zipcode = $data['zipcode'];
                $user->bio = $data['bio'];
                $user->is_appointment = $data['is_appointment'] === false ? 'sms' : 'email';
                $user->is_notification = $data['is_notification'] === false ? true : false;
                $social = SocialLink::find($user->id);
                if ($social) {
                    $user->social()->update([
                        'facebook' => $data['facebook'],
                        'twitter' => $data['twitter'],
                        'messenger' => $data['messenger'],
                        'instagram' => $data['instagram'],
                    ]);
                } else {
                    $user->social()->create([
                        'facebook' => $data['facebook'],
                        'twitter' => $data['twitter'],
                        'messenger' => $data['messenger'],
                        'instagram' => $data['instagram'],
                    ]);
                }

                $name = null;

                if ($request->has('photo') && $request->photo != 'null') {
                    $image_path = $user->photo;

                    if (\File::exists($image_path)) {
                        \File::delete($image_path);
                    }
                    $img = $request->file('photo');
                    $random = Str::random('20') . time();
                    $name = $random . '.' . $img->getClientOriginalExtension();
                    $image = Image::make($img);
                    $image->save('uploads/users/' . $name, 60);

                    if ($name) {
                        $user->photo = 'uploads/users/' . $name;
                    }
                }

                $user->save();

                return response()->json([
                    'success' => true,
                ], 200);
            }

            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
    }
    public function RequirdInfoUpdate(Request $request)
    {
        if (auth()->check()) {
            $rules = array(
                'first_name' => 'required',
                'city' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'state' => 'required',
                'zipcode' => 'required|regex:/\b\d{5}\b/',
            );
            $validator = Validator::make($request->all(), (array)$rules);

            if (!$validator->fails()) {

                $user = User::find($request->id);
                $user->first_name = $request->first_name;
                $user->phone = $request->phone;
                $user->address = $request->address;
                $user->city = $request->city;
                $user->state = $request->state;
                $user->zipcode = $request->zipcode;
                $user->save();

                return response()->json([
                    'success' => true,
                ], 200);
            }

            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
    }
    public function getRequirdInfo($id)
    {
        if (auth()->check()) {
            $user = User::where('id', $id)->select('first_name', 'phone', 'address', 'city', 'state', 'zipcode')->first();
            if ($user) {
                return response()->json([
                    'success' => true,
                    'user' => $user,
                ], 200);
            }
            return response()->json([
                'success' => false,
            ], 200);
        }
    }
}