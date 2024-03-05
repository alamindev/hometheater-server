<?php

namespace App\Http\Controllers;

use App\Mail\SendStatus;
use App\Models\Order;
use App\Models\OrderImage;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
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
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::with('user', 'quantity')->where('type', 0)->orderBy('created_at', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('photo', function ($row) {
                    if ($row->user->photo) {
                        return '<img src=' . asset($row->user->photo) . ' width="40" alt="user-image">';
                    }
                    return 'No photo';
                })
                ->addColumn('username', function ($row) {
                    return $row->user->first_name . ' ' . $row->user->last_name;
                })
                ->addColumn('phone', function ($row) {
                    return $row->user->phone;
                })
                ->addColumn('quantity', function ($row) {
                    return collect($row->quantity)->pluck('quantity')->sum();
                })
                ->addColumn('status', function ($row) {

                    if ($row->status == 'pending') {
                        $btn = "<span class='badge btn-yellow py-2 px-3 text-capitalize'>$row->status</span>";
                    } elseif ($row->status == 'complete') {
                        $btn = "<span class='badge btn-blue py-2 px-3 text-capitalize'>$row->status</span>";
                    } elseif ($row->status == 'approved') {
                        $btn = "<span class='badge btn-green py-2 px-3 text-capitalize'>$row->status</span>";
                    } elseif ($row->status == 'cancel') {
                        $btn = "<span class='badge btn-red py-2 px-3 text-capitalize'>$row->status</span>";
                    }
                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn = '<a href=' . route("order.details", $row->order_id) . '  class="view btn btn-info btn-blue  btn-sm mr-2">Order Details</a>';
                    if ($row->status == 'cancel') {
                        $btn = '<a href=' . route("order.details", $row->order_id) . '  class="view btn btn-info btn-blue  btn-sm mr-2">Order Details</a> <a href="javascript:void(0)"  data-remote=' . route("order.destroy", $row->id) . ' class="delete btn btn-danger btn-sm">Delete</a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'photo', 'username', 'phone', 'quantity', 'status'])
                ->make(true);
        }
        return view('pages.order.index');
    }
    public function product(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::with('user', 'quantity')->where('type',1)->orderBy('created_at', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('photo', function ($row) {
                    if ($row->user->photo) {
                        return '<img src=' . asset($row->user->photo) . ' width="40" alt="user-image">';
                    }
                    return 'No photo';
                })
                ->addColumn('username', function ($row) {
                    return $row->user->first_name . ' ' . $row->user->last_name;
                })
                ->addColumn('phone', function ($row) {
                    return $row->user->phone;
                })
                ->addColumn('quantity', function ($row) {
                    return collect($row->quantity)->pluck('quantity')->sum();
                })
                ->addColumn('status', function ($row) {

                    if ($row->status == 'pending') {
                        $btn = "<span class='badge btn-yellow py-2 px-3 text-capitalize'>$row->status</span>";
                    } elseif ($row->status == 'complete') {
                        $btn = "<span class='badge btn-blue py-2 px-3 text-capitalize'>$row->status</span>";
                    } elseif ($row->status == 'approved') {
                        $btn = "<span class='badge btn-green py-2 px-3 text-capitalize'>$row->status</span>";
                    } elseif ($row->status == 'cancel') {
                        $btn = "<span class='badge btn-red py-2 px-3 text-capitalize'>$row->status</span>";
                    }
                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn = '<a href=' . route("order.details", $row->order_id) . '  class="view btn btn-info btn-blue  btn-sm mr-2">Order Details</a>';
                    if ($row->status == 'cancel') {
                        $btn = '<a href=' . route("order.details", $row->order_id) . '  class="view btn btn-info btn-blue  btn-sm mr-2">Order Details</a> <a href="javascript:void(0)"  data-remote=' . route("order.destroy", $row->id) . ' class="delete btn btn-danger btn-sm">Delete</a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'photo', 'username', 'phone', 'quantity', 'status'])
                ->make(true);
        }
        return view('pages.order.product');
    }
    public function OrderDetails($id)
    {
        $order = Order::with('user', 'quantity', 'services', 'images', 'orderdate')->where('order_id', $id)->first();
        if ($order) {
            return view('pages.order.order-details', compact('order'));
        }
        abort(404);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $view = Service::with('serviceQuestion', 'category')->find($id);
        return view('pages.order.view-service', compact('view'));
    }
    public function UpdateStatus(Request $request)
    {
        $order = Order::with('orderdate','services')->where('id', $request->id)->first();
        $order->status = $request->status;
        $order->tracking_link = $request->tracking_link;
        $order->save();
        $user =  User::where('id', $order->user_id)->first();
        if ($request->status != 'pending') {
            Mail::to($user)->send(new SendStatus($request->status, $user, $order));
        }
        toast('Order status updated Successfully!', 'success');
        return redirect()->route('order.details', $request->order_id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if ($order) {
            $delete_images =   OrderImage::where('order_id', $order->id)->get();
            foreach ($delete_images as $image) {
                $path = public_path($image->image);
                if (\File::exists($path)) {
                    \File::delete($path);
                }
            }
            $order->delete();
            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['message' => 'error']);
        }
    }
}