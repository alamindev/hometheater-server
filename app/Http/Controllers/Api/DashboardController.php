<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecentBookingResource;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function FetchDatas($id)
    {
        if ($id) { 
            $booking_count = Order::where('user_id', $id)->count();
            $reviews_count = Review::where('user_id', $id)->count();
            $total_span = 0;
            $local = Order::where('status', 'complete')->where('payment', 'local')->where('user_id', $id)->sum('price');
            $online = Order::where('user_id', $id)->where('payment', 'online')->sum('price');
            $total_span = $local + $online;

            return response()->json([
                'success' => true, 
                'booking_count' => $booking_count,
                'reviews_count' => $reviews_count,
                'total_span' => $total_span,
            ], 200);
        }
        return response()->json([
            'success' => false,
        ], 200);
    }
    public function RecentOrders($id)
    {
        if ($id) {
            $bookings = Order::with('quantity', 'services')->where('user_id', $id)->orderBy('created_at', 'desc')->take(5)->get(); 
            return response()->json([
                'success' => true,
                'bookings' => RecentBookingResource::collection($bookings), 
            ], 200);
        }
        return response()->json([
            'success' => false,
        ], 200);
    }
}