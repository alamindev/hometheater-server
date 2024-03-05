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
use App\Models\Service;
use App\Models\OrderPrice;
use App\Models\OrderVarient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Charge; 

class OrderController extends Controller
{
    public function finishedCheckout(Request $request)
    {
 
        $carts = collect($request->carts); 

        $note = '';
        foreach ($carts as $cart) {
            $note .= $cart['title'] . ', ';
        }

        try {
            // Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            // $token = $request->token;
            // if (!is_null($token)) {
            //     $charge = Charge::create([
            //         'amount' => $request->grand_total * 100, // amount in cents
            //         'currency' => 'usd',
            //         'description' => $note,
            //         'source' => $token,
            //     ]); 
            //     $user = User::where('id', $request->user_id)->first();
            //     Mail::to($user)->send(new PaymentStatus($carts, $price, $user));
            // }

            $cartdatas = $request->cartdata;
            foreach($cartdatas as $key => $cartdata){
                if($key === 'services'){
                    if(count($cartdata) > 0){
                        $today = date("Ymd");
                        $rand = strtoupper(substr(uniqid(sha1(time())), 0, 2));
                        $unique = $today . $rand . strtoupper($key);
                        
                        $total = collect($cartdata)->pluck('price')->sum();
                        $addon_price = $request->addon_price;
    
                        $order = new Order();
                        $order->order_id = $unique; 
                        $order->price = $total;   
                        
                        if(!empty($request->discount)){
                            $order->discount = $request->discount; 
                            $discount = ($total + $addon_price) * ($order->discount / 100);
                            $order->discount_price = $discount;
                                
                        }
    
                        $order->addon_price =  $addon_price;
                        $order->payment = $request->payment;
                        if($order->payment === 'online'){
                            $order->taxes = $request->taxes;
                        }
                        $order->type = 0;
                        $order->user_id = $request->user_id;
                        $order->save(); 
                            foreach ($cartdata as $cart) {
                                $item = new OrderQuantity();
                                $item->quantity = $cart['item'];
                                $item->order_id = $order->id;
                                $item->service_id = $cart['id'];
                                $item->save();
                    
                                $item_price = new OrderPrice();
                                $item_price->item_price = $cart['price'];
                                $item_price->order_id = $order->id;
                                $item_price->service_id = $cart['id'];
                                $item_price->save();

                                $service = new OrderService();
                                $service->order_id = $order->id;
                                $service->service_id = $cart['id'];
                                $service->save();
                            }
                            Answer($request,  $order->id);
                            DateTime($request,  $order->id);
                            OrderImage($request,  $order->id);
    
                        } 
                }else{
                    if(count($cartdata) > 0){
                        $today = date("Ymd");
                        $rand = strtoupper(substr(uniqid(sha1(time())), 0, 2));
                        $unique = $today . $rand . strtoupper($key);
                        $total = collect($cartdata)->pluck('price')->sum();

                         $ids = collect($cartdata)->pluck('ids');  
                         $uniqueIds = collect($ids)->flatten()->unique();    
                         $delivery_time = Service::whereIn('id', $uniqueIds)->avg('delivery_time');
                        $startDate =  Carbon::now();

                        $date = $startDate->copy()->addDays(round($delivery_time))->format('d M y - h:i:s A');
                        
                        $order = new Order();
                        $order->order_id = $unique; 
                        $order->price = $total; 
                        
                        if(!empty($request->discount)){
                            $order->discount = $request->discount; 
                            $discount = $total * ($order->discount / 100);
                            $order->discount_price = $discount ;
                        }
    
                        $order->user_id = $request->user_id;
                        $order->delivery_time = $date;
                        $order->payment = 'online';
                        $order->type = 1;
                        $order->taxes = $request->taxes;
                        $order->save();
    
                            foreach ($cartdata as $cart) {
                                $item = new OrderQuantity();
                                $item->quantity = $cart['item'];
                                $item->order_id = $order->id;
                                $item->service_id = $cart['id'];
                                $item->save();
                                
                                $item_price = new OrderPrice();
                                $item_price->item_price = $cart['price'];
                                $item_price->order_id = $order->id;
                                $item_price->service_id = $cart['id'];
                                $item_price->save();

                                if($cart['varient'] !== false){
                                    $varients = new OrderVarient();
                                    $varients->name = $cart['varient']['name'];
                                    $varients->value = $cart['varient']['value'];
                                    $varients->order_id = $order->id;
                                    $varients->service_id = $cart['id'];
                                    $varients->save();
                                }
                                $service = new OrderService();
                                $service->order_id = $order->id;
                                $service->service_id = $cart['id'];
                                $service->save();
                            }  
                    }
                }
            }  
            $user = User::where('id', $request->user_id)->first();
     
    
            // $setting = Setting::first();
            // $orderfetch = Order::where('id', $order->id)->with('services', 'orderdate')->first();
            // if ($setting) {
            //    Mail::to($setting->contact_email)->send(new AdminStatus($orderfetch, $user,  false));
            // }
            // Mail::to($user)->send(new UserNotification($orderfetch, $user));
    
    
    
            return response()->json([
                'success' => true,
                'type' => count($cartdatas['services']) > 0 ? 0 : 1,
            ], 200);


        } catch (\Exception $e) { 
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please contact your administrator',
                'type' => $e->getMessage()
            ], 200); 
        }  
    }
}

function Answer($request, $order_id)
{
    if (count($request->answer) > 0) {
        $answers = collect($request->answer);
        foreach ($answers as $ans) {
            $answer = new OrderQuestion();
            $answer->order_id = $order_id;
            $answer->service_id = $ans['service_id'];
            $answer->question_id = $ans['question_id'];
            $answer->option_id = $ans['option_id'];
            $answer->service_title = $ans['service_title'];
            $answer->save();
        }
    }
}
function DateTime($request, $order_id)
{
    if (count($request->datetime) > 0) {
        $datetime = collect($request->datetime);
        foreach ($datetime as $dt) {
            $d = new OrderDate();
            $d->date = $dt['date'];
            $d->time = $dt['time'];
            $d->order_id = $order_id;
            $d->save();
        }
    }
}
function OrderImage($request, $order_id)
{ 
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
            $img->order_id = $order_id;
            $img->image = "uploads/users/$request->user_id/$name";
            $img->save();
        }
    }
}