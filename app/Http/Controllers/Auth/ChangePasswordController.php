<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ChangePasswordController extends Controller
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
    public function index()
    {
        return view('pages.change-password.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|password',
            'password' => 'required|confirmed|min:8',
        ], ['current_password.password' => 'Current password does not match! ']);

        $user = User::find(auth()->user()->id);
        $user->password = Hash::make($request->password);
        $user->save();
        Session::flash('success', 'Password has been changed!');
        return redirect()->route('changepassword');
    }
}