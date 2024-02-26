<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReviewController extends Controller
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
            $data = Review::with('user')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('photo', function ($row) {
                    if ($row->user) {
                        return '<img src=' . asset($row->user->photo) . ' width="40" alt="user-image">';
                    }
                    return 'No photo';
                })
                ->addColumn('username', function ($row) {
                    if ($row->user) {
                        return $row->user->first_name . ' ' . $row->user->last_name;
                    }
                    return '';
                })
                ->addColumn('email', function ($row) {
                    if ($row->user) {
                        return $row->user->email;
                    }
                    return '';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)"  data-remote=' . route("review.destroy", $row->id) . ' class="delete btn btn-danger btn-sm">Delete Review</a>';
                    return $btn;
                })
                ->rawColumns(['photo', 'username', 'email', 'action'])
                ->make(true);
        }

        return view('pages.reviews.reviews');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = Review::find($id);
        if ($review) {
            $review->delete();
            return response()->json(['message' => 'success']);
        }

        return response()->json(['message' => 'error']);
    }
}