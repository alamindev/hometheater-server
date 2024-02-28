<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AdminStatus;
use App\Mail\PaymentStatus;
use App\Mail\UserNotification;
use App\Models\Order;
use App\Models\OrderDate;
use App\Models\OrderImage;
use App\Models\OrderQuantity;
use App\Models\OrderQuestion;
use App\Models\OrderService;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Mail;
use Nikolag\Square\Facades\Square;

class OrderController extends Controller
{
    public function finishedCheckout(Request $request)
    {

        $today = date("Ymd");
        $rand = strtoupper(substr(uniqid(sha1(time())), 0, 4));
        $unique = $today . $rand;
        $carts = collect($request->carts);
        if ($request->payment === 'online') {
            $price = '';
            if (!empty($request->total_price)) {
                $price = $request->total_price;
            } else {
                $price = $carts->pluck('price')->sum();
            }
            $note = '';
            foreach ($carts as $cart) {
                $note .= $cart['title'] . ', ';
            }

            try {
                Square::charge([
                    'amount' => $price * 100,
                    'source_id' => $request->nonce,
                    'currency' => "USD",
					'location_id' => 'FB06VFK9D72CK',
                    'note' => $note,
                ]);

                $user = User::where('id', $request->user_id)->first();
                Mail::to($user)->send(new PaymentStatus($carts, $price, $user));
            } catch (\Exception $e) {
                // if ($e->getCode() === 500) {
                //     return response()->json([
                //         'success' => false,
                //         'message' => 'Server Error. Please try again'
                //     ], 200);
                // }  elseif ($e->getCode() === 400) {
                //     return response()->json([
                //         'success' => false,
                //         'message' => 'There is an error with you card. Please try another card!'
                //     ], 200);
                // }elseif ($e->getCode() === 401) {
                //     return response()->json([
                //         'success' => false,
                //         'message' => 'Token expaire. Please try again'
                //     ], 200);
                // } elseif ($e->getCode() === 503) {
                //     return response()->json([
                //         'success' => false,
                //         'message' => 'Service Unavailable. Please try again'
                //     ], 200);
                // } else {
                    return response()->json([
                        'success' => false,
                        'message' => $e->getMessage()
                    ], 200);
                // }
            }
        }

        $order = new Order();
        $order->order_id = $unique;
        if (!empty($request->total_price)) {
            $order->price = $request->total_price;
        } else {
            $order->price = $carts->pluck('price')->sum();
        }
        $order->sub_total = $request->sub_total;
        $order->discount = $request->discount;
        $order->discount_price = $request->discount_price;
        $order->addon_price = $request->addon_price;
        $order->payment = $request->payment;
        $order->user_id = $request->user_id;
        $order->save();

        foreach ($carts as $cart) {
            $item = new OrderQuantity();
            $item->quantity = $cart['item'];
            $item->order_id = $order->id;
            $item->service_id = $cart['id'];
            $item->save();

            $service = new OrderService();
            $service->order_id = $order->id;
            $service->service_id = $cart['id'];
            $service->save();
        }

        if (count($request->answer) > 0) {
            $answers = collect($request->answer);
            foreach ($answers as $ans) {
                $answer = new OrderQuestion();
                $answer->order_id = $order->id;
                $answer->service_id = $ans['service_id'];
                $answer->question_id = $ans['question_id'];
                $answer->option_id = $ans['option_id'];
                $answer->service_title = $ans['service_title'];
                $answer->save();
            }
        }
        if (count($request->datetime) > 0) {
            $datetime = collect($request->datetime);
            foreach ($datetime as $dt) {
                $d = new OrderDate();
                $d->date = $dt['date'];
                $d->time = $dt['time'];
                $d->order_id = $order->id;
                $d->save();
            }
        }
        
        if (count($request->images) > 0) {
            $images = collect($request->images);
            foreach ($images as $img) {
                $image_parts = explode(";base64,", $img['data']);
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
                $image->save('uploads/users/' . $request->user_id . '/' . $name, 30);
                $img = new OrderImage();
                $img->order_id = $order->id;
                $img->image = "uploads/users/$request->user_id/$name";
                $img->save();
            }
        }

        $user = User::where('id', $request->user_id)->first();



        $setting = Setting::first();
        $orderfetch = Order::where('id', $order->id)->with('services', 'orderdate')->first();
        if ($setting) {
           Mail::to($setting->contact_email)->send(new AdminStatus($orderfetch, $user,  false));
        }
        Mail::to($user)->send(new UserNotification($orderfetch, $user));



        return response()->json([
            'success' => true,
        ], 200);
    }
}
