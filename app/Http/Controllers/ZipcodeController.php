<?php

namespace App\Http\Controllers;

use App\Models\Zipcode;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ZipcodeController extends Controller
{
    function __construct(Request $request)
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
            $data = Zipcode::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route("zipcode.edit", $row->id) . '"   class="btn btn-info btn-sm">Edit</a><a href="javascript:void(0)"  data-remote=' . route("zipcode.destroy", $row->id) . ' class="delete btn btn-danger btn-sm ml-1">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.zipcode.zipcode');
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
            'zipcode' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);

        $zipcode = new Zipcode;
        $zipcode->area_name  = $request->area_name;
        $zipcode->zipcode  = $request->zipcode;
        $zipcode->amount  = $request->amount;
        $zipcode->save();

        return redirect()->route('zipcode');
    }
    public function edit($id)
    {
        $edit =   Zipcode::find($id);
        return view('pages.zipcode.edit-zipcode', compact('edit'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'zipcode' => 'required|numeric',
            'amount' => 'numeric',
        ]);

        $zipcode =   Zipcode::find($id);
        $zipcode->area_name  = $request->area_name;
        $zipcode->zipcode  = $request->zipcode;
        $zipcode->amount  = $request->amount;
        $zipcode->save();

        return redirect()->route('zipcode');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $zipcode = Zipcode::find($id);
        if ($zipcode) {

            $zipcode->delete();

            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['message' => 'error']);
        }
    }
}