<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PublicUserResource;
use App\Models\Order;
use App\Models\OrderImage;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function Profile($id)
    {
        $user = User::with('comments', 'likes', 'reviews')->find($id);
        if ($user) {
            return response()->json([
                'success' => true,
                'user' => new PublicUserResource($user),
            ], 200);
        }
        return response()->json([
            'success' => false,
            'errors' => 'user not found',
        ], 422);
    }
    public function Delete(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $ids = Order::where('user_id', $user->id)->pluck('id');
            if (count($ids) > 0) {
                $delete_images =   OrderImage::whereIn('order_id', $ids)->get();
                foreach ($delete_images as $image) {
                    $path = public_path($image->image);
                    if (\File::exists($path)) {
                        \File::delete($path);
                    }
                }
            }
            $user->delete();
            return response()->json([
                'success' => true,
            ], 200);
        }
        return response()->json([
            'success' => false,
        ], 200);
    }
}