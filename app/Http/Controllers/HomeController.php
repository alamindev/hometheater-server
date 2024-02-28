<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_count = User::where('is_admin', 0)->get()->count();
        $order_count = Order::get()->count();
        $orders = Order::with('user', 'quantity')->where('type', 0)->orderBy('created_at', 'desc')->take(5)->get();
        $products = Order::with('user', 'quantity')->where('type', 1)->orderBy('created_at', 'desc')->take(5)->get();
        $pending_order = Order::where('status', 'pending')->orWhere('status', 'approved')->get()->count();
        $payments = Order::where('status', 'complete')->sum('price'); 
        return view('pages.index', compact('user_count', 'order_count','products', 'pending_order', 'orders', 'payments'));
    }
}