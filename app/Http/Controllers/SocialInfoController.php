<?php

namespace App\Http\Controllers;

use App\Models\SocialInfo;
use Illuminate\Http\Request;

class SocialInfoController extends Controller
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
        $social_info = SocialInfo::first();
      return  view('pages.social-info.social-info',compact('social_info'));
    }
 
    public function update(Request $request)
    {      
        $id = $request->id;  
        
        if($id != null){ 
            $infos  = SocialInfo::first(); 
        }else{
            $infos  = new SocialInfo;  
        }

        
        if($request->icon[0] != null && $request->link[0] != null){
            $link = [];
            $i = 0;
            for($i; $i < count($request->icon); $i++){
                $link[][$request->icon[$i]] = $request->link[$i];
            } 
            $infos->social_datas= json_encode($link);
        }


        if($request->address_type[0] != null && $request->address_details[0] != null){
            $address_type = [];
            $i = 0;
            for($i; $i < count($request->address_type); $i++){
                $address_type[][$request->address_type[$i]] = $request->address_title[$i] . '|##|'. $request->address_details[$i];
            } 
               $infos->address_datas = json_encode($address_type);
        }


        if($request->service_location[0] != null){
            $service_location = [];
            $i = 0;
            for($i; $i < count($request->service_location); $i++){
                $service_location[] = $request->service_location[$i];
            } 
            $infos->service_location = json_encode($service_location);
        }

        if( $request->hrs_operation[0] != null){
            $hrs_operation = [];
            $i = 0;
            for($i; $i < count($request->hrs_operation); $i++){
              $hrs_operation[] = $request->hrs_operation[$i];
            } 
            $infos->hrs_operation  = json_encode($hrs_operation);
        }
 
       $infos->save(); 

        return redirect()->route('socialinfos');
    } 
 
}