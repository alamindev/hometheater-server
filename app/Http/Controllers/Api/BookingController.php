<?php

namespace App\Http\Controllers\Api;

use App\Helpers\General\CollectionHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingDetailsResource;
use App\Http\Resources\BookingEditResource;
use App\Http\Resources\RecentBookingResource;
use App\Mail\AdminStatus;
use App\Models\Order;
use App\Models\OrderDate;
use App\Models\OrderImage;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class BookingController extends Controller
{

    public function Bookings($id)
    {
        if ($id) {
            $bookings = Order::with('quantity')->where('user_id', $id)->latest()->get();
            $bookings = RecentBookingResource::collection($bookings);
            $collection = collect($bookings);
            $total = $collection->count();
            $pageSize = 10;
            $bookings = CollectionHelper::paginate($collection, $total, $pageSize);
            return response()->json([
                'success' => true,
                'bookings' => $bookings,
            ], 200);
        }
        return response()->json([
            'success' => false,
        ], 200);
    }



    public function EditBooking($id)
    {
        $order = Order::with('images', 'orderdate', 'services')->where('id', $id)->first();
        return response()->json([
            'success' => true,
            'booking' => new BookingEditResource($order),
        ], 200);
    }
    public function UpdateBooking(Request $request)
    {
        if (count($request->datetime) > 0) {
            $orderdates = OrderDate::where('order_id', $request->id)->get();
            foreach ($orderdates as $key => $date) {
                $datetime = collect($request->datetime)[$key];
                $d =  OrderDate::where('id', $date->id)->first();
                $d->date = $datetime['date'];
                $d->time = $datetime['time'];
                $d->save();
            }
            $setting = Setting::first();
            $orderfetch = Order::where('id', $request->id)->with('services', 'orderdate')->first();
            $user = User::where('id', $orderfetch->user_id)->first();
            if ($setting) {
                Mail::to($setting->contact_email)->send(new AdminStatus($orderfetch, $user, true));
            }
        }
        if (count($request->image_ids) > 0) {
            $delete_images =   OrderImage::where('order_id', $request->id)->whereNotIn('id', $request->image_ids)->get();
            foreach ($delete_images as $image) {
                $path = public_path($image->image);
                if (\File::exists($path)) {
                    \File::delete($path);
                }
                OrderImage::find($image->id)->delete();
            }
        }

        if (count($request->new_images) > 0) {
            $images = collect($request->new_images);
            foreach ($images as $img) {
                $order_image = OrderImage::where("id", $img['id'])->first();
                if (!empty($order_image)) {
                    $path = public_path($order_image->image);
                    if (\File::exists($path)) {
                        \File::delete($path);
                    }
                }
                $image_parts = explode(";base64,", $img['src']);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $random = Str::random('20') . time();
                $name = $random . '.' . $image_type;
                $image = Image::make($image_base64);
                $folder = public_path('uploads/users/' . $request->user_id);
                if (!\File::exists($folder)) {
                    \File::makeDirectory($folder, 0775, true, true);
                }
                $image->save('uploads/users/' . $request->user_id . '/' . $name, 60);
                if (!empty($order_image)) {
                    $img =   OrderImage::find($order_image->id);
                } else {
                    $img = new OrderImage();
                }
                $img->order_id = $request->id;
                $img->image = "uploads/users/$request->user_id/$name";
                $img->save();
            }
        }

        return response()->json([
            'success' => true,
        ], 200);
    }

    public function BookingDetails(Request $request, $id)
    {
        if ($request->has('auth_id')) {
            $order = Order::with('quantity', 'services', 'images', 'questions', 'orderdate')->where('user_id', $request->auth_id)->where('id', $id)->first();
            if ($order) {
                return response()->json([
                    'success' => true,
                    'booking' => new BookingDetailsResource($order),
                ], 200);
            }
            return response()->json([
                'success' => false,
            ], 404);
        }
        return response()->json([
            'success' => false,
        ], 404);
    }
    public function Canceled(Request $request)
    {
        $order = Order::with('quantity', 'services', 'images', 'questions', 'orderdate')->where('id', $request->id)->where('user_id', $request->user_id)->first();
        $order->status = 'cancel';
        $order->save();
        return response()->json([
            'success' => true,
            'booking' => new BookingDetailsResource($order),
        ], 200);
    }
    public function delete(Request $request)
    {  
        $order = Order::where('id', $request->id)->first();
        if ($order) {
            $delete_images =   OrderImage::where('order_id', $order->id)->get();
            foreach ($delete_images as $image) {
                $path = public_path($image->image);
                if (\File::exists($path)) {
                    \File::delete($path);
                }
                OrderImage::find($image->id)->delete();
            }
            $order->delete();

            return response()->json([
                'success' => true,
            ], 200);
        }
        return response()->json([
            'success' => false,
        ], 200);
    }
}