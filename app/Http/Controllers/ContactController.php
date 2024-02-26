<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Services\Slug;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use Yajra\DataTables\Facades\DataTables;  

class ContactController extends Controller
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
            $data = Contact::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()   
                ->addColumn('action', function($row){
                    $btn = '<a href='.route("contact.show", $row->id).'  class="view btn btn-info btn-sm mr-2"><i class="fa fa-eye"></i></a><a href="javascript:void(0)"  data-remote='.route("contact.destroy", $row->id).' class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->addColumn('date', function($row){
                    return Carbon::parse($row->created_at)->format('d-m-Y');
                })
                ->rawColumns(['action','date'])
                ->make(true);
        }
      
        return view('pages.contact.contacts');
    }

 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $view = Contact::find($id);
        return view('pages.contact.view-contact', compact('view'));
    }

  
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $contact = Contact::find($id);
        if ($contact) { 
            $contact->delete();
             return response()->json(['message' => 'success']);
        }else{
            return response()->json(['message' => 'error']);
        }
    } 
}
