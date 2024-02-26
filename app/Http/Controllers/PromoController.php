<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
class PromoController extends Controller
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
            $data = Promo::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                // ->addColumn('category', function($row){
                //       return $row->category ? $row->category->cate_name : 'All Categories';
                // })
                ->addColumn('end_date', function($row){
                     return Carbon::parse($row->end_date)->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)"  data-remote='.route("promo.edit", $row->id).' class="edit btn btn-success btn-sm mr-2"><i class="fa fa-edit"></i></a><a href="javascript:void(0)"  data-remote='.route("promo.destroy", $row->id).' class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action','end_date'])
                ->make(true);
        }

        return view('pages.promo.promo');
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
            'percent' => 'required|integer',
            'end_date' => 'required',
        ]);
        $promo = new Promo();
         $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $res = "";
                for ($i = 0; $i < 10; $i++) {
                    $res .= $chars[mt_rand(0, strlen($chars)-1)];
                }
            $promo->code = $res ;
         $promo->percent  = $request->percent;
         $promo->end_date  =  Carbon::parse($request->end_date)->format('Y-m-d').' '. Carbon::now()->format('H:i:s');
         $promo->status  = $request->status;
        //  $promo->category_id  = $request->category_id != 0 ? $request->category_id : null;
         $promo->save();

         return redirect()->route('promo');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $promo = Promo::find($id);
        return response($promo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
           $request->validate([
                'end_date' => 'required',
                'percent' => 'required',
            ]);
            $id= $request->promo_id;
            $promo =  Promo::find($id);
            $promo->percent  = $request->percent;
            $promo->end_date  = Carbon::parse($request->end_date)->format('Y-m-d').' '. Carbon::now()->format('H:i:s');
            $promo->status  = $request->status;
            // $promo->category_id  = $request->category_id != 0 ? $request->category_id : null;
            $promo->save();

         return redirect()->route('promo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $promo = Promo::find($id);
        if ($promo) {
            $promo->delete();
             return response()->json(['message' => 'success']);
        }else{
            return response()->json(['message' => 'error']);
        }
    }
}