<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\SingleServiceResource;
use App\Models\Review;
use App\Models\Setting;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
    {
        $suggests_ids =  Service::whereIn('id', $request->service_id)->pluck('suggestion');
        $category_ids =  Service::whereIn('id', $request->service_id)->pluck('category_id');
        $service_id = Service::whereIn('category_id', $category_ids)->pluck('id');

        $allsuggest_ids = collect($suggests_ids)->filter()->unique();
        $arr = [];
        foreach($allsuggest_ids as $suggest_id){
            $arr[] = array_map('intval', explode(',', $suggest_id));
        }
        $suggest_collections = collect($arr)
        ->flatMap(function ($values) {
                        return $values ;
                    })->concat($service_id)->diff($request->service_id)->unique();
        if (count($suggest_collections) > 0) {
            $suggests = Service::with('serviceImage')->whereIn('id', $suggest_collections)->get();
        }
        if (!empty($suggests)) {
            return response()->json([
                'success' => true,
                'suggests' => ServiceResource::collection($suggests)
            ], 200);
        }
    }
     public function Taxes(Request $request)
    {
        $setting = Setting::first();
        if (!empty($setting)) {
            return response()->json([
                'success' => true,
                'taxes' => $setting->taxes
            ], 200);
        }
    }
    /**
     * get service by id
     *
     */
    public function getService($id)
    {
        $service =  Service::with('serviceImage', 'reviews')->where('id', $id)->first();
        if (!empty($service)) {
            return response()->json([
                'success' => true,
                'service' => new SingleServiceResource($service)
            ], 200);
        }
        return response()->json([
            'errors' => [
                "message" => 'Service not found'
            ],
        ], 404);
    }
}
