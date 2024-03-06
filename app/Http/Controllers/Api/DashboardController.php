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
            $total_span = $local + $online;

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
            $booking = Order::with('prices', 'quantity', 'services', 'images', 'questions', 'orderdate')->where('user_id', $id)->where('type', 0)->latest()->first();
            $product = Order::with('prices', 'quantity', 'services', 'images', 'questions', 'orderdate')->where('user_id', $id)->where('type', 1)->latest()->first();
            $user = User::where('id', $id)->first();
            if ($booking || $product) {
                return response()->json([
                    'success' => true,
                    'product' =>   new BookingDetailsResource($product),
                    'booking' => new BookingDetailsResource($booking),
                    'user' => $user,
                ], 200);
            } 
        }
        return response()->json([
            'success' => false,
        ], 200);
    }
}