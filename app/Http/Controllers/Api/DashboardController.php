<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecentBookingResource;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use App\Http\Resources\BookingDetailsResource;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function FetchDatas($id)
    {
        if ($id) { 
            $booking_count = Order::where('type', 0)->where('user_id', $id)->count();
            $product_count = Order::where('type', 1)->where('user_id', $id)->count();
            $reviews_count = Review::where('user_id', $id)->count();
            $total_span = 0;
            $local = Order::where('status', 'complete')->where('payment', 'local')->where('user_id', $id)->sum('price');
            $online = Order::where('user_id', $id)->where('payment', 'online')->sum('price');

            $localAddons = Order::where('status', 'complete')->where('payment', 'local')->where('user_id', $id)->sum('addon_price');
            $onlineAddons = Order::where('user_id', $id)->where('payment', 'online')->sum('addon_price');
 

            $total_span = $local + $online + $localAddons + $onlineAddons;

            return response()->json([
                'success' => true, 
                'product_count' => $product_count,
                'booking_count' => $booking_count,
                'reviews_count' => $reviews_count,
                'total_span' => round($total_span, 2),
            ], 200);
        }
        return response()->json([
            'success' => false,
        ], 200);
    }
    public function RecentOrders($id)
    {  
        if ($id) {
            $latestRecord = Order::latest()->first();

            $datas = Order::with('address','prices', 'quantity', 'services', 'images', 'questions', 'orderdate')
                            ->where('created_at', $latestRecord->created_at)
                            ->where('user_id', $id) 
                            ->limit(2)
                            ->get(); 
                               
             $user = User::where('id', $id)->first();

             $product = $booking = '';
            
            if(count($datas) > 0){
                foreach($datas as $data){
                    if($data->type === 0){
                        $booking = $data;
                        break;
                    } 
                }
                foreach($datas as $data){
                    if($data->type === 1){
                        $product = $data;
                        break;
                    } 
                }
            }

            if ($booking || $product) {
                return response()->json([
                    'success' => true,
                    'product' => $product ? new BookingDetailsResource($product) : null,
                    'booking' => $booking ? new BookingDetailsResource($booking) : null ,
                    'user' => $user,
                ], 200);
            } 
        }
        return response()->json([
            'success' => true,
        ], 200);
    }
}