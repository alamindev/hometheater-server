<?php

namespace App\Http\Controllers\WebsiteAbout;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CounterController extends Controller
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
            $data = About::where('type', 'counter')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href=' . route("website.about.counter.edit", $row->id) . '  class="edit btn btn-success btn-sm mr-2"><i class="fa fa-edit"></i></a><a href="javascript:void(0)"  data-remote=' . route("website.about.counter.destroy", $row->id) . ' class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('website-about.page.counter.counter');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('website-about.page.counter.add-counter');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'counter' => 'required',
        ]);
        $counter  = new About();
        $counter->title = $request->counter;
        $counter->details = $request->title;
        $counter->type = 'counter';
        $counter->save();
        return redirect()->route('website.about.counter');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = About::where('type', 'counter')->find($id);
        return view('website-about.page.counter.edit-counter', compact('edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $counter  =   About::where('type', 'counter')->find($id);
        $counter->title = $request->counter;
        $counter->details = $request->title;
        $counter->save();
        return redirect()->route('website.about.counter');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $counter = About::where('type', 'counter')->find($id);
        if ($counter) {
            $counter->delete();
            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['message' => 'error']);
        }
    }
}