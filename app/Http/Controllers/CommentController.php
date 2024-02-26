<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Comment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CommentController extends Controller
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
            $data = Comment::with('user')->latest()->get();
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
                    $btn = '<a href="javascript:void(0)"  data-remote=' . route("comment.destroy", $row->id) . ' class="delete btn btn-danger btn-sm">Delete Comment</a>';
                    return $btn;
                })
                ->rawColumns(['photo', 'username', 'email', 'action'])
                ->make(true);
        }

        return view('pages.comments.comments');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        if ($comment) {
             $activity = Activity::where('comment_id', $comment->id)->first();
            if($activity) {
                $activity->delete();
            }
            $comment->delete();
            return response()->json(['message' => 'success']);
        }

        return response()->json(['message' => 'error']);
    }
}
