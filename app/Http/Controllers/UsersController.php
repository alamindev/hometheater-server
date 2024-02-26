<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderImage;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UsersController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with('orders')->where('is_admin', 0)->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('photo', function ($row) {
                    if ($row->photo) {
                        return '<img src=' . asset($row->photo) . ' width="40" alt="user-image">';
                    }
                    return 'No photo';
                })
                ->addColumn('orders', function ($row) {
                    return $row->orders->count();
                })
                ->addColumn('username', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href=' . route("user.edit", $row->id) . '  class="view btn btn-primary btn-sm mr-2">Edit User</a><a href=' . route("user.show", $row->id) . '  class="view btn btn-info btn-sm mr-2">View User</a> <a href="javascript:void(0)"  data-remote=' . route("user.destroy", $row->id) . ' class="delete btn btn-danger btn-sm">Delete user</a>';
                    return $btn;
                })
                ->rawColumns(['photo', 'username', 'action'])
                ->make(true);
        }

        return view('pages.user.users');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $view = User::with('orders')->where('is_admin', 0)->find($id);
        return view('pages.user.view-user', compact('view'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit =   User::find($id);
        return view('pages.user.edit', compact('edit'));
    }
    /**
     * update the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

       $user = User::find($id);
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
                    $image->save('uploads/users/' . $name, 40);

                    if ($name) {
                        $user->photo = 'uploads/users/' . $name;
                    }
                }

                $user->save();

        return redirect()->route('users');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('is_admin', 0)->find($id);
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
            return response()->json(['message' => 'success']);
        }

        return response()->json(['message' => 'error']);
    }
}
